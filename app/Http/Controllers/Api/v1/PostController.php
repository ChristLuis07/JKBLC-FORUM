<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $post = Post::with([
            "category" => function ($query) {
                $query->select("id", "name");
            },
            "user" => function ($query) {
                $query->select("id", "name", "email");
            }
        ])->select("id", "title", "category_id", "user_id", "created_at")->get();

        return response()->json([
            "message" => "Data Berhasil Di Ambil",
            "data" => $post
        ], Response::HTTP_OK);
    }

    function show($id)
    {
        $post = Post::with([
            "category" => function ($query) {
                $query->select("id", "name");
            },
            "user" => function ($query) {
                $query->select("id", "name", "email");
            },
            "comments" => function ($query) {
            $query->select("id", "content", "post_id", "user_id", "created_at");
            },
            "comments.users" => function ($query) {
                $query->select("id", "name", "email");
            },
        ])->find($id);

        if (!$post) {
            return response()->json([
                "message" => "Data Tidak Ditemukan",
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            "message" => "Data Berhasil Di Ambil",
            "data" => $post
        ]);
    }

    function store(Request $request)
    {
        $request->validate([
            "title" => "required",
            "content" => "required",
            "category_id" => "required|exists:categories,id",
        ]);

        $post = Post::create([
            "title" => $request->title,
            "content" => $request->content,
            "category_id" => $request->category_id,
            "user_id" => Auth::user()->id
        ]);

        return response()->json([
            "message" => "Data Berhasil Disimpan",
            "data" => $post
        ], Response::HTTP_CREATED);
    }

    function update(Request $request, $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json([
                "message" => "Data Tidak Ditemukan",
            ], Response::HTTP_NOT_FOUND);
        }

        if ($post->user_id !== Auth::user()->id) {
            return response()->json([
                "message" => "Permission Denied",
            ], Response::HTTP_UNAUTHORIZED);
        };

        $request->validate([
            "title" => "required",
            "content" => "required",
            "category_id" => "required|exists:categories,id",
        ]);

        $post->update([
            "title" => $request->title,
            "content" => $request->content,
            "category_id" => $request->category_id,
        ]);

        return response()->json([
            "message" => "Data Berhasil Di Update",
            "data" => $post
        ], Response::HTTP_OK);
    }

    function destroy($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json([
                "message" => "Data Tidak Ditemukan",
            ], Response::HTTP_NOT_FOUND);
        }

        if ($post->user_id !== Auth::user()->id) {
            return response()->json([
                "message" => "Permission Denied",
            ], Response::HTTP_UNAUTHORIZED);
        }

        $post->delete();

        return response()->json([
            "meessage" => 'Data Berhasil Di Hapus'
        ], Response::HTTP_OK);
    }
}

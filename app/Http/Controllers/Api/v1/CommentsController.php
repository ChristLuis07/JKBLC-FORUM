<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Comments;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function addCommentToPost(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                "message" => "Unauthorized"
            ], Response::HTTP_UNAUTHORIZED);
        }

        $request->validate([
            "content" => "required",
            "post_id" => "required|exists:posts,id"
        ]);
        $comment = Comments::create([
            "post_id" => $request->post_id,
            "content" => $request->content,
            "user_id" => Auth::user()->id,
        ]);

        return response()->json([
            "message" => "Successfully added comment to post",
            "data" => $comment
        ], Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $comment = Comments::find($id);

        $request->validate([
            "content" => "required",
        ]);

        if (!$comment) {
            return response()->json([
                "message" => "Comment not found",
            ], Response::HTTP_NOT_FOUND);
        }

        if ($comment->user_id != Auth::user()->id) {
            return response()->json([
                "message" => "Unauthorized to update this comment",
            ], Response::HTTP_UNAUTHORIZED);
        }

        $comment->update([
            "content" => $request->content,
        ]);

        return response()->json([
            "message" => "Comment updated successfully",
            "data" => $comment
        ], Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $comment = Comments::find($id);
        if (!$comment) {
            return response()->json([
                "message" => "Comment not found",
            ], Response::HTTP_NOT_FOUND);
        }
        if (Auth::user()->role !== 'admin' && $comment->user_id !== Auth::user()->id) {
            return response()->json([
                "message" => "Unauthorized to delete this post",
            ], Response::HTTP_UNAUTHORIZED);
        }
        $comment->delete();
        return response()->json([
            "message" => "Comment deleted successfully",
        ], Response::HTTP_OK);
    }
}

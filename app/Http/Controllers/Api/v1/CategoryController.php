<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // CRUD (Create, Read, Update, Delete)

    // Read
    public function index(){
        $category = Category::select("id", "name")->get(); // mengambil semua data di database (table categories)

        return response()->json([  // response jika data berhasil di simpan
            'message' => "Data Berhasil Di Ambil",
            'data' => $category
        ], Response::HTTP_OK);
    }

    // Create
    public function store(Request $request){
        $request->validate([ // validasi data
            "name" => "required|unique:categories|max:255"
        ]);

        $category = Category::create([ // proses menyimpan data
            "name" => $request->name
        ]);

        return response()->json([ // response data berhasil di simpan
            "message" => "Data Berhasil Disimpan",
            "data" => $category,
        ], Response::HTTP_CREATED); 
    }

    // Update 
    public function update(Request $request, $id){
        $request->validate([ // Validasi data
            "name" => "required|unique:categories,name,".$id."|max:255"
        ]);

        $category = Category::find($id); // cari data di database

        if (!$category) { // response jika data tidak ditemukan
            return response()->json([
                "message" => "Data tidak ditemukan",
            ], Response::HTTP_NOT_FOUND);
        }

        $category->name = $request->name;
        $category->save(); // menyimpan data

        return response()->json([ // response jika data berhasil di simpan
            "message" => "Data Berhasil Di Update",
            "data" => $category
        ], Response::HTTP_OK);
    }

    // Delete
    public function destroy($id){
        $category = Category::find($id); // mencari data sesuai id

        if (!$category) { // response jika data tidak ditemukan
            return response()->json([
                "message" => "Data Tidak Ditemukan",
            ], Response::HTTP_NOT_FOUND);
        }

        $category->delete(); // proses menghapus data

        return response()->json([ // response jika data berhasil dihapus
            "message" => "Data Berhasil Di Hapus"
        ], Response::HTTP_OK);
    }
}

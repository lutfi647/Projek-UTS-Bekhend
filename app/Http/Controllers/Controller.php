<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    // Menampilkan semua data berita
    public function index()
    {
        $news = News::all();

        // Mengecek jika data kosong
        if ($news->isEmpty()) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Menampilkan data berita jika ada
        $response = [
            'data' => $news,
            'message' => 'Berhasil menampilkan semua data berita'
        ];

        return response()->json($response, 200);
    }

    // Menambahkan data berita baru
    public function store(Request $request)
    {
        // Validasi input data
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'author' => 'required|string',
            'description' => 'required|string',
            'content' => 'required|string',
            'url' => 'required|url|unique:news',
            'url_image' => 'required|url',
            'published_at' => 'required|date',
            'category' => 'required|string'
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Data tidak lengkap atau tidak valid',
                'errors' => $validator->errors()
            ], 400);
        }

        // Menyimpan berita baru ke database
        $news = News::create($request->all());

        $response = [
            'message' => 'Berhasil menambahkan berita',
            'data' => $news
        ];

        return response()->json($response, 201);
    }

    // Memperbarui data berita
    public function update(Request $request, $id)
    {
        // Mencari berita berdasarkan ID
        $news = News::find($id);

        // Jika berita tidak ditemukan
        if (!$news) {
            return response()->json(['message' => 'Berita tidak ditemukan'], 404);
        }

        // Validasi input data yang diperbarui
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string',
            'author' => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
            'content' => 'sometimes|required|string',
            'url' => 'sometimes|required|url|unique:news,url,' . $id,
            'url_image' => 'sometimes|required|url',
            'published_at' => 'sometimes|required|date',
            'category' => 'sometimes|required|string'
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Data tidak lengkap atau tidak valid',
                'errors' => $validator->errors()
            ], 400);
        }

        // Memperbarui data berita
        $news->update($request->only([
            'title', 'author', 'description', 'content', 'url', 'url_image', 'published_at', 'category'
        ]));

        $response = [
            'message' => 'Berhasil memperbarui berita',
            'data' => $news
        ];

        return response()->json($response, 200);
    }

    // Menghapus data berita
    public function destroy($id)
    {
        // Mencari berita berdasarkan ID
        $news = News::find($id);

        // Jika berita tidak ditemukan
        if (!$news) {
            return response()->json(['message' => 'Berita tidak ditemukan'], 404);
        }

        // Menghapus data berita
        $news->delete();

        $response = [
            'message' => 'Berhasil menghapus berita',
            'data' => $news
        ];

        return response()->json($response, 200);
    }
}

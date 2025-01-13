<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;

 class BukuController extends Controller
 {
     // GET - Menampilkan daftar buku
     public function index()
     {
         $bukus = Buku::all();
         return response()->json([
             'success' => true,
             'data' => $bukus
         ]);
     }

     // GET per ID - Menampilkan detail buku
     public function show($id)
     {
         $buku = Buku::find($id);

         if (!$buku) {
             return response()->json([
                 'success' => false,
                 'message' => 'Buku not found.'
             ], 404);
         }

         return response()->json([
             'success' => true,
             'data' => $buku
         ]);
     }

     // POST - Menyimpan buku baru
     public function store(Request $request)
     {
         $request->validate([
             'judul_buku' => 'required|string|max:255',
             'deskripsi_buku' => 'nullable|string',
             'harga_buku' => 'nullable|string',
             'cover_buku' => 'nullable|image|max:2048'
         ]);

         $imagePath = $request->file('cover_buku')
             ? $request->file('cover_buku')->store('images', 'public')
             : null;

         $buku = Buku::create([
             'judul_buku' => $request->judul_buku,
             'deskripsi_buku' => $request->deskripsi_buku,
             'harga_buku' => $request->harga_buku,
             'cover_buku' => $imagePath
         ]);

         return response()->json([
             'success' => true,
             'message' => 'Buku berhasil ditambahkan.',
             'data' => $buku
         ]);
     }

     // PUT - Menyimpan perubahan pada buku
     public function update(Request $request, $id)
     {
         $request->validate([
             'judul_buku' => 'required|string|max:255',
             'deskripsi_buku' => 'nullable|string',
             'harga_buku' => 'nullable|string',
             'cover_buku' => 'nullable|image|max:2048'
         ]);

         $buku = Buku::find($id);

         if (!$buku) {
             return response()->json([
                 'success' => false,
                 'message' => 'Buku not found.'
             ], 404);
         }

         if ($request->file('cover_buku')) {
             $imagePath = $request->file('cover_buku')->store('images', 'public');
             $buku->cover_buku = $imagePath;
         }

         $buku->update([
             'judul_buku' => $request->judul_buku,
             'deskripsi_buku' => $request->deskripsi_buku,
             'harga_buku' => $request->harga_buku,
             'cover_buku' => $imagePath
         ]);

         return response()->json([
             'success' => true,
             'message' => 'Buku berhasil diperbarui.',
             'data' => $buku
         ]);
     }

     // DELETE - Menghapus buku
     public function destroy($id)
     {
         $buku = Buku::find($id);

         if (!$buku) {
             return response()->json([
                 'success' => false,
                 'message' => 'Buku not found.'
             ], 404);
         }

         $buku->delete();

         return response()->json([
             'success' => true,
             'message' => 'Buku berhasil dihapus.'
         ]);
     }
 }
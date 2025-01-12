<?php
namespace App\Http\Controllers;

 use Illuminate\Http\Request;
 use App\Models\Akun;

 class AkunController extends Controller
 {
     // GET - Menampilkan daftar akun
     public function index()
     {
         $akuns = Akun::all();
         return response()->json([
             'success' => true,
             'data' => $akuns
         ]);
     }

     // GET per ID - Menampilkan detail akun
     public function show($id)
     {
         $akun = Akun::find($id);

         if (!$akun) {
             return response()->json([
                 'success' => false,
                 'message' => 'Akun not found.'
             ], 404);
         }

         return response()->json([
             'success' => true,
             'data' => $akun
         ]);
     }

     // POST - Menyimpan akun baru
     public function store(Request $request)
     {
         $request->validate([
             'name' => 'required|string|max:255',
             'email' => 'required|string|max:255',
             'password' => 'required|string|max:255',
             'role' => 'required|string|max:255'
         ]);

         $akun = Akun::create([
             'name' => $request->name,
             'email' => $request->email,
             'password' => $request->password,
             'role' => $request->role
         ]);

         return response()->json([
             'success' => true,
             'message' => 'Akun berhasil ditambahkan.',
             'data' => $akun
         ]);
     }

     // PUT - Menyimpan perubahan pada akun
     public function update(Request $request, $id)
     {
         $request->validate([
             'name' => 'required|string|max:255',
             'email' => 'required|string|max:255',
             'password' => 'required|string|max:255',
             'role' => 'required|string|max:255'
         ]);

         $akun = Akun::find($id);

         if (!$akun) {
             return response()->json([
                 'success' => false,
                 'message' => 'Akun not found.'
             ], 404);
         }

         $akun->update([
             'judul' => $request->judul,
             'deskripsi' => $request->deskripsi,
         ]);

         return response()->json([
             'success' => true,
             'message' => 'Akun berhasil diperbarui.',
             'data' => $akun
         ]);
     }

     // DELETE - Menghapus akun
     public function destroy($id)
     {
         $akun = Akun::find($id);

         if (!$akun) {
             return response()->json([
                 'success' => false,
                 'message' => 'Akun not found.'
             ], 404);
         }

         $akun->delete();

         return response()->json([
             'success' => true,
             'message' => 'Akun berhasil dihapus.'
         ]);
     }
 }
<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Category;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Category::all();
        return ResponseHelper::success('List Kategori', $kategori);
    }
    public function create(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);
        $kategori = Category::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return ResponseHelper::success('List of kategori', $kategori);
    }
    public function delete($id)
    {
        $kategori = Category::find($id);

        if (!$kategori) {
            return ResponseHelper::error('kategori tidak ditemukan', 404);
        }

        $kategori->delete();

        return ResponseHelper::success('Kategori berhasil di hapus');
    }
    public function update(Request $request, $id)
    {
        $kategori = Category::find($id);

        if (!$kategori) {
            return ResponseHelper::error('Kategori tidak ditemukan', 404);
        }

        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $kategori->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return ResponseHelper::success('Category updated successfully', $kategori);
    }
}

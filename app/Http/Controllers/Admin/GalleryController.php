<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->paginate(10);
        return view('admin.galleries.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.galleries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi,webm,mkv|max:50000', // Imágenes y videos permitidos
            'type' => 'required|in:image,video'
        ]);

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/gallery'), $filename);

        Gallery::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => 'uploads/gallery/' . $filename,
            'type' => $request->type,
        ]);

        return redirect()->route('admin.galleries.index')->with('success', 'Publicación creada exitosamente.');
    }

    public function destroy(Gallery $gallery)
    {
        // Borrar el archivo físico de public
        $fullPath = public_path($gallery->file_path);
        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }

        $gallery->delete();
        return redirect()->route('admin.galleries.index')->with('success', 'Publicación eliminada correctamente.');
    }
}
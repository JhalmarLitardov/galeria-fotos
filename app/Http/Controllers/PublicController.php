<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Setting;

class PublicController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->get();
        $settings = Setting::pluck('value', 'key'); // Obtener configuraciones (logo, favicon, etc.)
        
        return view('welcome', compact('galleries', 'settings'));
    }
}

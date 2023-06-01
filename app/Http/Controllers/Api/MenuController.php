<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    // Fungsi untuk mendapatkan daftar menu
    public function index()
    {
        // Mengambil data menu dari database dengan kolom yang dipilih: IdMenu, Price, dan Image
        $menus = Menu::select('IdMenu', 'Price', 'Image')->get();

        // Kirimkan respons dalam format JSON dengan data menu
        return response()->json([
            'data' => $menus,
        ]);
    }
}

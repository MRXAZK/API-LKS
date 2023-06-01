<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Fungsi untuk registrasi pengguna baru
    public function register(Request $request)
    {
        // Rule validasi untuk data yang diterima
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:customer,Email',
            'phone' => 'required|string|max:11',
            'password' => 'required|string|min:8'
        ]);

        // Jika validasi gagal, kirimkan respons dengan error validasi
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        // Buat pengguna baru
        $customer = Customer::create([
            'Name' => $request->name,
            'Email' => $request->email,
            'Phone' => $request->phone,
            'Password' => Hash::make($request->password)
        ]);

        // Buat token akses untuk pengguna
        $token = $customer->createToken('auth_token')->plainTextToken;

        // Kirimkan respons dengan data pengguna dan token akses
        return response()->json([
            'data' => $customer,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    // Fungsi untuk proses login pengguna
    public function login(Request $request)
    {
        // Rule validasi untuk data yang diterima
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:255',
            'password' => 'required|string|min:8'
        ]);

        // Jika validasi gagal, kirimkan respons dengan error validasi
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        // Periksa apakah pengguna dengan email tersebut ada
        $customer = Customer::where('Email', $request->email)->first();

        // Jika pengguna tidak ditemukan atau password tidak cocok, kirimkan respons dengan pesan error
        if (!$customer || !Hash::check($request->password, $customer->Password)) {
            return response()->json(['message' => 'Invalid credentials']);
        }

        // Buat token akses untuk pengguna
        $token = $customer->createToken('auth_token')->plainTextToken;

        // Kirimkan respons dengan data pengguna dan token akses
        return response()->json([
            'data' => $customer,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    // Fungsi untuk proses logout pengguna
    public function logout()
    {
        // Hapus semua token akses yang terkait dengan pengguna yang sedang login
        Auth::user()->tokens()->delete();

        // Kirimkan respons dengan pesan sukses logout
        return response()->json([
            'message' => 'Logout success'
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DetailOrder;
use App\Models\Order;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        // Validasi input menggunakan Validator
        $validator = Validator::make($request->all(), [
            'idmenu' => 'required',
            'quantity' => 'required',
        ]);

        // Jika validasi gagal, kirimkan respon dengan error 422
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Mendapatkan ID customer yang sedang terautentikasi
        $customerId = Auth::id();

        // Mendapatkan ID menu dan kuantitas dari request
        $menuIds = $request->input('idmenu');
        $quantities = $request->input('quantity');

        // Jika ID menu atau kuantitas tidak berupa array, konversi ke array
        if (!is_array($menuIds)) {
            $menuIds = [$menuIds];
            $quantities = [$quantities];
        }

        // Membuat entitas Order baru
        $order = Order::create([
            'IdCustomer' => $customerId,
            'Payment' => 0,
            'SubTotal' => 0,
        ]);

        $subtotal = 0;

        // Melakukan perulangan untuk setiap ID menu dan kuantitas
        foreach ($menuIds as $index => $menuId) {
            $quantity = $quantities[$index];

            // Mencari menu berdasarkan ID
            $menu = Menu::find($menuId);

            // Jika menu tidak ditemukan, kirimkan respon dengan error 404
            if (!$menu) {
                return response()->json(['message' => 'Menu not found'], 404);
            }

            // Menghitung harga total untuk menu tersebut
            $price = $menu->Price;
            $subtotal += $price * $quantity;

            // Membuat entitas DetailOrder baru
            DetailOrder::create([
                'IdOrder' => $order->IdOrder,
                'IdMenu' => $menuId,
                'Quantity' => $quantity,
                'Price' => $price,
            ]);
        }

        // Mengupdate subtotal order
        $order->update(['SubTotal' => $subtotal]);

        // Mengirimkan respon sukses dengan status 201 dan total harga
        return response()->json(['message' => 'Order created successfully', 'total_price' => $subtotal], 201);
    }

    public function getOrder($orderId = null)
    {
        // Mendapatkan ID customer yang sedang terautentikasi
        $customerId = Auth::id();

        // Jika orderId tidak diberikan, maka ambil semua pesanan milik customer
        if ($orderId === null) {
            $orders = Order::where('IdCustomer', $customerId)->with('details.menu')->get();

            // Mengirimkan respon dengan data pesanan dalam format JSON
            return response()->json(['data' => $orders]);
        }

        // Jika orderId diberikan, maka cari pesanan spesifik
        $order = Order::where('IdOrder', $orderId)->where('IdCustomer', $customerId)->with('details.menu')->first();

        // Jika pesanan tidak ditemukan, kirimkan respon dengan error 404
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Mengirimkan respon dengan data pesanan dalam format JSON
        return response()->json(['data' => $order]);
    }


    public function destroy($orderId)
    {
        // Mendapatkan ID customer yang sedang terautentikasi
        $customerId = Auth::id();

        // Mencari pesanan (order) dengan ID yang diberikan, yang juga dimiliki oleh customer dengan ID tersebut
        $order = Order::where('IdOrder', $orderId)->where('IdCustomer', $customerId)->first();

        // Jika pesanan tidak ditemukan, kirimkan respon dengan error 404
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Menghapus pesanan (order)
        $order->delete();

        // Mengirimkan respon dengan pesan sukses dalam format JSON
        return response()->json(['message' => 'Order deleted successfully']);
    }
}

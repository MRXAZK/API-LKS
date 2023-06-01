<?php

namespace App\Models; // Namespace untuk model ini

use Illuminate\Database\Eloquent\Factories\HasFactory; // Menggunakan trait HasFactory untuk model ini
use Illuminate\Database\Eloquent\Model; // Menggunakan kelas Model dari framework

class Menu extends Model // Mendefinisikan kelas Menu yang mewarisi Model
{
    use HasFactory; // Menggunakan trait HasFactory pada kelas Menu

    protected $table = 'menu'; // Nama tabel yang digunakan untuk model ini

    protected $primaryKey = 'IdMenu'; // Nama kolom sebagai primary key pada tabel

    protected $fillable = [ // Daftar kolom yang dapat diisi pada model ini
        'Name',
        'Price',
        'Image',
    ];
}

<?php

namespace App\Models; // Namespace untuk model ini

use Illuminate\Database\Eloquent\Factories\HasFactory; // Menggunakan trait HasFactory untuk model ini
use Illuminate\Database\Eloquent\Model; // Menggunakan kelas Model dari framework
use Illuminate\Foundation\Auth\User as Authenticatable; // Menggunakan kelas User sebagai autentikasi
use Laravel\Sanctum\HasApiTokens; // Menggunakan trait HasApiTokens dari package Laravel Sanctum

class Customer extends Authenticatable // Mendefinisikan kelas Customer yang mewarisi Authenticatable
{
    use HasApiTokens, HasFactory; // Menggunakan trait HasApiTokens dan HasFactory pada kelas Customer

    protected $table = 'customer'; // Nama tabel yang digunakan untuk model ini

    protected $primaryKey = 'IdCustomer'; // Nama kolom sebagai primary key pada tabel

    protected $fillable = [ // Daftar kolom yang dapat diisi pada model ini
        'Name',
        'Email',
        'Phone',
        'Password',
    ];

    protected $hidden = [ // Daftar kolom yang disembunyikan pada respons JSON
        'Password',
        'remember_token',
    ];
}

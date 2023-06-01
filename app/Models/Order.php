<?php

namespace App\Models; // Namespace untuk model ini

use Illuminate\Database\Eloquent\Factories\HasFactory; // Menggunakan trait HasFactory untuk model ini
use Illuminate\Database\Eloquent\Model; // Menggunakan kelas Model dari framework

class Order extends Model // Mendefinisikan kelas Order yang mewarisi Model
{
    use HasFactory; // Menggunakan trait HasFactory pada kelas Order

    protected $table = 'order'; // Nama tabel yang digunakan untuk model ini

    protected $primaryKey = 'IdOrder'; // Nama kolom sebagai primary key pada tabel

    protected $fillable = [ // Daftar kolom yang dapat diisi pada model ini
        'IdCustomer',
        'Payment',
        'SubTotal',
    ];

    public function details() // Mendefinisikan relasi dengan model DetailOrder
    {
        return $this->hasMany(DetailOrder::class, 'IdOrder');
    }
}

<?php

namespace App\Models; // Namespace untuk model ini

use Illuminate\Database\Eloquent\Factories\HasFactory; // Menggunakan trait HasFactory untuk model ini
use Illuminate\Database\Eloquent\Model; // Menggunakan kelas Model dari framework

class DetailOrder extends Model // Mendefinisikan kelas DetailOrder yang mewarisi Model
{
    use HasFactory; // Menggunakan trait HasFactory pada kelas DetailOrder

    protected $table = 'detailorder'; // Nama tabel yang digunakan untuk model ini

    protected $primaryKey = 'IdDetail'; // Nama kolom sebagai primary key pada tabel

    protected $fillable = [ // Daftar kolom yang dapat diisi pada model ini
        'IdOrder',
        'IdMenu',
        'Quantity',
        'Price',
    ];

    public function menu() // Mendefinisikan relasi dengan model Menu
    {
        return $this->belongsTo(Menu::class, 'IdMenu');
    }
}

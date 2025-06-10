<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class cliente extends Model
{
    use HasFactory;

    protected $table = "cliente";
    protected $fillable =
    [
        "id",
        "rut",
        "tipo",
        "nombre",
        "correo",
        "telefono",
        "direccion",
        "status"
    ];
}

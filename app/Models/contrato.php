<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class contrato extends Model
{
    use HasFactory;

    protected $table = "contrato";
    protected $fillable =
    [
        "id",
        "id_usuario",
        "original_name",
        "file_name",
        "file_route",
        "format",
        'created_at',
        'updated_at'
    ];
}

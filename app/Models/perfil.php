<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class perfil extends Model
{
    use HasFactory;

    protected $table = 'perfil';

    protected $fillable = [
        'perfil',
        'status',
        'permisos',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'permisos' => 'array',
    ];
}

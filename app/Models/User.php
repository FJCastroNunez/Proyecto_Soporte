<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // 👉 Indicar la tabla correcta
    protected $table = 'usuario';

    protected $fillable = [
        'nombre',
        'email',
        'contraseña',
    ];

    public function getAuthPassword()
    {
        return $this->contraseña;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\contrato;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;  // <- Esta es la clave
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;

class usuario extends Authenticatable implements CanResetPassword
{
    use Notifiable, CanResetPasswordTrait;

    protected $table = 'usuario';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'nombre',
        'email',
        'password',
        'perfil_id',
        'telefono',
        'especializacion',
        'fecha_incorporacion',
        'estado',
        'created_at',
        'updated_at'
    ];


    // Indicarle a Laravel que el campo 'contraseña' se usa en vez de 'password'
    public function getAuthPassword()
    {
        return $this->contraseña;
    }

    // Mutador para que al asignar password, se guarde en 'contraseña'
    public function setPasswordAttribute($value)
    {
        $this->attributes['contraseña'] = bcrypt($value);
    }


    // Relaciones

    public function perfil()
    {
        return $this->belongsTo(perfil::class, 'perfil_id');
    }

    public function contratos()
    {
        return $this->hasMany(contrato::class, 'id_usuario');
    }
}

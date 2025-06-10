<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class historial extends Model
{
    protected $table = 'historial';

    protected $fillable = [
        'id_usuario',
        'id_ticket',
        'comentario',
        'created_at',
        'updated_at',
    ];

    protected $dates = ['created_at', 'updated_at'];

    // Si planeas relacionar con tickets
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'id_ticket');
    }
}

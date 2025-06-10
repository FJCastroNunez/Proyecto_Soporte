<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class archivo_adjunto extends Model
{
    protected $table = 'adjunto_ticket';

    protected $fillable = [
        'id_ticket',
        'id_usuario',
        'original_name',
        'file_name',
        'file_route',
        'format',
        'created_at',
        'updated_at',
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'id_ticket');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}

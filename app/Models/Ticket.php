<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'ticket';

    protected $fillable = [
        'id_creador',
        'asignado',
        'descripcion',
        'tipo_problema',
        'urgencia',
        'id_cliente',
        'estado',
        'cierre',
        'razon_cierre',
        'created_at',
        'updated_at',
    ];

    protected $dates = ['cierre', 'created_at', 'updated_at'];

    // Relaciones sugeridas:
    public function creador()
    {
        return $this->belongsTo(Usuario::class, 'id_creador');
    }

    public function asignadoUsuario()
    {
        return $this->belongsTo(Usuario::class, 'asignado');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    public function adjuntos()
    {
        return $this->hasMany(archivo_adjunto::class, 'id_ticket');
    }

    public function historial()
    {
        return $this->hasMany(Historial::class, 'id_ticket');
    }

    public function getDiasHabilesRestantesAttribute()
    {
        $fechaCreacion = Carbon::parse($this->created_at);
        $diasHabiles = 0;
        $fechaLimite = $fechaCreacion->copy();

        // Avanzar 5 días hábiles
        while ($diasHabiles < 5) {
            $fechaLimite->addDay();
            if (!$fechaLimite->isWeekend()) {
                $diasHabiles++;
            }
        }

        // Calcular días hábiles restantes desde hoy
        $hoy = Carbon::now();
        $diasRestantes = 0;
        $periodo = CarbonPeriod::create($hoy, $fechaLimite);
        foreach ($periodo as $date) {
            if (!$date->isWeekend()) {
                $diasRestantes++;
            }
        }

        return max($diasRestantes - 1, 0);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Ticket;
use App\Models\Cliente;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        $notificaciones = [];
        $count = 0;

        if ($user->perfil_id == 1) { // Administrador
            $clientesNuevos = Cliente::whereDate('created_at', Carbon::today())->count();
            if ($clientesNuevos > 0) {
                $notificaciones[] = "Se han creado $clientesNuevos nuevos clientes hoy.";
                $count++;
            }
        } else {
            $ticketsPorVencer = Ticket::where('asignado', $user->id)
                ->where('estado', 1)
                ->whereDate('created_at', '<=', Carbon::now()->subDays(2))
                ->count();

            $ticketsVencidos = Ticket::where('asignado', $user->id)
                ->where('estado', 1)
                ->whereDate('created_at', '<=', Carbon::now()->subDays(5))
                ->count();

            if ($ticketsPorVencer > 0) {
                $notificaciones[] = "Tienes $ticketsPorVencer tickets por vencer.";
                $count++;
            }

            if ($ticketsVencidos > 0) {
                $notificaciones[] = "Tienes $ticketsVencidos tickets vencidos.";
                $count++;
            }
        }

        session(['notificaciones' => $notificaciones, 'notificaciones_count' => $count]);

        return view('home');
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Redirige después de login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Constructor del controlador.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * ⚙️ Indica el campo que se usará como identificador.
     * Puedes cambiarlo a 'nombre' si usas ese campo para login.
     */
    public function username()
    {
        return 'email'; // o 'nombre'
    }



    protected function authenticated($request, $user)
    {
        if ($user->perfil_id == 1) {
            return redirect()->route('usuarios.index');
        } else {
            return redirect()->route('tickets.index');
        }
    }
}

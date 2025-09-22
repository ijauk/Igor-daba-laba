<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use function Laravel\Prompts\password;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function obrada(Request $request)
    {
        // obrada prijave
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:4'
        ], [
            'email.required' => 'Molimo unesite email',
            'email.email' => 'Molimo unesite validnu email adresu',
            'password.required' => 'Molimo unesite lozinku',
            'password.min' => 'Lozinka mora imati minimalno 4 znaka',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(url('/'));
        } else {
            return back()->withErrors('Molimo pokušajte ponovno')->onlyInput('email');
        }
    }
    public function odjava(Request $request)
{
    Auth::logout();

    // poništi session i regeneriraj CSRF token
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/prijava');
}
}
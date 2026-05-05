<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{
    public function registrar(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|max:50',
            'apellidos' => 'required|max:100',
            'pasaporte' => 'required|max:30|unique:clientes,pasaporte',
            'nacionalidad' => 'required|max:50',
            'correo' => 'required|email|max:100|unique:clientes,correo',
            'telefono' => 'required|max:20',
            'tarjeta' => 'required|max:30',
            'ccv' => 'required|min:3|max:4',
            'fecha_vencimiento' => 'required|date',
            'password' => 'required|min:4|confirmed',
        ]);

        $cliente = Cliente::create([
            'nombre' => $datos['nombre'],
            'apellidos' => $datos['apellidos'],
            'pasaporte' => $datos['pasaporte'],
            'nacionalidad' => $datos['nacionalidad'],
            'correo' => $datos['correo'],
            'telefono' => $datos['telefono'],
            'tarjeta' => $datos['tarjeta'],
            'ccv' => $datos['ccv'],
            'fecha_vencimiento' => $datos['fecha_vencimiento'],
            'password' => Hash::make($datos['password']),
        ]);

        session([
            'cliente_id' => $cliente->id,
            'cliente_nombre' => $cliente->nombre,
        ]);

        return redirect()->route('acceso')->with('success', 'Registro realizado correctamente. Ya puede acceder al sistema de compra.');
    }

    public function login(Request $request)
    {
        if (!$request->correo || !$request->password) {
            return redirect()->route('acceso')->with('error_login', 'Debe ingresar correo y contraseña.');
        }

        $cliente = Cliente::where('correo', $request->correo)->first();

        if (!$cliente || !Hash::check($request->password, $cliente->password)) {
            return redirect()->route('acceso')->with('error_login', 'Correo o contraseña incorrectos.');
        }

        session([
            'cliente_id' => $cliente->id,
            'cliente_nombre' => $cliente->nombre,
        ]);

        return redirect()->route('compra.index');
    }

    public function logout()
    {
        session()->forget(['cliente_id', 'cliente_nombre']);

        return redirect('/')->with('success', 'Sesión cerrada correctamente.');
    }
}
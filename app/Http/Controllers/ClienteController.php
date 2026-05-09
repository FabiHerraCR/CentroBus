<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{
    public function registrar(Request $request): RedirectResponse
    {
        if (session()->has('cliente_id')) {
            return redirect()
                ->route('compra.index')
                ->with('success', 'Ya tiene una sesión iniciada. No necesita registrarse nuevamente.');
        }

        $request->merge([
            'tarjeta' => preg_replace('/\D+/', '', (string) $request->input('tarjeta')),
            'ccv' => preg_replace('/\D+/', '', (string) $request->input('ccv')),
            'telefono' => $this->formatearTelefono((string) $request->input('telefono')),
        ]);

        $datos = $request->validate([
            'nombre' => 'required|max:50',
            'apellidos' => 'required|max:100',
            'pasaporte' => 'required|max:30|unique:clientes,pasaporte',
            'nacionalidad' => 'required|max:50',
            'correo' => 'required|email|max:100|unique:clientes,correo',
            'telefono' => 'required|regex:/^\d{4}-\d{4}$/',
            'tarjeta' => [
                'required',
                'digits_between:13,19',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    if (! $this->tarjetaReconocida((string) $value)) {
                        $fail('La tarjeta debe ser Visa, Mastercard o American Express.');
                    }
                },
            ],
            'ccv' => 'required|digits_between:3,4',
            'fecha_vencimiento' => [
                'required',
                'regex:/^(0[1-9]|1[0-2])\/\d{2}$/',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    [$mes, $anio] = explode('/', (string) $value);
                    $fechaVencimiento = '20'.$anio.'-'.$mes;

                    if ($fechaVencimiento < now()->format('Y-m')) {
                        $fail('La fecha de vencimiento no puede ser anterior al mes actual.');
                    }
                },
            ],
            'password' => 'required|min:4|confirmed',
        ], [
            'required' => 'El campo :attribute es obligatorio.',
            'max' => 'El campo :attribute no debe tener más de :max caracteres.',
            'email' => 'El campo :attribute debe ser un correo electrónico válido.',
            'unique' => 'El :attribute ya está registrado.',
            'digits_between' => 'El campo :attribute debe tener entre :min y :max dígitos.',
            'regex' => 'El campo :attribute debe tener formato MM/AA.',
            'telefono.regex' => 'El campo teléfono debe tener formato XXXX-XXXX.',
            'fecha_vencimiento.regex' => 'El campo fecha de vencimiento debe tener formato MM/AA.',
            'min' => 'El campo :attribute debe tener al menos :min caracteres.',
            'confirmed' => 'La confirmación de :attribute no coincide.',
        ], [
            'nombre' => 'nombre',
            'apellidos' => 'apellidos',
            'pasaporte' => 'pasaporte',
            'nacionalidad' => 'nacionalidad',
            'correo' => 'correo electrónico',
            'telefono' => 'teléfono',
            'tarjeta' => 'tarjeta',
            'ccv' => 'CCV',
            'fecha_vencimiento' => 'fecha de vencimiento',
            'password' => 'contraseña',
        ]);

        $cliente = Cliente::create([
            'nombre' => $datos['nombre'],
            'apellidos' => $datos['apellidos'],
            'pasaporte' => $datos['pasaporte'],
            'nacionalidad' => $datos['nacionalidad'],
            'correo' => $datos['correo'],
            'telefono' => $datos['telefono'],
            'tarjeta' => $this->enmascararTarjeta($datos['tarjeta']),
            'ccv' => $this->enmascararCcv($datos['ccv']),
            'fecha_vencimiento' => $this->fechaVencimientoParaBaseDeDatos($datos['fecha_vencimiento']),
            'password' => Hash::make($datos['password']),
        ]);

        session([
            'cliente_id' => $cliente->id,
            'cliente_nombre' => $cliente->nombre,
        ]);

        return redirect()->route('acceso')->with('success', 'Registro realizado correctamente. Ya puede acceder al sistema de compra.');
    }

    public function login(Request $request): RedirectResponse
    {
        if (! $request->correo || ! $request->password) {
            return redirect()->route('acceso')->with('error_login', 'Debe ingresar correo y contraseña.');
        }

        $cliente = Cliente::where('correo', $request->correo)->first();

        if (! $cliente || ! Hash::check($request->password, $cliente->password)) {
            return redirect()->route('acceso')->with('error_login', 'Correo o contraseña incorrectos.');
        }

        session([
            'cliente_id' => $cliente->id,
            'cliente_nombre' => $cliente->nombre,
        ]);

        return redirect()->route('compra.index');
    }

    public function logout(): RedirectResponse
    {
        session()->forget(['cliente_id', 'cliente_nombre']);

        return redirect('/')->with('success', 'Sesión cerrada correctamente.');
    }

    private function enmascararTarjeta(string $tarjeta): string
    {
        $digitos = preg_replace('/\D+/', '', $tarjeta);

        return '**** **** **** '.substr($digitos, -4);
    }

    private function enmascararCcv(string $ccv): string
    {
        return str_repeat('*', strlen($ccv));
    }

    private function formatearTelefono(string $telefono): string
    {
        $digitos = substr(preg_replace('/\D+/', '', $telefono), 0, 8);

        if (strlen($digitos) <= 4) {
            return $digitos;
        }

        return substr($digitos, 0, 4).'-'.substr($digitos, 4);
    }

    private function fechaVencimientoParaBaseDeDatos(string $fechaVencimiento): string
    {
        [$mes, $anio] = explode('/', $fechaVencimiento);

        return '20'.$anio.'-'.$mes.'-01';
    }

    private function tarjetaReconocida(string $tarjeta): bool
    {
        $digitos = preg_replace('/\D+/', '', $tarjeta);
        $longitud = strlen($digitos);

        if (preg_match('/^4/', $digitos) === 1 && in_array($longitud, [13, 16, 19], true)) {
            return true;
        }

        if (preg_match('/^3[47]\d{13}$/', $digitos) === 1) {
            return true;
        }

        if ($longitud !== 16) {
            return false;
        }

        $primerosDos = (int) substr($digitos, 0, 2);
        $primerosCuatro = (int) substr($digitos, 0, 4);

        return ($primerosDos >= 51 && $primerosDos <= 55)
            || ($primerosCuatro >= 2221 && $primerosCuatro <= 2720);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Ruta;
use App\Models\Cliente;
use App\Models\Tiquete;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class TiqueteController extends Controller
{
    public function comprar(Request $request)
    {
        if (!session()->has('cliente_id')) {
            return redirect('/#acceso')->with('error_login', 'Debe iniciar sesión para comprar pasajes.');
        }

        $datos = $request->validate([
            'ruta_id' => 'required|exists:rutas,id',
            'fecha_viaje' => 'required|date|after_or_equal:today|before_or_equal:' . now()->addDays(7)->format('Y-m-d'),
            'cantidad' => 'required|integer|min:1|max:5',
        ]);

        $clienteId = session('cliente_id');

        $tiquetesComprados = Tiquete::where('cliente_id', $clienteId)->count();

        if (($tiquetesComprados + $datos['cantidad']) > 5) {
            return redirect()
                ->route('compra.index')
                ->with('error', 'Una persona no puede comprar más de 5 pasajes en total.');
        }

        $ruta = Ruta::findOrFail($datos['ruta_id']);

        $tiqueteIds = [];

        for ($i = 1; $i <= $datos['cantidad']; $i++) {
            do {
                $codigo = 'CB-' . strtoupper(Str::random(8));
            } while (Tiquete::where('codigo', $codigo)->exists());

            $tiquete = Tiquete::create([
                'cliente_id' => $clienteId,
                'ruta_id' => $ruta->id,
                'fecha_viaje' => $datos['fecha_viaje'],
                'codigo' => $codigo,
                'precio' => $ruta->precio,
            ]);

            $tiqueteIds[] = $tiquete->id;
        }

        session(['tiquetes_compra' => $tiqueteIds]);

       return redirect()
         ->route('compra.index')
         ->with('success_compra', 'Compra realizada correctamente. El comprobante PDF fue generado.')
         ->with('abrir_pdf', true);
    }

    public function comprobante()
    {
        if (!session()->has('cliente_id')) {
            return redirect('/#acceso')->with('error_login', 'Debe iniciar sesión para ver el comprobante.');
        }

        if (!session()->has('tiquetes_compra')) {
            return redirect()
                ->route('compra.index')
                ->with('error', 'No hay una compra reciente para generar comprobante.');
        }

        $cliente = Cliente::findOrFail(session('cliente_id'));

        $tiquetes = Tiquete::with('ruta')
            ->whereIn('id', session('tiquetes_compra'))
            ->get();

        $pdf = Pdf::loadView('pdf.comprobante', compact('cliente', 'tiquetes'));

        return $pdf->stream('comprobante-centrobus.pdf');
    }

    public function comprobanteIndividual(Tiquete $tiquete)
{
    if (!session()->has('cliente_id')) {
        return redirect('/#acceso')->with('error_login', 'Debe iniciar sesión para ver el comprobante.');
    }

    if ($tiquete->cliente_id != session('cliente_id')) {
        abort(403, 'No tiene permiso para ver este comprobante.');
    }

    $cliente = Cliente::findOrFail(session('cliente_id'));

    $tiquete->load('ruta');

    $tiquetes = collect([$tiquete]);

    $pdf = Pdf::loadView('pdf.comprobante', compact('cliente', 'tiquetes'));

    return $pdf->stream('comprobante-' . $tiquete->codigo . '.pdf');
}

}
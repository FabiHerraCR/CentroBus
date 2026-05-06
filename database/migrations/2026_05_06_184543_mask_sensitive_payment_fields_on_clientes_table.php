<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('clientes')
            ->select(['id', 'tarjeta', 'ccv'])
            ->orderBy('id')
            ->get()
            ->each(function (object $cliente): void {
                DB::table('clientes')
                    ->where('id', $cliente->id)
                    ->update([
                        'tarjeta' => $this->enmascararTarjeta((string) $cliente->tarjeta),
                        'ccv' => $this->enmascararCcv((string) $cliente->ccv),
                    ]);
            });
    }

    public function down(): void
    {
        // Los datos originales no se restauran porque fueron enmascarados por seguridad.
    }

    private function enmascararTarjeta(string $tarjeta): string
    {
        $digitos = preg_replace('/\D+/', '', $tarjeta);

        if (strlen($digitos) < 4) {
            return '****';
        }

        return '**** **** **** '.substr($digitos, -4);
    }

    private function enmascararCcv(string $ccv): string
    {
        if (str_contains($ccv, '*')) {
            return $ccv;
        }

        $digitos = preg_replace('/\D+/', '', $ccv);

        if ($digitos === '') {
            return '***';
        }

        return str_repeat('*', strlen($digitos));
    }
};

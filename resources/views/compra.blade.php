<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra de Pasajes - CentroBus</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-950 text-white">

    <header class="border-b border-white/10 bg-slate-950">
        <nav class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5">
            <div>
                <h1 class="text-2xl font-black text-emerald-400">CentroBus</h1>
                <p class="text-sm text-slate-400">Sistema de compra de pasajes</p>
            </div>

            <div class="flex items-center gap-4">
                <span class="text-sm text-slate-300">
                    Cliente: <strong class="text-emerald-400">{{ session('cliente_nombre') }}</strong>
                </span>

<a href="{{ url('/') }}"
    class="rounded-xl border border-emerald-400/30 px-4 py-2 text-sm font-bold text-emerald-400 hover:bg-emerald-400/10">
    Inicio
</a>

                <form action="{{ route('clientes.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="rounded-xl border border-white/20 px-4 py-2 text-sm font-bold hover:bg-white/10">
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </nav>
    </header>

    <main class="mx-auto max-w-7xl px-6 py-16">
        <div class="mb-10">
            <p class="text-sm font-bold uppercase tracking-widest text-emerald-400">
                Compra protegida con sesión
            </p>

            <h2 class="mt-3 text-4xl font-extrabold">
                Comprar pasaje
            </h2>

            <p class="mt-4 max-w-2xl text-slate-300">
                Seleccione una ruta, fecha de viaje y cantidad de pasajes. Al comprar, el sistema generará un código único para cada tiquete.
            </p>
        </div>

        <div class="grid gap-8 md:grid-cols-2">
            <section class="rounded-3xl border border-white/10 bg-white/5 p-8">
                <h3 class="text-2xl font-bold">Formulario de compra</h3>


@if ($errors->any())
    <div class="mt-5 rounded-xl border border-red-500/30 bg-red-500/10 p-4 text-sm text-red-300">
        <p class="font-bold">Revise los siguientes errores:</p>

        <ul class="mt-2 list-inside list-disc">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


@if (session('error'))
    <div class="mt-5 rounded-xl border border-red-500/30 bg-red-500/10 p-4 text-sm text-red-300">
        {{ session('error') }}
    </div>
@endif

@if (session('success'))
    <div class="mt-5 rounded-xl border border-emerald-500/30 bg-emerald-500/10 p-4 text-sm text-emerald-300">
        {{ session('success') }}
    </div>
@endif

@if (session('success_compra'))
    <div class="mt-5 rounded-xl border border-emerald-500/30 bg-emerald-500/10 p-4 text-sm text-emerald-300">
        {{ session('success_compra') }}
    </div>
@endif

@if (session('tiquetes_compra'))
    <div class="mt-5">
        <a href="{{ route('tiquetes.comprobante') }}" target="_blank"
            class="inline-block rounded-xl border border-emerald-400/30 px-5 py-3 font-bold text-emerald-400 hover:bg-emerald-400/10">
            Ver último comprobante PDF
        </a>
    </div>
@endif


             <form action="{{ route('tiquetes.comprar') }}" method="POST" class="mt-6 space-y-5">
                 @csrf
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-300">
                            Ruta
                        </label>

<select name="ruta_id" required
    class="w-full rounded-xl border border-white/10 bg-slate-900 px-4 py-3 text-white outline-none focus:border-emerald-400">
        <option value="" data-precio="0" disabled {{ old('ruta_id') ? '' : 'selected' }}>
            Seleccione la ruta que desea
        </option>
    @foreach ($rutas as $ruta)
        <option value="{{ $ruta->id }}" data-precio="{{ $ruta->precio }}" {{ old('ruta_id') == $ruta->id ? 'selected' : '' }}>
            {{ $ruta->origen }} - {{ $ruta->destino }}
            | {{ $ruta->horarioFormateado() }}
            | ${{ number_format($ruta->precio, 2) }}
        </option>
    @endforeach
</select>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-300">
                            Fecha de viaje
                        </label>

                        <input type="date" name = "fecha_viaje" required 
                        min="{{ date('Y-m-d') }}" 
                        max="{{ now()->addDays(7)->format('Y-m-d') }}"  
                        value="{{ old('fecha_viaje') }}"
                        class="w-full rounded-xl border border-white/10 bg-slate-900 px-4 py-3 text-white outline-none focus:border-emerald-400">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-300">
                            Cantidad de pasajes
                        </label>

                       <input type="number" name="cantidad" min="1" max="5" value="{{ old('cantidad', 0) }}" required
                       class="w-full rounded-xl border border-white/10 bg-slate-900 px-4 py-3 text-white outline-none focus:border-emerald-400">
                    </div>

<div class="rounded-xl border border-emerald-400/20 bg-emerald-400/10 p-4">
    <p class="text-sm text-slate-300">Total estimado</p>
    <p id="total-compra" class="text-2xl font-black text-emerald-400">$0.00</p>
</div>


                    <button type="submit"
                        class="w-full rounded-xl bg-emerald-500 px-5 py-3 font-bold text-slate-950 hover:bg-emerald-400">
                        Comprar pasaje
                    </button>
                </form>
            </section>

            <section class="rounded-3xl border border-white/10 bg-slate-900 p-8">
                <h3 class="text-2xl font-bold">Reglas de compra</h3>

                <div class="mt-6 space-y-4">
                    <div class="rounded-2xl bg-slate-950 p-5">
                        <p class="font-bold text-emerald-400">Máximo 5 pasajes</p>
                        <p class="mt-2 text-sm text-slate-300">
                            Una persona no puede comprar más de 5 pasajes.
                        </p>
                    </div>

                    <div class="rounded-2xl bg-slate-950 p-5">
                        <p class="font-bold text-emerald-400">Máximo una semana</p>
                        <p class="mt-2 text-sm text-slate-300">
                            Solo se pueden comprar pasajes para una semana como máximo.
                        </p>
                    </div>

                    <div class="rounded-2xl bg-slate-950 p-5">
                        <p class="font-bold text-emerald-400">Código único</p>
                        <p class="mt-2 text-sm text-slate-300">
                            Cada tiquete debe generar un código inventado y único.
                        </p>
                    </div>

                    <div class="rounded-2xl bg-slate-950 p-5">
                        <p class="font-bold text-emerald-400">Comprobante PDF</p>
                        <p class="mt-2 text-sm text-slate-300">
                            Al finalizar la compra se debe emitir un comprobante electrónico.
                        </p>
                    </div>
                </div>
            </section>
        </div>

        <section class="mt-10 rounded-3xl border border-white/10 bg-white/5 p-8">
    <div class="mb-6 flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
        <div>
            <h3 class="text-2xl font-bold">Mis compras</h3>
            <p class="mt-2 text-sm text-slate-400">
                Historial de tiquetes comprados por el usuario actual.
            </p>
        </div>

        <span class="rounded-full bg-emerald-400/10 px-4 py-2 text-sm font-bold text-emerald-300">
            Total: {{ $misTiquetes->count() }} tiquete(s)
        </span>
    </div>

    @if ($misTiquetes->count() > 0)
        <div class="overflow-hidden rounded-2xl border border-white/10">
            <table class="w-full border-collapse text-left text-sm">
                <thead class="bg-slate-900 text-slate-300">
                    <tr>
                        <th class="px-5 py-4">Código</th>
                        <th class="px-5 py-4">Ruta</th>
                        <th class="px-5 py-4">Horario</th>
                        <th class="px-5 py-4">Fecha de viaje</th>
                        <th class="px-5 py-4">Precio</th>
                        <th class="px-5 py-4">Comprobante</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-white/10">
                    @foreach ($misTiquetes as $tiquete)
                        <tr class="hover:bg-white/5">
                            <td class="px-5 py-4 font-bold text-emerald-400">
                                {{ $tiquete->codigo }}
                            </td>

                            <td class="px-5 py-4">
                                {{ $tiquete->ruta->origen }} - {{ $tiquete->ruta->destino }}
                            </td>

                            <td class="px-5 py-4">
                                {{ $tiquete->ruta->horarioFormateado() }}
                            </td>

                            <td class="px-5 py-4">
                                {{ $tiquete->fecha_viaje }}
                            </td>

                            <td class="px-5 py-4">
                                ${{ number_format($tiquete->precio, 2) }}
                            </td>

                            <td class="px-5 py-4">

                             <a href="{{ route('tiquetes.comprobante.compra', $tiquete->codigo_compra) }}" target="_blank"
                             class="inline-block rounded-lg border border-emerald-400/30 px-4 py-2 text-xs font-bold text-emerald-400 hover:bg-emerald-400/10">
                             Comprobante PDF
                            </a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="rounded-2xl border border-white/10 bg-slate-950 p-6 text-slate-400">
            Todavía no tiene compras registradas.
        </div>
    @endif
</section>
    </main>

    @if (session('abrir_pdf'))
    <script>
        window.addEventListener('load', function () {
            window.open("{{ route('tiquetes.comprobante') }}", "_blank");
        });
    </script>
@endif

</body>
</html>

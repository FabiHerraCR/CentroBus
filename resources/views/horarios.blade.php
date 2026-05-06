<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horarios y precios - CentroBus</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-950 text-white">

    <header class="sticky top-0 z-50 border-b border-white/10 bg-slate-950/90 backdrop-blur">
        <nav class="mx-auto flex max-w-7xl flex-col gap-4 px-6 py-5 md:flex-row md:items-center md:justify-between">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-500 text-lg font-black text-slate-950">
                    CB
                </div>

                <div>
                    <h1 class="text-xl font-bold">CentroBus</h1>
                    <p class="text-xs text-slate-400">Pasajes Centroamérica</p>
                </div>
            </div>

            <div class="flex flex-wrap justify-center gap-4 text-sm text-slate-300 md:gap-8">
                <a href="{{ url('/') }}" class="hover:text-emerald-400">Principal</a>
                <a href="{{ url('/horarios') }}" class="font-bold text-emerald-400">Horarios y precios</a>
                <a href="{{ url('/registro') }}" class="hover:text-emerald-400">Registrarse</a>
                <a href="{{ url('/acceso') }}" class="hover:text-emerald-400">Compra</a>
                <a href="{{ url('/contacto') }}" class="hover:text-emerald-400">Contacto</a>
            </div>

            @if (session('cliente_id'))
                <div class="flex flex-wrap items-center justify-center gap-3">
                    <span class="text-sm text-slate-300">
                        Cliente: <strong class="text-emerald-400">{{ session('cliente_nombre') }}</strong>
                    </span>

                    <a href="{{ route('compra.index') }}"
                        class="rounded-xl border border-emerald-400/30 px-4 py-2 text-sm font-bold text-emerald-400 hover:bg-emerald-400/10">
                        Comprar
                    </a>

                    <form action="{{ route('clientes.logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="rounded-xl border border-white/20 px-4 py-2 text-sm font-bold text-white hover:bg-white/10">
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ url('/acceso') }}"
                    class="inline-flex self-center rounded-xl bg-emerald-500 px-4 py-2 text-sm font-bold text-slate-950 hover:bg-emerald-400 md:self-auto">
                    Acceder
                </a>
            @endif
        </nav>
    </header>

    <main>
        <section id="horarios" class="bg-slate-900/70 px-6 py-20">
            <div class="mx-auto max-w-7xl">
                <div class="mb-10 text-center">
                    <p class="text-sm font-bold uppercase tracking-widest text-emerald-400">
                        Consulta de horarios y precios
                    </p>

                    <h2 class="mt-3 text-4xl font-extrabold">
                        Rutas disponibles
                    </h2>

                    <p class="mx-auto mt-4 max-w-2xl text-slate-300">
                        Estos son los servicios precargados que estarán disponibles para la compra de pasajes.
                    </p>
                </div>

                <div class="overflow-hidden rounded-2xl border border-white/10 bg-slate-950">
                    <table class="w-full border-collapse text-left text-sm">
                        <thead class="bg-white/5 text-slate-300">
                            <tr>
                                <th class="px-5 py-4">Ruta</th>
                                <th class="px-5 py-4">Horario</th>
                                <th class="px-5 py-4">Precio</th>
                                <th class="px-5 py-4">Estado</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-white/10">
                            @foreach ($rutas as $ruta)
                                <tr class="hover:bg-white/5">
                                    <td class="px-5 py-4 font-semibold">
                                        {{ $ruta->origen }} - {{ $ruta->destino }}
                                    </td>

                                    <td class="px-5 py-4">
                                        {{ substr($ruta->horario, 0, 5) }}
                                    </td>

                                    <td class="px-5 py-4">
                                        ${{ number_format($ruta->precio, 2) }}
                                    </td>

                                    <td class="px-5 py-4 text-emerald-400">
                                        Disponible
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>

    <footer class="border-t border-white/10 px-6 py-8 text-center text-sm text-slate-500">
        <p>© 2026 CentroBus. Sistema académico desarrollado en Laravel, PHP, JS, CSS, HTML y MySQL.</p>
    </footer>

</body>
</html>

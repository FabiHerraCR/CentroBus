<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CentroBus - Inicio</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[linear-gradient(to_bottom,#020617_0%,#06111f_55%,#04211f_100%)] bg-fixed text-white">

    <!-- ENCABEZADO -->
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
                <a href="{{ url('/horarios') }}" class="hover:text-emerald-400">Horarios y precios</a>
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

        <!--SECCIÓN PRINCIPAL-->
        <section id="principal" class="mx-auto grid max-w-7xl items-center gap-12 px-6 py-20 md:grid-cols-2">
            <div>
                <p class="mb-5 inline-flex rounded-full border border-emerald-400/30 bg-emerald-400/10 px-4 py-2 text-sm font-semibold text-emerald-300">
                    Sistema de venta de pasajes internacionales
                </p>

                <h2 class="text-5xl font-extrabold leading-tight md:text-6xl">
                    Viaje seguro por Centroamérica desde Costa Rica.
                </h2>

                <p class="mt-6 max-w-xl text-lg leading-8 text-slate-300">
                    CentroBus permite consultar rutas, horarios y precios para comprar pasajes
                    entre países de Centroamérica. Al realizar una compra, el cliente obtiene
                    un código único de tiquete para poder viajar.
                </p>

                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ url('/horarios') }}" class="rounded-xl bg-emerald-500 px-6 py-3 font-bold text-slate-950 shadow-lg shadow-emerald-500/20 hover:bg-emerald-400">
                        Ver horarios
                    </a>

                    <a href="{{ url('/registro') }}" class="rounded-xl border border-white/20 px-6 py-3 font-bold text-white hover:bg-white/10">
                        Registrarme
                    </a>
                </div>
            </div>

            <div class="rounded-3xl border border-white/10 bg-white/5 p-6 shadow-2xl">
                <div class="rounded-2xl bg-slate-900 p-6">
                    <div class="mb-6 flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-400">Próxima ruta</p>
                            <h3 class="text-2xl font-bold">CR - NI</h3>
                        </div>

                        <span class="rounded-full bg-emerald-400/10 px-4 py-2 text-sm font-bold text-emerald-300">
                            $80
                        </span>
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between rounded-xl bg-white/5 p-4">
                            <span class="text-slate-400">Salida</span>
                            <span class="font-semibold">3:00 AM</span>
                        </div>

                        <div class="flex justify-between rounded-xl bg-white/5 p-4">
                            <span class="text-slate-400">Compra máxima</span>
                            <span class="font-semibold">5 pasajes</span>
                        </div>

                        <div class="flex justify-between rounded-xl bg-white/5 p-4">
                            <span class="text-slate-400">Disponibilidad</span>
                            <span class="font-semibold">Máximo 1 semana</span>
                        </div>

                        <div class="flex justify-between rounded-xl bg-white/5 p-4">
                            <span class="text-slate-400">Comprobante</span>
                            <span class="font-semibold">PDF electrónico</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!--SECCIÓN INFORMATIVA-->
        <section class="mx-auto grid max-w-7xl gap-6 px-6 pb-20 md:grid-cols-3">
            <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                <h3 class="text-xl font-bold text-emerald-300">Rutas internacionales</h3>
                <p class="mt-3 text-slate-300">
                    Viajes entre Costa Rica, Nicaragua, Panamá, Guatemala, El Salvador y Honduras.
                </p>
            </div>

            <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                <h3 class="text-xl font-bold text-emerald-300">Usuarios registrados</h3>
                <p class="mt-3 text-slate-300">
                    Para comprar pasajes, el cliente debe registrarse e iniciar sesión en el sistema.
                </p>
            </div>

            <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                <h3 class="text-xl font-bold text-emerald-300">Código único</h3>
                <p class="mt-3 text-slate-300">
                    Cada tiquete comprado genera un código único que se mostrará en el comprobante PDF.
                </p>
            </div>
        </section>


    </main>

    <!-- PIE DE PÁGINA -->
    <footer class="border-t border-white/10 px-6 py-8 text-center text-sm text-slate-500">
        <p>© 2026 CentroBus. Sistema académico desarrollado en Laravel, PHP, JS, CSS, HTML y MySQL.</p>
    </footer>

</body>
</html>

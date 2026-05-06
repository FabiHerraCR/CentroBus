<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - CentroBus</title>

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
                <a href="{{ url('/horarios') }}" class="hover:text-emerald-400">Horarios y precios</a>
                <a href="{{ url('/registro') }}" class="hover:text-emerald-400">Registrarse</a>
                <a href="{{ url('/acceso') }}" class="hover:text-emerald-400">Compra</a>
                <a href="{{ url('/contacto') }}" class="text-emerald-400 font-bold">Contacto</a>
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

    <main class="mx-auto max-w-7xl px-6 py-20">
        <section class="rounded-3xl border border-white/10 bg-white/5 p-8 md:p-12">
            <div class="grid gap-10 md:grid-cols-2">
                <div>
                    <p class="text-sm font-bold uppercase tracking-widest text-emerald-400">
                        Contacto
                    </p>

                    <h2 class="mt-3 text-4xl font-extrabold">
                        ¿Necesita ayuda con su viaje?
                    </h2>

                    <p class="mt-5 text-slate-300">
                        Puede contactar a CentroBus para consultar disponibilidad,
                        rutas internacionales, precios y soporte con la compra de pasajes.
                    </p>

                    <div class="mt-6 space-y-3 text-slate-300">
                        <p>📍 Sede central: San José, Costa Rica</p>
                        <p>📞 Teléfono: +506 2222-0000</p>
                        <p>✉️ Correo: soporte@centrobus.com</p>
                        <p>🕒 Horario: Lunes a sábado, 8:00 AM - 6:00 PM</p>
                    </div>
                </div>

                <form class="space-y-4">
                    <input type="text" placeholder="Nombre completo"
                        class="w-full rounded-xl border border-white/10 bg-slate-900 px-4 py-3 text-white outline-none focus:border-emerald-400">

                    <input type="email" placeholder="Correo electrónico"
                        class="w-full rounded-xl border border-white/10 bg-slate-900 px-4 py-3 text-white outline-none focus:border-emerald-400">

                    <textarea rows="5" placeholder="Mensaje"
                        class="w-full resize-none rounded-xl border border-white/10 bg-slate-900 px-4 py-3 text-white outline-none focus:border-emerald-400"></textarea>

                    <button type="button"
                        class="rounded-xl bg-emerald-500 px-6 py-3 font-bold text-slate-950 hover:bg-emerald-400">
                        Enviar mensaje
                    </button>
                </form>
            </div>
        </section>
    </main>

    <footer class="border-t border-white/10 px-6 py-8 text-center text-sm text-slate-500">
        <p>© 2026 CentroBus. Sistema académico desarrollado en Laravel, PHP, JS, CSS, HTML y MySQL.</p>
    </footer>

</body>
</html>

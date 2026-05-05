<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso - CentroBus</title>

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
                <a href="{{ url('/acceso') }}" class="font-bold text-emerald-400">Compra</a>
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
                    class="rounded-xl bg-emerald-500 px-4 py-2 text-sm font-bold text-slate-950 hover:bg-emerald-400">
                    Acceder
                </a>
            @endif
        </nav>
    </header>

    <main>
        <section id="acceso" class="bg-slate-900/70 px-6 py-20">
            <div class="mx-auto grid max-w-7xl items-center gap-10 md:grid-cols-2">
                <div class="rounded-3xl border border-emerald-400/20 bg-emerald-400/10 p-8">
                    <h2 class="text-4xl font-extrabold">
                        Acceso al sistema de compra
                    </h2>

                    <p class="mt-5 text-slate-300">
                        Los usuarios registrados podrán iniciar sesión, seleccionar una ruta,
                        escoger la fecha de viaje, comprar máximo 5 pasajes y generar su comprobante PDF.
                    </p>

                    <div class="mt-8 grid gap-4 md:grid-cols-2">
                        <div class="rounded-2xl bg-slate-950 p-5">
                            <p class="text-3xl font-black text-emerald-400">5</p>
                            <p class="mt-2 text-sm text-slate-300">Pasajes máximos por persona</p>
                        </div>

                        <div class="rounded-2xl bg-slate-950 p-5">
                            <p class="text-3xl font-black text-emerald-400">7</p>
                            <p class="mt-2 text-sm text-slate-300">Días máximos para comprar</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl border border-white/10 bg-slate-950 p-8">
                    @if (session('cliente_id'))
                        <h3 class="text-2xl font-bold">Sesión iniciada</h3>

                        <p class="mt-3 text-slate-300">
                            Bienvenido, <span class="font-bold text-emerald-400">{{ session('cliente_nombre') }}</span>.
                        </p>

                        <div class="mt-6 flex flex-wrap gap-4">
                            <a href="{{ route('compra.index') }}"
                                class="rounded-xl bg-emerald-500 px-5 py-3 font-bold text-slate-950 hover:bg-emerald-400">
                                Ir a comprar pasajes
                            </a>

                            <form action="{{ route('clientes.logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="rounded-xl border border-white/20 px-5 py-3 font-bold text-white hover:bg-white/10">
                                    Cerrar sesión
                                </button>
                            </form>
                        </div>
                    @else
                        <h3 class="text-2xl font-bold">Iniciar sesión</h3>

                        <p class="mt-2 text-slate-400">
                            Acceda con su correo y contraseña para continuar con la compra.
                        </p>

                        @if (session('error_login'))
                            <div class="mt-5 rounded-xl border border-red-500/30 bg-red-500/10 p-4 text-sm text-red-300">
                                {{ session('error_login') }}
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="mt-5 rounded-xl border border-emerald-500/30 bg-emerald-500/10 p-4 text-sm text-emerald-300">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('clientes.login') }}" method="POST" class="mt-6 space-y-4">
                            @csrf

                            <input type="email" name="correo" placeholder="Correo electrónico"
                                class="w-full rounded-xl border border-white/10 bg-slate-900 px-4 py-3 text-white outline-none focus:border-emerald-400">

                            <input type="password" name="password" placeholder="Contraseña"
                                class="w-full rounded-xl border border-white/10 bg-slate-900 px-4 py-3 text-white outline-none focus:border-emerald-400">

                            <button type="submit"
                                class="w-full rounded-xl bg-emerald-500 px-5 py-3 font-bold text-slate-950 hover:bg-emerald-400">
                                Entrar al sistema
                            </button>
                        </form>

                        <p class="mt-5 text-center text-sm text-slate-400">
                            ¿No tiene cuenta?
                            <a href="{{ url('/registro') }}" class="font-bold text-emerald-400 hover:text-emerald-300">
                                Regístrese aquí
                            </a>
                        </p>
                    @endif
                </div>
            </div>
        </section>
    </main>

    <footer class="border-t border-white/10 px-6 py-8 text-center text-sm text-slate-500">
        <p>© 2026 CentroBus. Sistema académico desarrollado en Laravel, PHP, JS, CSS, HTML y MySQL.</p>
    </footer>

</body>
</html>
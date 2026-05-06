<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - CentroBus</title>

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
                <a href="{{ url('/registro') }}" class="font-bold text-emerald-400">Registrarse</a>
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
        <!-- REGISTRO -->
        <section id="registro" class="mx-auto grid max-w-7xl gap-10 px-6 py-20 md:grid-cols-2">
            <div>
                <p class="text-sm font-bold uppercase tracking-widest text-emerald-400">
                    Registro de clientes
                </p>

                <h2 class="mt-3 text-4xl font-extrabold">
                    Cree una cuenta para comprar pasajes.
                </h2>

                <p class="mt-5 text-slate-300">
                    Para poder realizar una compra, el usuario deberá registrarse con sus datos personales
                    y datos de pago. Luego podrá acceder al sistema de compra con su sesión.
                </p>

                <ul class="mt-6 space-y-3 text-slate-300">
                    <li>✅ Nombre y apellidos</li>
                    <li>✅ Pasaporte y nacionalidad</li>
                    <li>✅ Correo electrónico y teléfono</li>
                    <li>✅ Tarjeta, CCV y fecha de vencimiento</li>
                </ul>
            </div>

            <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                <form action="{{ route('clientes.registrar') }}" method="POST" class="space-y-4">
                    @csrf

                    @if ($errors->any())
                        <div class="rounded-xl border border-red-500/30 bg-red-500/10 p-4 text-sm text-red-300">
                            <p class="font-bold">Revise los siguientes errores:</p>

                            <ul class="mt-2 list-inside list-disc">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="rounded-xl border border-emerald-500/30 bg-emerald-500/10 p-4 text-sm text-emerald-300">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="grid gap-4 md:grid-cols-2">
                        <input type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Nombre"
                            class="rounded-xl border border-white/10 bg-slate-900 px-4 py-3 text-white outline-none focus:border-emerald-400">

                        <input type="text" name="apellidos" value="{{ old('apellidos') }}" placeholder="Apellidos"
                            class="rounded-xl border border-white/10 bg-slate-900 px-4 py-3 text-white outline-none focus:border-emerald-400">
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <input type="text" name="pasaporte" value="{{ old('pasaporte') }}" placeholder="Pasaporte"
                            class="rounded-xl border border-white/10 bg-slate-900 px-4 py-3 text-white outline-none focus:border-emerald-400">

                        <input type="text" name="nacionalidad" value="{{ old('nacionalidad') }}" placeholder="Nacionalidad"
                            class="rounded-xl border border-white/10 bg-slate-900 px-4 py-3 text-white outline-none focus:border-emerald-400">
                    </div>

                    <input type="email" name="correo" value="{{ old('correo') }}" placeholder="Correo electrónico"
                        class="w-full rounded-xl border border-white/10 bg-slate-900 px-4 py-3 text-white outline-none focus:border-emerald-400">

                    <input type="tel" name="telefono" value="{{ old('telefono') }}" placeholder="Teléfono"
                        class="w-full rounded-xl border border-white/10 bg-slate-900 px-4 py-3 text-white outline-none focus:border-emerald-400">

                    <div class="space-y-4">
                        <div class="space-y-2">
                            <input id="tarjeta" type="text" name="tarjeta" value="{{ old('tarjeta') }}" placeholder="Tarjeta"
                                inputmode="numeric"
                                class="w-full rounded-xl border border-white/10 bg-slate-900 px-4 py-3 text-white outline-none focus:border-emerald-400">

                            <p id="tipo-tarjeta" class="hidden text-sm font-semibold text-emerald-400"></p>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <input type="text" name="ccv" value="{{ old('ccv') }}" placeholder="CCV"
                                class="rounded-xl border border-white/10 bg-slate-900 px-4 py-3 text-white outline-none focus:border-emerald-400">

                            <input type="date" name="fecha_vencimiento" value="{{ old('fecha_vencimiento') }}"
                                class="rounded-xl border border-white/10 bg-slate-900 px-4 py-3 text-white outline-none focus:border-emerald-400">
                        </div>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <input type="password" name="password" placeholder="Contraseña"
                            class="rounded-xl border border-white/10 bg-slate-900 px-4 py-3 text-white outline-none focus:border-emerald-400">

                        <input type="password" name="password_confirmation" placeholder="Confirmar contraseña"
                            class="rounded-xl border border-white/10 bg-slate-900 px-4 py-3 text-white outline-none focus:border-emerald-400">
                    </div>

                    <button type="submit"
                        class="w-full rounded-xl bg-emerald-500 px-5 py-3 font-bold text-slate-950 hover:bg-emerald-400">
                        Registrarme
                    </button>

                    <p class="text-center text-xs text-slate-500">
                        Registro conectado con Laravel y MySQL.
                    </p>
                </form>
            </div>
        </section>
    </main>

    <footer class="border-t border-white/10 px-6 py-8 text-center text-sm text-slate-500">
        <p>© 2026 CentroBus. Sistema académico desarrollado en Laravel, PHP, JS, CSS, HTML y MySQL.</p>
    </footer>

</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante CentroBus</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #111827;
            font-size: 13px;
        }

        .header {
            border-bottom: 2px solid #10b981;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .title {
            font-size: 28px;
            font-weight: bold;
            color: #059669;
        }

        .subtitle {
            color: #374151;
            margin-top: 5px;
        }

        .box {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #047857;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th {
            background: #064e3b;
            color: white;
            padding: 8px;
            text-align: left;
        }

        td {
            border: 1px solid #d1d5db;
            padding: 8px;
        }

        .code {
            font-weight: bold;
            color: #dc2626;
        }

        .total {
            text-align: right;
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
        }

        .footer {
            margin-top: 35px;
            font-size: 11px;
            color: #6b7280;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="title">CentroBus</div>
        <div class="subtitle">Comprobante electrónico de compra de pasajes</div>
    </div>

    <div class="box">
        <div class="section-title">Datos del cliente</div>

        <p><strong>Nombre:</strong> {{ $cliente->nombre }} {{ $cliente->apellidos }}</p>
        <p><strong>Pasaporte:</strong> {{ $cliente->pasaporte }}</p>
        <p><strong>Nacionalidad:</strong> {{ $cliente->nacionalidad }}</p>
        <p><strong>Correo:</strong> {{ $cliente->correo }}</p>
        <p><strong>Teléfono:</strong> {{ $cliente->telefono }}</p>
    </div>

    <div class="box">
        <div class="section-title">Datos de los pasajes</div>

        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Ruta</th>
                    <th>Horario</th>
                    <th>Fecha de viaje</th>
                    <th>Precio</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($tiquetes as $tiquete)
                    <tr>
                        <td class="code">{{ $tiquete->codigo }}</td>
                        <td>{{ $tiquete->ruta->origen }} - {{ $tiquete->ruta->destino }}</td>
                        <td>{{ $tiquete->ruta->horarioFormateado() }}</td>
                        <td>{{ $tiquete->fecha_viaje }}</td>
                        <td>${{ number_format($tiquete->precio, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total">
            Total: ${{ number_format($tiquetes->sum('precio'), 2) }}
        </div>
    </div>

    <div class="footer">
        Este comprobante fue generado automáticamente por el sistema CentroBus.
        Cada código es único y permite identificar el tiquete comprado.
    </div>

</body>
</html>

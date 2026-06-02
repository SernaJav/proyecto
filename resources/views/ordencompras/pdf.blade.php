<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orden de Compra #{{ $ordencompra->id }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 20px;
            font-size: 14px;
            line-height: 1.5;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            background: #fff;
            border-radius: 8px;
        }
        .header-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .header-table td {
            padding: 0;
            vertical-align: top;
        }
        .title {
            font-size: 28px;
            font-weight: bold;
            color: #1e3d59;
            text-transform: uppercase;
            margin: 0 0 5px 0;
        }
        .info-right {
            text-align: right;
        }
        .info-right p {
            margin: 2px 0;
        }
        .divider {
            border-top: 2px solid #1e3d59;
            margin: 20px 0;
        }
        .details-table {
            width: 100%;
            margin-bottom: 30px;
            border-collapse: collapse;
        }
        .details-table td {
            width: 50%;
            padding: 5px 0;
            vertical-align: top;
        }
        .details-table h4 {
            margin: 0 0 5px 0;
            color: #1e3d59;
            font-size: 16px;
        }
        .details-table p {
            margin: 2px 0;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th {
            background-color: #1e3d59;
            color: #fff;
            text-align: left;
            padding: 10px;
            font-weight: 600;
        }
        .items-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #eee;
        }
        .items-table tr:last-child td {
            border-bottom: 2px solid #1e3d59;
        }
        .totals-table {
            width: 350px;
            margin-left: auto;
            border-collapse: collapse;
        }
        .totals-table td {
            padding: 8px 10px;
        }
        .totals-table tr.total-row td {
            font-weight: bold;
            font-size: 16px;
            color: #1e3d59;
            border-top: 1px solid #ddd;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
        .no-print-btn {
            background-color: #1e3d59;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            font-weight: bold;
            margin-bottom: 20px;
            display: inline-block;
            text-decoration: none;
        }
        .no-print-btn:hover {
            background-color: #17b978;
        }
        
        @media print {
            body {
                padding: 0;
                font-size: 12px;
            }
            .invoice-box {
                border: none;
                box-shadow: none;
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    <div class="invoice-box">
        <!-- Botón flotante para imprimir de forma manual si se cierra la ventana -->
        <div class="no-print" style="text-align: right;">
            <a href="javascript:window.print()" class="no-print-btn">
                <i class="fas fa-print"></i> Imprimir Comprobante
            </a>
            <a href="{{ route('ordencompras.index') }}" class="no-print-btn" style="background-color: #6c757d;">
                Volver al Listado
            </a>
        </div>

        <table class="header-table">
            <tr>
                <td>
                    <h1 class="title">Orden de Compra</h1>
                    <span style="font-size: 16px; color: #777; font-weight: bold;">Nº #{{ $ordencompra->id }}</span>
                </td>
                <td class="info-right">
                    <p><strong>Fecha Emisión:</strong> {{ $ordencompra->fecha ? $ordencompra->fecha->format('d/m/Y') : now()->format('d/m/Y') }}</p>
                    <p><strong>Estado:</strong> {{ $ordencompra->estado == 1 ? 'Activo' : 'Inactivo' }}</p>
                </td>
            </tr>
        </table>

        <div class="divider"></div>

        <table class="details-table">
            <tr>
                <td>
                    <h4>Proveedor</h4>
                    <p><strong>Nombre:</strong> {{ $ordencompra->proveedor->nombre ?? 'N/A' }}</p>
                    <p><strong>Documento:</strong> {{ $ordencompra->proveedor->documento ?? 'N/A' }}</p>
                    <p><strong>Email:</strong> {{ $ordencompra->proveedor->email ?? 'N/A' }}</p>
                    <p><strong>Teléfono:</strong> {{ $ordencompra->proveedor->telefono ?? 'N/A' }}</p>
                </td>
                <td>
                    <h4>Información de Pago</h4>
                    <p><strong>Tipo de Pago:</strong> <span style="text-transform: capitalize;">{{ $ordencompra->tipopago }}</span></p>
                    <p><strong>Generado por:</strong> {{ $ordencompra->registradopor }}</p>
                </td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th style="text-align: right; width: 100px;">Precio Unitario</th>
                    <th style="text-align: right; width: 100px;">Cantidad</th>
                    <th style="text-align: right; width: 120px;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ordencompra->detallesCompras as $detalle)
                    <tr>
                        <td>
                            <strong>{{ $detalle->producto->nombre ?? 'N/A' }}</strong>
                            <br>
                            <span style="font-size: 12px; color: #777;">{{ $detalle->producto->descripcion ?? '' }}</span>
                        </td>
                        <td style="text-align: right;">
                            ${{ number_format($detalle->subtotal / ($detalle->cantidad ?: 1), 2) }}
                        </td>
                        <td style="text-align: right;">
                            {{ $detalle->cantidad }}
                        </td>
                        <td style="text-align: right;">
                            ${{ number_format($detalle->subtotal, 2) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center;">No hay productos registrados en esta orden.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <table class="totals-table">
            <tr>
                <td>Subtotal:</td>
                <td style="text-align: right;">${{ number_format($ordencompra->total, 2) }}</td>
            </tr>
            <tr class="total-row">
                <td>Total:</td>
                <td style="text-align: right;">${{ number_format($ordencompra->total, 2) }}</td>
            </tr>
            <tr>
                <td style="color: #c0392b;">Saldo Pendiente:</td>
                <td style="text-align: right; font-weight: bold; color: #c0392b;">
                    ${{ number_format($ordencompra->saldopendiente, 2) }}
                </td>
            </tr>
        </table>

        <div class="footer">
            <p>Gracias por hacer negocios con nosotros.</p>
            <p>Este documento es un comprobante de la Orden de Compra #{{ $ordencompra->id }}.</p>
        </div>
    </div>

    <!-- Script para disparar la impresión automáticamente al cargar la vista -->
    <script type="text/javascript">
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>

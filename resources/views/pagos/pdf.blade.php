<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante de Pago #{{ $pago->id }}</title>
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
        .totals-table {
            width: 300px;
            margin-left: auto;
            border-collapse: collapse;
        }
        .totals-table td {
            padding: 8px 10px;
        }
        .totals-table tr.total-row td {
            font-weight: bold;
            font-size: 18px;
            color: #1e3d59;
            border-top: 2px solid #1e3d59;
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
        <div class="no-print" style="text-align: right;">
            <a href="javascript:window.print()" class="no-print-btn">
                 Imprimir Recibo
            </a>
            <a href="{{ route('pagos.index') }}" class="no-print-btn" style="background-color: #6c757d;">
                Volver al Listado
            </a>
        </div>

        <table class="header-table">
            <tr>
                <td>
                    <h1 class="title">Recibo de Pago</h1>
                    <span style="font-size: 16px; color: #777; font-weight: bold;">Nº #{{ $pago->id }}</span>
                </td>
                <td class="info-right">
                    <p><strong>Fecha de Pago:</strong> {{ $pago->fechapago ? $pago->fechapago->format('d/m/Y H:i') : 'N/A' }}</p>
                    <p><strong>Orden de Compra:</strong> #{{ $pago->ordencompra_id }}</p>
                </td>
            </tr>
        </table>

        <div class="divider"></div>

        <table class="details-table">
            <tr>
                <td>
                    <h4>Detalles del Pago</h4>
                    <p><strong>Método de Pago:</strong> {{ $pago->metodoPago->nombre ?? 'N/A' }}</p>
                    <p><strong>Registrado Por:</strong> {{ $pago->registradopor }}</p>
                </td>
                <td>
                    <h4>Información de la Orden</h4>
                    <p><strong>Proveedor:</strong> {{ $pago->ordenCompra->proveedor->nombre ?? 'N/A' }}</p>
                    <p><strong>Total Orden:</strong> ${{ number_format($pago->ordenCompra->total ?? 0, 2) }}</p>
                </td>
            </tr>
        </table>

        <table class="totals-table">
            <tr class="total-row">
                <td>Monto Pagado:</td>
                <td style="text-align: right;">${{ number_format($pago->monto, 2) }}</td>
            </tr>
        </table>

        <div class="footer">
            <p>Este documento es un comprobante oficial de Pago.</p>
        </div>
    </div>

    <script type="text/javascript">
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Producto: {{ $producto->nombre }}</title>
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
                 Imprimir Ficha
            </a>
            <a href="{{ route('productos.index') }}" class="no-print-btn" style="background-color: #6c757d;">
                Volver al Listado
            </a>
        </div>

        <table class="header-table">
            <tr>
                <td>
                    <h1 class="title">Ficha de Producto</h1>
                    <span style="font-size: 16px; color: #777; font-weight: bold;">Código: {{ $producto->codigo }}</span>
                </td>
                <td class="info-right">
                    <p><strong>Fecha Generación:</strong> {{ now()->format('d/m/Y') }}</p>
                    <p><strong>Estado:</strong> {{ $producto->estado == 1 ? 'Activo' : 'Inactivo' }}</p>
                </td>
            </tr>
        </table>

        <div class="divider"></div>

        <table class="details-table">
            <tr>
                <td>
                    <h4>Información de Producto</h4>
                    <p><strong>Nombre:</strong> {{ $producto->nombre }}</p>
                    <p><strong>Stock Actual:</strong> {{ $producto->stock }}</p>
                    <p><strong>Precio Compra:</strong> ${{ number_format($producto->preciocompra, 2) }}</p>
                    <p><strong>Precio Venta:</strong> ${{ number_format($producto->precioventa, 2) }}</p>
                </td>
                <td>
                    <h4>Detalles y Descripción</h4>
                    <p><strong>Descripción:</strong> {{ $producto->descripcion ?? 'Sin descripción' }}</p>
                    <p><strong>Registrado Por:</strong> {{ $producto->registradopor }}</p>
                    <p><strong>Fecha Registro:</strong> {{ $producto->created_at ? $producto->created_at->format('d/m/Y H:i') : 'N/A' }}</p>
                </td>
            </tr>
        </table>

        <div class="footer">
            <p>Este documento es una ficha oficial de Producto.</p>
        </div>
    </div>

    <script type="text/javascript">
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>

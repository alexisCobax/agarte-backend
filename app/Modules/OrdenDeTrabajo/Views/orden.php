<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orden</title>
    <style>
        @page {
            margin: 100px 50px 50px 50px;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            color: #333;
        }

        header {
            position: fixed;
            top: -100px;
            left: 0;
            right: 0;
            height: 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #333;
            padding: 10px 20px;
            background-color: #fff;
        }

        .header-title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            flex-grow: 1;
        }

        footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            height: 30px;
            text-align: center;
            font-size: 12px;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0px, 0px, 0px, 0px;
            padding: 0px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            font-size: 18px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 14px;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            width: 50%;
        }

        th {
            background: #e0e0e0;
            font-weight: bold;
        }

        .info p {
            margin: 20px 0;
        }

        hr {
            border: 1px dashed grey;

        }
    </style>
</head>

<body>

    <header style="width: 100%; border-bottom: 2px solid #333; padding: 10px 0;">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 33%; text-align: left;">{{sucursal_nombre}}</td>
                <td style="width: 33%; text-align: center; font-weight: bold;">
                    <h1>Orden de trabajo</h1>
                </td>
                <td style="width: 33%; text-align: right;">N°: {{numero_orden}}</td>
            </tr>
        </table>
    </header>




    <footer>
        Página <span class="pagenum"></span>
    </footer>

    <div class="container">
        <table>
            <tr>
                <td><strong>Nombre:</strong> {{cliente_nombre}}</td>
                <td><strong>Email:</strong> {{cliente_email}}</td>
            </tr>
            <tr>
                <td><strong>Domicilio:</strong> {{cliente_domicilio}}</td>
                <td><strong>Teléfono:</strong> {{cliente_telefono}}</td>
            </tr>
        </table>
        <hr />


        <table>
            <tr>
                <td><strong>Tipo:</strong> {{objeto_tipo}}</td>
                <td><strong>Tipo de Enmarcación:</strong> {{detalle_tipo}}</td>
            </tr>
            <tr>
                <td><strong>Modelo:</strong> {{objeto_modelo}}</td>
                <td><strong>Alto:</strong> {{detalle_alto}} cm</td>
            </tr>
            <tr>
                <td><strong>¿Es Propio?:</strong> {{objeto_propiedad}}</td>
                <td><strong>Ancho:</strong> {{detalle_ancho}} cm</td>
            </tr>
            <tr>
                <td><strong>Recepción:</strong> {{fecha_recepcion}}</td>
                <td><strong>Entrega:</strong> {{fecha_entrega}}</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Comentario:</strong> {{objeto_comentario}}</td>
            </tr>
        </table>
        <br/>
        <table>
            <thead>
                <tr>
                    <th style='text-align:center;'>Material</th>
                    <th style='text-align:center;'>Cantidad</th>
                    <th style='text-align:center;'>Posición</th>
                    <th style='text-align:center;'>Observaciones</th>
                </tr>
            </thead>
            <tbody>
                {{tabla_materiales}}
            </tbody>
        </table>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelector(".pagenum").textContent = "1";
        });
    </script>

</body>

</html>
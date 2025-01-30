<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orden</title>
    <style>
        @page {
            margin: 100px 50px 50px 50px; /* Espaciado para header y footer */
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
        }
        header {
            position: fixed;
            top: -80px;
            left: 0;
            right: 0;
            height: 80px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #333; /* Uso de gris oscuro para bordes */
            padding: 10px 20px;
            background-color: #fff; /* Fondo blanco para evitar sombra */
        }
        header .order-number {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            text-align: right;
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
            margin: auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            font-size: 18px;
            font-weight: bold;
        }
        .section {
            margin-bottom: 15px;
            padding: 15px;
            border: 1px solid #bbb; /* Bordes suaves para dar una sensación limpia */
            border-radius: 5px;
            background: #f8f8f8; /* Fondo gris claro */
        }
        .section h2 {
            margin: 0;
            font-size: 16px;
            color: #333;
            border-bottom: 2px solid #ddd; /* Línea sutil debajo del título */
            padding-bottom: 5px;
            font-weight: bold;
        }
        .info p {
            margin: 8px 0;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 14px;
        }
        th, td {
            border: 1px solid #ddd; /* Bordes suaves para las celdas */
            padding: 8px;
            text-align: left;
        }
        th {
            background: #e0e0e0; /* Fondo gris claro para encabezados */
            color: #333;
            font-weight: bold;
        }

        /* Estilo de la tabla para las dos secciones al lado */
        .double-section-table {
            width: 100%;
            table-layout: fixed;
            border-spacing: 10px; /* Espacio entre las celdas */
        }
        .double-section-table td {
            width: 48%; /* Ancho de cada celda */
            vertical-align: top;
        }
    </style>
</head>
<body>

<header>
    <div class="order-number">Orden N°: {{numero_orden}}<br/> {{sucursal_nombre}}</div>
</header>

<footer>
    Página <span class="pagenum"></span>
</footer>

<div class="container">
    <h1>Orden de trabajo</h1>

    <div class="section">
        <h2>Información del Cliente</h2>
        <div class="info">
            <p><strong>Nombre:</strong> {{cliente_nombre}}</p>
            <p><strong>Email:</strong> {{cliente_email}}</p>
            <p><strong>Domicilio:</strong> {{cliente_domicilio}}</p>
            <p><strong>Teléfono:</strong> {{cliente_telefono}}</p>
        </div>
    </div>

    <!-- Tabla para las dos secciones al lado -->
    <table class="double-section-table">
        <tr>
            <td>
                <div class="section">
                    <h2>Objeto a Enmarcar</h2>
                    <div class="info">
                        <p><strong>Tipo:</strong> {{objeto_tipo}}</p>
                        <p><strong>Modelo:</strong> {{objeto_modelo}}</p>
                        <p><strong>Propiedad:</strong> {{objeto_propiedad}}</p>
                        <p><strong>Comentario:</strong> {{objeto_comentario}}</p>
                    </div>
                </div>
            </td>
            <td>
                <div class="section">
                    <h2>Detalle de Enmarcación</h2>
                    <div class="info">
                        <p><strong>Tipo de Enmarcación:</strong> {{detalle_tipo}}</p>
                        <p><strong>Alto:</strong> {{detalle_alto}} cm</p>
                        <p><strong>Ancho:</strong> {{detalle_ancho}} cm</p>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <div class="section">
        <h2>Materiales Utilizados</h2>
        <table>
            <thead>
                <tr>
                    <th>Material</th>
                    <th>Cantidad</th>
                    <th>Posición</th>
                    <th>Observaciones</th>
                </tr>
            </thead>
            <tbody>
                {{tabla_materiales}}
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelector(".pagenum").textContent = "1";
    });
</script>

</body>
</html>

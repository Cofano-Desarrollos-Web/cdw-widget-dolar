CDW Widget Dólar 💵
Este repositorio contiene el widget de cotización del dólar con logo CDW, diseñado para integrarse en sitios WordPress de manera sencilla. El widget muestra la cotización actualizada cada 15 minutos y la compara con la referencia del día anterior, indicando la variación con porcentaje y flechas hacia arriba o abajo.

📂 Archivos principales
Widget-Dolar.html → Código del widget que se incrusta en el sitio.

icono_pestana_CDW.jpg → Logo CDW que se muestra en el widget o en la pestaña del navegador.

cotizacion.php → Script que obtiene las cotizaciones actuales desde las APIs externas.

guardar-referencia.php → Genera y actualiza el archivo JSON con la referencia del día anterior (se ejecuta a la medianoche).

guardar-referencia.json → Archivo con la referencia guardada del día anterior, usado para calcular variaciones.

⚙️ Instalación en WordPress (manual)
Subir archivos al servidor

Colocar todos los archivos (cotizacion.php, guardar-referencia.php, guardar-referencia.json, Widget-Dolar.html, icono_pestana_CDW.jpg) en la raíz de WordPress (generalmente la carpeta public_html).

Esto simplifica las rutas y evita problemas de permisos.

Insertar el widget en el sitio

Abrir Elementor (o el editor que uses).

Insertar un bloque HTML y pegar el contenido de Widget-Dolar.html.

Verificar que las rutas al logo y a los scripts apunten a tu dominio, por ejemplo:

html
<img src="https://tusitio.com/icono_pestana_CDW.jpg">
<script src="https://tusitio.com/cotizacion.php"></script>
Configurar la referencia diaria

guardar-referencia.php debe ejecutarse automáticamente a la medianoche (con un cron job o WP-Cron).

Esto genera/actualiza guardar-referencia.json con los valores de referencia del día anterior.

🔗 De dónde salen los datos
El widget no usa fuentes oficiales (como BCRA), sino que consulta:

DolarAPI

Bluelytics

Estas fuentes se eligen porque:

Son más estables y rápidas para consumo en tiempo real.

Ofrecen datos consistentes y fáciles de integrar vía API.

Permiten mantener control editorial sobre la visualización.

📊 Cómo funciona
Cada 15 minutos, cotizacion.php consulta las APIs y obtiene los valores actuales.

El widget muestra esos valores en vivo.

Al mismo tiempo, compara con los valores guardados en guardar-referencia.json (del día anterior).

Calcula la variación porcentual y muestra una flecha verde 🔼 si subió o roja 🔽 si bajó.

✅ Ventajas
Control editorial: siempre podés revisar y editar la referencia diaria.

Comparación clara: el usuario ve no solo el valor actual, sino también la variación respecto al día anterior.

Instalación simple: basta con subir los archivos a la raíz de WordPress y pegar el widget en Elementor.

Fuentes confiables: APIs comunitarias estables y rápidas.

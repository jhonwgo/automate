<?php
$ayuda="automate-check-composer
Dado un nombre de un composer.json identifica qué otros composer.json lo incluyen, tanto de forma directa como indirecta.
Modo de uso:
-n --nombre             nombre de un composer.json
-d --directorios        ruta a archivo con lista de directorios locales en cada linea 
";

$argumentos = getopt("n:d:", array(
    "nombre:",
    "directorios:"
));
// Las opciones deben estar establecidas
// Si no, salimos e indicamos el modo de uso
if (
    !(isset($argumentos["n"]) || isset($argumentos["nombre"]))
    ||
    !(isset($argumentos["d"]) || isset($argumentos["directorios"]))
) {
    exit($ayuda);
}

// Hasta aquí todas las opciones están bien establecidas
$nombre = isset($argumentos["n"]) ? $argumentos["n"] : $argumentos["nombre"];
$directorios = isset($argumentos["d"]) ? $argumentos["d"] : $argumentos["directorios"];
echo "automate-check-composer" . PHP_EOL;
echo "Buscando otros composer.json que lo incluyen, tanto de forma directa como indirecta." . PHP_EOL;
echo "nombre: $nombre" . PHP_EOL;
echo "directorios: $directorios" . PHP_EOL;


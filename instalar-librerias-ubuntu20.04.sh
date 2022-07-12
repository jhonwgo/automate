#!/bin/bash
#instalacion librerias en ubuntu 20.04
#instalacion php
sudo apt update
sudo apt -y install php
sudo apt -y install php-cli unzip
sudo apt -y install php-xml
sudo apt -y install php-mbstring
sudo apt -y install php-curl
php -v

#instalacion composer
#descargar instalador
curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
HASH=`curl -sS https://composer.github.io/installer.sig`
echo $HASH
#validar integridad
RESULTADO=`php -r "if (hash_file('SHA384', '/tmp/composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('/tmp/composer-setup.php'); } echo PHP_EOL;"`
echo $RESULTADO
if [ "$RESULTADO" = "Installer verified" ]; then
    echo "Validacion exitosa."
    #instalar en sistema operativo
    sudo php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer   
    composer -V
else
    echo "Error verificando archivo, intente de nuevo."
fi

#eliminar instalador
rm /tmp/composer-setup.php



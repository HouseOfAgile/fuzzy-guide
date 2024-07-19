#!/bin/bash

THIS_USER=`whoami`
sudo chown -R ${THIS_USER}.nginx /app/
sudo chown -R ${THIS_USER}.nginx /app/var /app/public
mkdir -p /app/public/uploads
sudo chmod -R 775 /app/var /app/public /app/translations

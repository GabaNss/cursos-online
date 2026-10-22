#!/bin/bash
set -e

echo "Aguardando banco de dados..."
sleep 5

echo "Criando link de storage..."
php artisan storage:link --force

if [ ! -f /var/www/html/storage/.initialized ]; then
  echo "Primeira inicialização: rodando migrations e seeder..."
  php artisan migrate --seed --force
  touch /var/www/html/storage/.initialized
else
  echo "Rodando migrations..."
  php artisan migrate --force
fi

echo "Otimizando para produção..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Pronto!"

exec apache2-foreground

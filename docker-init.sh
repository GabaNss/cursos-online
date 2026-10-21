#!/bin/bash
set -e

echo "Aguardando banco de dados..."
sleep 5

echo "Criando link de storage..."
php artisan storage:link

echo "Rodando migrations e seeder..."
php artisan migrate --seed --force

echo "Otimizando para produção..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Pronto!"

exec apache2-foreground

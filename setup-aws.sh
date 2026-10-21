#!/bin/bash
set -e

REPO_URL="${1:-}"
APP_DIR="cursos-online"

if [ -z "$REPO_URL" ]; then
  echo "Uso: bash setup-aws.sh <url-do-repositorio-git>"
  echo "Exemplo: bash setup-aws.sh https://github.com/seu-usuario/cursos-online.git"
  exit 1
fi

echo "==> Atualizando pacotes..."
sudo apt-get update -y
sudo apt-get upgrade -y

echo "==> Instalando Docker..."
sudo apt-get install -y ca-certificates curl gnupg
sudo install -m 0755 -d /etc/apt/keyrings
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /etc/apt/keyrings/docker.gpg
sudo chmod a+r /etc/apt/keyrings/docker.gpg

echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu \
  $(. /etc/os-release && echo "$VERSION_CODENAME") stable" | \
  sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

sudo apt-get update -y
sudo apt-get install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin

echo "==> Habilitando e iniciando Docker..."
sudo systemctl enable docker
sudo systemctl start docker
sudo usermod -aG docker "$USER"

echo "==> Clonando repositório..."
git clone "$REPO_URL" "$APP_DIR"
cd "$APP_DIR"

echo "==> Subindo containers (build pode demorar alguns minutos)..."
sudo docker compose up -d --build

echo ""
echo "============================================"
echo " Containers rodando!"
echo " App disponível em http://$(curl -s ifconfig.me):8080"
echo ""
echo " Próximo passo — inicializar a aplicação:"
echo "   sudo docker exec -it cursos_app bash docker-init.sh"
echo "============================================"

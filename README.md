# 📦 Projeto Laravel com Sail

Este projeto utiliza o Laravel Sail como ambiente de desenvolvimento baseado em Docker.

## 🚀 Começando

Siga estas instruções para configurar e executar o projeto em seu ambiente local.

### ✅ Pré-requisitos

- Docker instalado
- Docker Compose instalado
- PHP 8.0+
- Composer

### 🔧 Instalação

1. **Copie o arquivo .env**
   ```bash
   cp .env.example .env

Certifique-se de ajustar as variáveis conforme necessário (como nome do banco, usuário, etc).

2. **Instale as dependências do projeto**

    ```bash
    composer install
    
3. **Gere a key da aplicação**
    ```bash
    ./vendor/bin/sail up -d
    ./vendor/bin/sail artisan key:generate

4. **Execute as migrations (e seeds, se necessário)**

  ```bash
  ./vendor/bin/sail artisan migrate
  # ou, se quiser rodar as seeds também:
  ./vendor/bin/sail artisan migrate --seed

5. **Acesse o projeto**
O Laravel deve estar rodando em:

http://localhost

🛠 Comandos úteis
Subir containers:

    ```bash
    ./vendor/bin/sail up -d
    Parar containers:

    ```bash
    ./vendor/bin/sail down
    Acessar o container:

    ```bash
    ./vendor/bin/sail shell
    Rodar testes:

    ```bash
    ./vendor/bin/sail test
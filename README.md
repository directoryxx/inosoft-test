# Inosoft Test

This App tested on Linux & Mac Maybe it will face some issues when trying it at Windows. 
If you faced it try to run it from powershell.

## Installation

1. Install Docker
2. Install Docker Compose (Optional)
3. Run Command "docker-compose up -d"
4. Run Command "docker exec -it app_inosoft /bin/bash"
5. Run Command "cp .env.example .env"
5. Run Command "php artisan migrate --seed"
6. Access through http://127.0.0.1:8111

## Docs

'''
http://127.0.0.1:8111/docs
'''

## Testing
1. Run command "XDEBUG_MODE=coverage vendor/bin/phpunit --coverage-html reports2"
2. Run command "docker exec -it app_inosoft /bin/bash"
3. Run command "cd reports2"
4. Run command "php -S 0.0.0.0:8001"
5. Access through http://127.0.0.1:8001
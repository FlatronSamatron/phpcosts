# phpcosts
cd docker
docker-compose up -d --build
docker exec -it php-costs bash
composer init
composer dump-autoload
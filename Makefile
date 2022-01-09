up:
	docker-compose up

down:
	docker-compose down

app:
	docker-compose exec app sh

config-c:
	docker-compose exec app php artisan config:clear

cache-c:
	docker-compose exec app php artisan cache:clear

run-dev:
	docker-compose exec app npm run dev

# 本番用にビルド
prod:
	docker-compose exec app npm run prod

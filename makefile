include .env

export $(shell sed 's/=.*//' .env)

up:
	docker compose up -d

down:
	docker compose down

install:
	docker compose exec uvel-app composer install

rebuild:
	docker compose up -d --build
	$(MAKE) down

setup:
	$(MAKE) up
	$(MAKE) install
	$(MAKE) down

clean:
	rm -rf node_modules vendor 

check-status:
	docker compose ps | grep uvel-app || (echo "uvel-app is not running!" && exit 1)

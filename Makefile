# Variables
DOMAIN=spd.test
OPENSSL_CONF=/etc/ssl/openssl.cnf

print-separator:
	@echo "................................................................................................................."

create-certs: print-separator
	@echo "___Generating self-signed certificates for $(DOMAIN)..."
	openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout ./nginx/conf.d/$(DOMAIN).key -out ./nginx/conf.d/$(DOMAIN).crt -subj "/C=US/ST=State/L=City/O=Organization/CN=$(DOMAIN)" -config $(OPENSSL_CONF)
	@echo "___Certificates generated!"

remove-certs: print-separator
	@echo "___Removing certificates..."
	rm -f ./nginx/conf.d/$(DOMAIN).key ./nginx/conf.d/$(DOMAIN).crt

install-composer-pkgs: print-separator
	@echo "___Installing composer packages..."
	docker exec -it spies-directory-app-container composer install
	@echo "___Composer packages installed!"

copy-env: print-separator
	@echo "___Copying .env.example to .env..."
	docker exec -it spies-directory-app-container cp .env.example .env
	@echo "___.env file copied!"

generate-key: print-separator
	@echo "___Generating Laravel app key..."
	docker exec -it spies-directory-app-container php artisan key:generate
	@echo "___App key generated!"

migrate-db: print-separator
	@echo "___Running migrations..."
	docker exec -it spies-directory-app-container php artisan migrate
	@echo "___Migrations completed!"

seed-db: print-separator
	@echo "___Seeding database..."
	docker exec -it spies-directory-app-container php artisan db:seed
	@echo "___Database seeded!"

set-permissions: print-separator
	@echo "___Setting permissions for storage and cache..."
	docker exec -it spies-directory-app-container chmod -R 777 storage bootstrap/cache
	@echo "___Permissions set!"

clear-composer-cache: print-separator
	@echo "___Clearing composer cache..."
	docker exec -it spies-directory-app-container composer clear-cache
	@echo "___Composer cache cleared!"

clear-config-cache: print-separator
	@echo "___Clearing Laravel config cache..."
	docker exec -it spies-directory-app-container php artisan config:clear
	@echo "___Config cache cleared!"

clear-laravel-cache: print-separator
	@echo "___Clearing Laravel cache..."
	docker exec -it spies-directory-app-container php artisan cache:clear
	@echo "___Cache cleared!"

setup-project: create-certs install-composer-pkgs copy-env generate-key migrate-db seed-db set-permissions clear-composer-cache clear-config-cache clear-laravel-cache

.PHONY: print-separator create-certs remove-certs install-composer-pkgs copy-env generate-key migrate-db seed-db set-permissions clear-composer-cache clear-config-cache clear-laravel-cache setup-project

PHPCLI=docker-compose run --rm php-upstream
MYSQL_LOG_FILE=/var/lib/mysql/general_log.log

##################################################################################################################
# MAIN
##################################################################################################################

start: stop up init-db

stop:
	docker-compose stop
	docker-compose rm -f -v

up:
	docker-compose up -d --remove-orphans


build: build_local_clear build_docker_php
	docker-compose down --remove-orphans -v

build_local_clear:
	rm -rf var/cache/*
	echo $(CI_BUILD_REF) > .revision

build_docker_php:
	$(PHPCLI) composer install --optimize-autoloader --ignore-platform-reqs
	$(PHPCLI) php bin/console cache:clear
	$(PHPCLI) php bin/console cache:warmup

cli-php:
	$(PHPCLI) bash

##################################################################################################################
# TESTS
##################################################################################################################

tests: start quick-tests
	docker-compose stop
	docker-compose rm -f -v

quick-tests:
	docker-compose run --rm php-upstream ./bin/phpunit --stop-on-failure

dev-quick-tests:
	docker-compose run --rm php-upstream-tests ./bin/phpunit --group=dev

##################################################################################################################
# MYSQL
##################################################################################################################

init-db:
	sleep 20 # wait for mysql container
	docker-compose exec -T mysql mysql -u root -proot123 -e 'SET GLOBAL general_log_file = "$(MYSQL_LOG_FILE)";'
	docker-compose exec -T mysql mysql -u root -proot123 -e 'SET GLOBAL general_log = "ON";'
	$(PHPCLI) php ./bin/console doctrine:cache:clear-metadata
	$(PHPCLI) php ./bin/console doctrine:schema:create

cli-mysql:
	docker-compose -f docker-compose.yml exec mysql mysql -u learn_by_tests -D learn_by_tests --password=password123

tail-mysql-logs:
	docker-compose exec mysql tail -f $(MYSQL_LOG_FILE)

# Adventures Budget App

Migrace
---
- Vytvořit z entity: `php bin/console migrations:diff`
- Migrovat: `php bin/console migrations:migrate`
- Předchozí `php bin/console migrations:migrate prev`
- Náhrat fixtures ` php bin/console doctrine:fixtures:load`

První instalace
------------
`docker-compose up --build`

Spuštění
------------
`docker-compose up -d` Parametr -d jen udělá, aby to nespamovalo log

Možné chyby (při první instalaci) - oprávnení
------------
Chyba při ukládání na temp a log

- `chmod -R 777 ./temp`
- `chmod -R 777 ./log`

Vstup do dockeru (pro composer apod.)
-
`docker-compose exec www /bin/bash`

Php cs fixer
-
1) `docker-compose exec www /bin/bash`
2) `php vendor/bin/php-cs-fixer fix app`

Psalm
-
- `php vendor/bin/psalm`

Clear cache
-

- `php bin/clearcache`

První uživatel
- E-mail: `admin@admin.admin`
- Heslo: `admin`

Databáze
-
- PhpMyAdmin: http://localhost:8080
- Server: `mysql (172.17.0.1)`
- Database: `ejednotka`
- Login: `root`
- Password: `root`

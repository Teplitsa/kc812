# Сайт Кризисного центра
Победитель конкураса малых сайтов

**Установка на хостинг**

Нужно:
- LAMP: PHP 5.6+ и MySQL 5.6+ (поддержка кодировки utf8mb4)
- Composer для PHP (подробнее об установке), с правами на запуск в папке проекта
- На удаленном сервере: домен, указывающий на папку проекта

Внимание! В инструкции ниже строки `ВАША_БД`, `ВАШ_ПОЛЬЗОВАТЕЛЬ_БД`, `ВАШ_ПАРОЛЬ_БД` и `ВАШ-САЙТ.ru` нужно заменить на реальные данные.

1. Зайти в папку, в которой должен размещаться код сайта (DocumentRoot) и опустошить ее. В ней не должно быть файлов, иначе клонирование будет невозможно.

2. Клонировать репозиторий:
	- `git clone https://github.com/Teplitsa/kc812.git .` (не забудьте точку в конце, она заставляет клонировать код в ту папку, в которой вы находитесь).
	- Если не хостинге не установлен git, можно скопировать архив с сайта https://github.com/Teplitsa/kc812.git, распаковать его и разместить содержимое на хостинге.
	
3. Создать базу и импортировать в нее тестовые данные:
	- `echo 'CREATE DATABASE IF NOT EXISTS ВАША_БД' | mysql --user=ВАШ_ПОЛЬЗОВАТЕЛЬ_БД --password=ВАШ_ПАРОЛЬ_БД` Если в MySQL нет юзера, который имеет права для создания БД, то можно создать БД через административную панель хостинга.
	- `unzip -p ./attachments/startertest.sql.zip | mysql --user=ВАШ_ПОЛЬЗОВАТЕЛЬ_БД --password=ВАШ_ПАРОЛЬ_БД ВАША_БД`
	- Если выполнить команду загрузки данных не получилось, то можно загрузить данные через панель управления хостингом, используя PHPMyAdmin. Для этого нужно импортировать данные из файла ./attachments/startertest.sql.zip.
	
4. Запустить: `composer install` если не срабатывает, то:
	- скачайте composer прямо в папку сайта:
	- `php -r "readfile('https://getcomposer.org/installer');" | php`
	- запустите отключив ограничение памяти:
	- `php -d memory_limit=-1 composer.phar install`
	- если появились сообщения об ошибках, то запустите composer update:
	- `php -d memory_limit=-1 composer.phar update`
	- если на сервере несколько версий php, то вместо php в этих командах нужно указывать конкретную версию:
	- `php5.5 -r "readfile('https://getcomposer.org/installer');" | php5.5`
	
5. Создать конфигурационный файл из шаблона и заполнить в нем информацию о доступе к базе данных и домен:
	- `cat wp-config-orig.php | sed 's/dev_db/ВАША_БД/g;s/dev_user/ВАШ_ПОЛЬЗОВАТЕЛЬ_БД/g;s/dev_password/ВАШ_ПАРОЛЬ_БД/g;s/giger\.local/ВАШ-САЙТ\.ru/g' > wp-config.php`
	
6. Распаковать содержимое папки с изображениями attachments/uploads.zip в wp-content/uploads:
	- `unzip ./attachments/uploads.zip -d ./wp-content/`
	
7. Создать файл .htaccess из шаблона и настроить права доступа к нему:
	- cat ./attachments/.htaccess.orig > .htaccess
	- chmod -v 666 .htaccess
	
8. В базе WP заменить домен giger.local на ВАШ-САЙТ.ru. Для этого нужно скачать утилиту Search-Replace-DB со страницы https://interconnectit.com/products/search-and-replace-for-wordpress-databases/ в папку сайта. Зайти в нее и запустить 2 команды:
	- `php srdb.cli.php -h localhost -n ВАША_БД -u ВАШ_ПОЛЬЗОВАТЕЛЬ_БД -p ВАШ_ПАРОЛЬ_БД -s http://giger.local -r http://ВАШ-САЙТ.ru`
	- `php srdb.cli.php -h localhost -n ВАША_БД -u ВАШ_ПОЛЬЗОВАТЕЛЬ_БД -p ВАШ_ПАРОЛЬ_БД -s giger.local -r ВАШ-САЙТ.ru`
	- Удалить утилиту с сервера.
	
9. Сайт отвечает по адресу http://ВАШ-САЙТ.ru. Вход в админку http://ВАШ-САЙТ.ru/core/wp-login.php с логином giger и паролем 121121. Необходимо создать нового пользователя http://ВАШ-САЙТ.ru/core/wp-admin/user-new.php, а аккаунт giger удалить.


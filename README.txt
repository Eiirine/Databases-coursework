1. Распакуйте Server.zip в корневую папку C:/ открываем Powershell от имени администратора (по команде win + x)
1.1 Вводим c:\Server\bin\Apache24\bin\httpd.exe -k start
Открываем в браузере http://localhost/, если вышло Index of, значит успешно
1.2 Добавляем в переменную окружения PATH путь до папки PHP из папки с сервером https://apache-windows.ru/как-добавить-путь-до-php-в-переменную-окр/
1.3 Вводим C:\Server\bin\mysql-8.0\bin\mysqld --initialize-insecure --user=root
C:\Server\bin\mysql-8.0\bin\mysqld --install //Может ругаться на эту строчку, т.к. по факту все эти файлы уже установлены
net start mysql
Открываем в браузере http://localhost/phpmyadmin/, данные стандарные - логин root, пароль пустой
2. Создайте новую датабазу test и импортируйте файл test.sql в phpMyAdmin 
3. Открываем папку untitled1 в каком-нибудь редакторе (PHPStorm, MV Code, Sublime Text, Notepad++, да хоть в майкрософт блокноте) и открываем просмотр проекта в браузере
Готово, вы восхитительны!
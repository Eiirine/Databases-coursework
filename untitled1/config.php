<?php
//Данные для подключения
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'test';
$charset = "utf8";

//Прописываем обработку успеха и ошибки подключения к базе данных
try {
    $dbh = new PDO('mysql:host=localhost;dbname=test;',
        $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8",
            PDO::ATTR_PERSISTENT => false));
    //echo "Подключились\n"; <- мешается на веб-форме, подумать как оформить?

} catch (PDOException $e) {
    die("Не удалось подключиться: " . $e->getMessage() . "<br/>");
}
//Обработка ошибок
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//Проверка подключения к датабазе через трай-кетч с вводом данных, если появилось в мускуле - значит успех, а оно появилось

/*try {
    $dbh->beginTransaction();
    $dbh->exec("insert into users (name, age, gender) values ('Tav', 23, 'female')");
    //Если успешно
    echo "Запись успешно создана";

    $dbh->commit();

} catch (PDOException $e) {
    $dbh->rollBack();
    //Если не успешно
    echo "Ошибка при записи данных: " . $e->getMessage();
}
//Закрытие соединения
$db = null;
*/


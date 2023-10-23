<?php
include "config.php";

$name = @$_POST['name'];
$age = @$_POST['age'];
$gender = @$_POST['gender'];
$get_id = @$_GET['id'];

//Функция создания записи
if(isset($_POST["add"])){
    $sql = ("INSERT INTO users (name, age, gender) VALUES (?,?,?)"); //Никак не пойму почему ругается на dbh, хотя при этом работает
    $query = $dbh->prepare($sql);
    $query->execute([$name, $age, $gender]);
    if ($query) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
}

//Поиск по таблице
/*try {
    $searchKeyword = !empty($_GET['sq'])?$_GET['sq']:'';
    $name1 = "%$name%";
    $sql = $dbh->prepare("SELECT * FROM `users` WHERE `name` LIKE ?");
    $sql->execute(array($searchKeyword));
    $result = $sql->fetchAll();
} catch (Exception $e) {
    $dbh->rollBack();
    //Если не успешно
    echo "Ошибка при записи данных: " . $e->getMessage();
}*/

//Вывод данных по юзерам из бд в таблицу на веб-странице
try {
    if (!empty($_GET['sq'])){
    $searchKeyword = !empty($_GET['sq'])?$_GET['sq']:'';} else $searchKeyword = "";
    $name1 = "%$searchKeyword%";
    $sql = $dbh->prepare("SELECT `users`.`id`, `users`.`name`, `users`.`age`, IF(`users`.`gender` = 1, 'Мужчина', 'Женщина') AS 'gender' 
                                FROM `users`
                                WHERE `name` LIKE :name1 OR `age` LIKE :age OR `gender` LIKE :gender");
    $sql->execute(array('name1'=>$name1,'age'=>$name1, 'gender'=>$name1));
    $result = $sql->fetchAll();
} catch (Exception $e) {
    //$dbh->rollBack();
    //Если не успешно
    echo "Ошибка при записи данных: " . $e->getMessage();
}

//Апдейт записей
if (isset($_POST["edit"])) {
    $sql = ("UPDATE users SET name=?, age=?, gender=? WHERE id=?");
    $query = $dbh->prepare($sql);
    $query->execute([$name, $age, $gender, $get_id]);
    if ($query) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
}

//Удаление записей
if (isset($_POST["delete"])) {
    $sql = ("DELETE FROM users WHERE id = ?");
    $query = $dbh->prepare($sql);
    $query->execute([$get_id]);
    if ($query) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
}


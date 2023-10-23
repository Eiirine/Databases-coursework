<?php
include "config.php";

$name = @$_POST['name'];
$user_id = @$_POST['user_id'];
$title = @$_POST['title'];
$description = @$_POST['description'];
$get_id = @$_GET['id'];


//Функция создания записи
if(isset($_POST["add"])){
    $sql = ("INSERT INTO posts (user_id, title, description) VALUES ((SELECT id FROM users WHERE name = ? ORDER BY id limit 1),?,?)"); //Никак не пойму почему ругается на dbh, хотя при этом работает
    $query = $dbh->prepare($sql);
    $query->execute([$user_id, $title, $description]);
    if ($query) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
}


//Вывод данных по постам из бд в таблицу на веб-странице
try {
    if (!empty($_GET['sq'])){
        $searchKeyword = !empty($_GET['sq'])?$_GET['sq']:'';} else { $searchKeyword = "";}
    $search = "$searchKeyword%";
    $sql = $dbh->prepare("SELECT `users`.`name`, `posts`.`title`, `posts`.`description`, IFNULL(`posts`.`description`, 'Ничего не найдено..') AS 'description', `posts`.`id`, `posts`.`post_date` 
                                FROM `users` 
                                LEFT JOIN `posts` ON `posts`.`user_id` = `users`.`id`
                                WHERE (`posts`.`title` LIKE :name1) OR (`users`.`name` LIKE :name1) OR (`posts`.`description` LIKE :name1);");
    $sql->execute(array('name1'=>$search));
    $result = $sql->fetchAll();
} catch (Exception $e) {
    $dbh->rollBack();
    //Если не успешно
    echo "Ошибка при записи данных: " . $e->getMessage();
}

/*SELECT `users`.`name`, `posts`.`title`, `posts`.`description`
                                FROM `users`
                                LEFT JOIN `posts` ON `posts`.`user_id` = `users`.`id`
                                WHERE ((`users`.`name` LIKE :name1) OR (`posts`.`title` LIKE :name2) OR (`posts`.`description` LIKE :name3))*/
/*try {
    if (!empty($_GET['sq'])){
        $searchKeyword = !empty($_GET['sq'])?$_GET['sq']:'';} else $searchKeyword = "";
    $name1 = "%$searchKeyword%";
    $sql = $dbh->prepare("SELECT * FROM `posts` WHERE `user_id` LIKE :name1 OR `title` LIKE :title OR `description` LIKE :description");
    $sql->execute(array('user_id'=>$name1,'title'=>$name1, 'description'=>$name1));
    $result = $sql->fetchAll();
} catch (Exception $e) {
    //$dbh->rollBack();
    //Если не успешно
    echo "Ошибка при выводе данных: " . $e->getMessage();
}*/


//Апдейт записей
if (isset($_POST["edit"])) {
    $sql = ("UPDATE posts SET title=?, description=? WHERE id=?");
    $query = $dbh->prepare($sql);
    $query->execute([$title, $description, $get_id]);
    if ($query) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
}

//Удаление записей
if (isset($_POST["delete"])) {
    $sql = ("DELETE FROM posts WHERE id=?");
    $query = $dbh->prepare($sql);
    $query->execute([$get_id]);
    if ($query) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
}
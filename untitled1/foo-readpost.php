<?php

include "config.php";

$name = @$_POST['name'];
$user_id = @$_POST['user_id'];
$title = @$_POST['title'];
$description = @$_POST['description'];
$get_id = @$_GET['id'];

try {
    if (!empty($_GET['sq'])){
        $searchKeyword = !empty($_GET['sq'])?$_GET['sq']:'';} else { $searchKeyword = "";}
    $search = "%$searchKeyword%";
    $sql = $dbh->prepare("SELECT `users`.`name`, `posts`.`title`, 
                                IFNULL(`posts`.`description`, 'Ничего не найдено..') AS 'description', `posts`.`id`, `posts`.`post_date`,
                                (SELECT COUNT(*) 
                                FROM `comments`
                                WHERE post_id = posts.id) AS 'commentcount', 
                                (SELECT COUNT(*) 
                                FROM `likes`
                                WHERE post_id = posts.id) AS 'likescount',
                                (SELECT COUNT(*) 
                                FROM `reposts`
                                WHERE post_id = posts.id) AS 'repostscount'
                                FROM `users` 
                                LEFT JOIN `posts` ON `posts`.`user_id` = `users`.`id`
                                WHERE ((`users`.`name` LIKE :name1) OR (`posts`.`title` LIKE :name2) OR (`posts`.`description` LIKE :name3));");
    $sql->execute(array('name1'=>$search,'name2'=>$search, 'name3'=>$search));
    $result = $sql->fetchAll();
} catch (Exception $e) {
    $dbh->rollBack();
    //Если не успешно
    echo "Ошибка при записи данных: " . $e->getMessage();
}

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
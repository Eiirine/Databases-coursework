<?php


include "config.php";

$name = @$_POST['name'];
$user_id = @$_POST['user_id'];
$title = @$_POST['title'];
$description = @$_POST['description'];
$get_id = @$_GET['id'];

//Вывод данных по постам из бд в таблицу на веб-странице
try {
    if (!empty($_GET['sq'])){
        $searchKeyword = !empty($_GET['sq'])?$_GET['sq']:'';} else { $searchKeyword = "";}
    $search = "$searchKeyword";
    $sql = $dbh->prepare("SELECT `posts`.`title`, `comments`.`id`,`comments`.`text`, `comments`.`comment_date`, `author`.`name` AS 'author', `author_comm`.`name` AS 'author_comm'
                                FROM `posts` 
                                LEFT JOIN `comments` ON `comments`.`post_id` = `posts`.`id`
                                LEFT JOIN users AS author ON author.id = posts.user_id
                                LEFT JOIN users AS author_comm ON author_comm.id = comments.user_id
                                WHERE `posts`.`id` = :name1");
    $sql->execute(array('name1'=>$search));
    $result = $sql->fetchAll();
} catch (Exception $e) {
    //$dbh->rollBack();
    //Если не успешно
    echo "Ошибка при записи данных: " . $e->getMessage();
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
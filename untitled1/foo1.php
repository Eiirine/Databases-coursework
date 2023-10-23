<?php
include "config.php";

//fetch data from database
try {
    $sql = ("SELECT `users`.`name` FROM `users`");
    $datarow = $dbh->prepare($sql);
    //$results = $sql->fetchAll();
} catch (Exception $e) {
    $dbh->rollBack();
    //Если не успешно
    echo "Ошибка при записи данных: " . $e->getMessage();
}
<?php
include 'config.php';
include "foo-comments.php";
include "foo1.php";

@$searchKeyword = !empty($_GET['sq'])?$_GET['sq']:'';
@$searchStr = !empty($searchKeyword)?'?sq='.$searchKeyword:'';

// Search DB query
$searchArr = '';
if(!empty($searchKeyword)){
    $searchArr = array(
        'name' => $searchKeyword,
        'title' => $searchKeyword,
        'description' => $searchKeyword
    );
}
// Get count of the users
$con = array(
    'like_or' => $searchArr,
    'return_type' => 'count'
);


// Get users from database
$con = array(
    'like_or' => $searchArr,
    'order_by' => 'id DESC',
);

function array_unique_key($array, $key) {
    $tmp = $key_array = array();
    $i = 0;

    foreach($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $tmp[$i] = $val;
        }
        $i++;
    }
    return $tmp;
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Список постов</title>
</head>
<body>

<!-- header -->
<nav class="navbar navbar-dark bg-dark justify-content-center">
    <header class="d-flex text-dark py-3">
        <ul class="nav nav-pills navbar-dark bg-dark">
            <li class="nav-item text-dark"><a href="index.php" class="nav-link text-white">Список авторов</a></li>
            <li class="nav-item text-dark"><a href="posts.php" class="nav-link active" aria-current="page">Посты</a></li>
        </ul>
    </header>
</nav>

<div class="container mt-5 mb-3 clearfix col-md-12">


    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Домой</a></li>
            <li class="breadcrumb-item"><a href="posts.php">Посты</a></li>

            <?php
           if (empty($searchKeyword)) {
                ?>
                <li class="breadcrumb-item active" aria-current="page"> Посты пользователя <?=$res['author'] ?></li>
            <?php } elseif (!empty($searchKeyword)) foreach (array_unique_key($result, 'author') as $res) { ?>
               <li class="breadcrumb-item"><a href="posts.php?sq=<?=$res['author'] ?> "> Посты пользователя <?=$res['author']?></a></li>
               <li class="breadcrumb-item"><a href="readpost.php?sq=<?=$res['title'] ?> ">Статистика поста "<?=$res['title'] ?>"</a></li>
               <li class="breadcrumb-item active" aria-current="page">Комментарии к посту "<?=$res['title'] ?>"</li>
            <?php } ?>
        </ol>
    </nav>

    <!-- table -->
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-hover table-bordered mt-2">
                <caption>Список комментариев</caption>
                <thead class="table-dark text-uppercase text-center">
                <th>Автор</th>
                <th>Текст</th>
                <th>Дата публикации</th>
                <th>Действие</th>
                </thead>
                <!-- Здесь должна быть прописана функция сортировки по поиску -
                вывод только соответствующих переменной поиска записей
                Нет, идея была дурацкой, лучше закинуть это в функции-->
                <?php

                    foreach ($result as $res) {
                        ?>
                            <tbody class="table-striped">
                            <td><?=$res['author_comm'] ?></td>
                            <td><?=$res['text'] ?></td>
                            <td class="col-2 text-center align-middle"><?=$res['comment_date'] ?></td>
                            <td class="text-center col-2 align-middle">
                                <a href="" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?=$res['id'] ?>">Удалить</a>
                            </td>

                        <!-- Модальное окно предупреждения об удалении -->
                        <div class="modal fade" id="delete<?=$res['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Удалить запись №<?=$res['id'] ?></h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                                    </div>
                                    <div class="modal-body">Вы точно хотите удалить запись?</div>
                                    <div class="modal-footer">
                                        <form action="?id=<?=$res['id'] ?>" method="post">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                                            <button type="submit" class="btn btn-danger" name="delete">Удалить</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Модальное окно предупреждения об удалении -->
                    <?php } ?>
            </table>
        </div>
    </div>
</div>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

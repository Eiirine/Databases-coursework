<?php include 'config.php';
include "foo-posts.php";
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
            <?php
            if (empty($searchKeyword)) {
            ?>
                <li class="breadcrumb-item">Посты</li>
            <?php } elseif (!empty($searchKeyword)) foreach (array_unique_key($result, 'name') as $res) { ?>
                <li class="breadcrumb-item"><a href="posts.php">Посты</a></li>
                <li class="breadcrumb-item active" aria-current="page">Посты пользователя <?=$res['name'] ?></li>
            <?php } ?>
        </ol>
    </nav>

    <!-- Контейнер с названием, поиском и кнопкой добавления -->
    <div class="d-flex px-1 ">
        <div class="flex-grow-1 g-2"><h2>Новые посты</h2></div>
        <div class="col-3">
            <form class="g-1">
                <div class="input-group">
                    <input type="text" name="sq" class="form-control" placeholder="Введите ключевое слово..." value="<?=$searchKeyword?>">
                    <div class="input-group-btn col-3">
                        <button class="btn btn-success float-end" type="submit">Поиск</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-1 text-truncate"><button class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#create">Новый пост</button></div>
    </div>

<!-- table -->
<div class="row">
    <div class="col-md-12">
        <table class="table table-striped table-hover table-bordered mt-2">
            <caption>Список постов</caption>
            <thead class="table-dark text-uppercase text-center">
            <th>Автор</th>
            <th>Заголовок</th>
            <th>Текст</th>
            <th>Дата публикации</th>
            <th>Действие</th>
            </thead>
            <!-- Здесь должна быть прописана функция сортировки по поиску -
            вывод только соответствующих переменной поиска записей
            Нет, идея была дурацкой, лучше закинуть это в функции-->
            <?php
            if (!empty($result)){ $count = 0;
                foreach ($result as $res) { $count++;
                    if($res['title']!=""){
                    ?>
                    <tbody class="table-striped">
                    <td><?=$res['name'] ?></td>
                        <td><a href="readpost.php?sq=<?=$res['title'] ?> " class="link-dark"><?=$res['title'] ?></a></td>
                    <td><?=$res['description'] ?></td>
                        <td class="col-2 text-center align-middle"><?=$res['post_date'] ?></td>
                    <td class="text-center col-2 align-middle">
                        <a href="post_id=<?=$res['id'] ?>" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#edit<?=$res['id'] ?>">Изменить</a>
                        <a href="" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?=$res['id'] ?>">Удалить</a>
                    </td>
                    <?php } elseif (!empty($searchKeyword)){?>
                        <tr><td colspan="5">Ничего не найдено...</td></tr>
                    <?php }    ?>
                    <!-- Модальное окно изменений -->
                    <div class="modal fade" id="edit<?=$res['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Изменить запись</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="?id=<?=$res['id'] ?>" method="post">
                                        <p>
                                            <label>Заголовок</label><br />
                                            <input name="title" class="form-control"  type="text" value="<?=$res['title']?>"/>
                                        </p>
                                        <p>
                                            <label>Текст</label><br />
                                            <input name="description" class="form-control" type="text" value="<?=$res['description']?>"/>
                                        </p>
                                        <input type="reset" value="Очистить" />

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                                    <button type="submit" class="btn btn-success" name="edit">Сохранить</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Модальное окно изменений -->
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
                    </tbody> <?php } }else{ ?>
                <tr><td colspan="5">Ничего не найдено...</td></tr>
            <?php }    ?>
        </table>
    </div>
</div>
</div>
<!-- Модальное окно добавления -->
<div class="modal fade" id="create" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Добавить запись</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <p>
                        <label>Автор поста</label><br />
                        <input name="user_id" class="form-control" id="pcategory" autocomplete="off" list="datalistOptions" type="text"/>
                        <datalist id="datalistOptions">
                            <!--<option value="<?php /*=$res['name']*/?>">
                            <option value="<?php /*=$res['name']*/?>">
                            <option value="<?php /*=$res['name']*/?>">
                            <option value="<?php /*=$res['name']*/?>">
                            <option value="<?php /*=$res['name']*/?>">-->
                            <?php //while($row = mysqli_fetch_array($result))
                            if(!empty($result)) {
                             foreach (array_unique_key($result, 'name') as $res) { ?> <option value="<?=$res['name'] ?>">
                            <?php } } ?>
                        </datalist>
                    </p>
                    <p>
                        <label>Заголовок</label><br />
                        <input name="title" class="form-control" type="text" />
                    </p>
                    <p>
                        <label>Текст поста</label><br />
                        <input name="description" class="form-control" type="text"/>
                    </p>
                    <input type="reset" value="Очистить" />

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="submit" class="btn btn-success" name="add">Сохранить</button>
            </div>
            </form>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
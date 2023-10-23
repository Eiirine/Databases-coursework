<?php include 'config.php';
include "foo1.php";
include "foo-readpost.php";

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
                <li class="breadcrumb-item active" aria-current="page"> Посты пользователя <?=$res['name'] ?></li>
            <?php } elseif (!empty($searchKeyword)) foreach (array_unique_key($result, 'name') as $res) { ?>
                <li class="breadcrumb-item"><a href="posts.php?sq=<?=$res['name'] ?> "> Посты пользователя <?=$res['name'] ?></a></li>
                <li class="breadcrumb-item active" aria-current="page">Статистика поста "<?=$res['title'] ?>"</li>
            <?php } ?>
        </ol>
    </nav>

    <div>
        <h1><?=$res['title'] ?></h1>
        <p><?=$res['post_date'] ?></p>
        <p><a href="posts.php?sq=<?=$res['name'] ?> " class="link-dark"><?=$res['name'] ?></a></p>
        <p><?=$res['description'] ?></p>
    </div>


    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-hover table-bordered mt-2">
                <caption>Список постов</caption>
                <thead class="table-dark text-uppercase text-center">
                <th>Заголовок</th>
                <th>Дата публикации</th>
                <th>Количество лайков</th>
                <th>Количество комментариев</th>
                <th>Количество репостов</th>
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
                            <td class="col-2"><?=$res['title'] ?></td>
                            <td class="col-2 text-center align-middle"><?=$res['post_date'] ?></td>
                            <td><?=$res['likescount'] ?></td>
                            <?php if ($res['commentcount']>0) { ?>
                            <td><a href="comments.php?sq=<?=$res['id'] ?>" class="link-dark"><?=$res['commentcount'] ?></a></td>
                                <?php } else { ?>
                            <td><?=$res['commentcount'] ?></td>
                            <?php } ?>
                            <td><?=$res['repostscount'] ?></td>


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
                        <?php } elseif (!empty($searchKeyword)){?>
                            <tr><td colspan="5">Ничего не найдено...</td></tr>
                        <?php }    ?>
                        </tbody> <?php } }else{ ?>
                    <tr><td colspan="5">Ничего не найдено...</td></tr>
                <?php }    ?>
            </table>
        </div>
    </div>
</div>

    <!--<div>
        <h3>Комментарии</h3>
    </div>
    Здесь вывод комментариев будет
    <p>Здесь пусто. Будьте первым, кто оставил комментарий!</p>
    <div>
        <div>
            <h3>Оставить комментарий</h3>
            <div class="mb-3">
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-3">Отправить</button>
            </div>
        </div>
    </div>-->


</div>



</body>
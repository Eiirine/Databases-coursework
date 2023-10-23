<?php global $result;
include 'config.php';
include "foo.php";

// Get search keyword
@$searchKeyword = !empty($_GET['sq'])?$_GET['sq']:'';
@$searchStr = !empty($searchKeyword)?'?sq='.$searchKeyword:'';

// Search DB query
$searchArr = '';
if(!empty($searchKeyword)){
    $searchArr = array(
        'name' => $searchKeyword,
        'age' => $searchKeyword,
        'gender' => $searchKeyword
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



?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Курсовой проект Бессонова И.П. 213-322</title>
  </head>
  <body>

  <!-- header -->
  <nav class="navbar navbar-dark bg-dark justify-content-center">
      <header class="d-flex text-dark py-3">
          <ul class="nav nav-pills navbar-dark bg-dark">
              <li class="nav-item text-dark"><a href="index.php" class="nav-link text-white active" aria-current="page">Список авторов</a></li>
              <li class="nav-item text-dark"><a href="posts.php" class="nav-link text-white">Посты</a></li>
          </ul>
      </header>
  </nav>

  <div class="container mt-5 mb-3 clearfix col-md-12">



      <!-- Контейнер с названием, поиском и кнопкой добавления -->
      <div class="d-flex px-1 ">
          <div class="flex-grow-1 g-2"><h2>Список авторов нашего блога</h2></div>
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
          <div class="col-2 text-truncate"><button class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#create">Добавить нового пользователя</button></div>
      </div>

      <!-- Контейнер с таблицей -->
      <div class="row">
          <div class="col-md-12">
              <table class="table table-striped table-hover table-bordered mt-2">
                  <caption>Список наших авторов</caption>
                  <thead class="table-dark">
                      <th></th>
                      <th>Имя</th>
                      <th>Возраст</th>
                      <th>Пол</th>
                      <th>Действие</th>
                  </thead>
                  <!-- Здесь должна быть прописана функция сортировки по поиску -
                  вывод только соответствующих переменной поиска записей
                  Нет, идея была дурацкой, лучше закинуть это в функции-->
                  <?php
                  if (!empty($result)){ $count = 0;
                      foreach ($result as $res) { $count++;
                      ?>
                  <tbody class="table-striped">
                      <td class="col-1"><?php echo 'Запись №'.$count; ?></td>
                      <td><a href="posts.php?sq=<?=$res['name'] ?> " class="link-dark"><?=$res['name'] ?></a></td>
                      <td><?=$res['age'] ?></td>
                      <td><?=$res['gender'] ?></td>
                      <td class="text-center col-2">
                          <a href="name=<?=$res['id'] ?>" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#edit<?=$res['id'] ?>">Изменить</a>
                          <a href="" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?=$res['id'] ?>">Удалить</a>
                      </td>

                      <!-- Модальное окно изменений -->
                      <div class="modal fade" id="edit<?=$res['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h1 class="modal-title fs-5" id="staticBackdropLabel">Изменить данные пользователя <?=$res['name'] ?></h1>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                                  </div>
                                  <div class="modal-body">
                                      <form action="?id=<?=$res['id'] ?>" method="post">
                                          <p>
                                              <label>Имя</label><br />
                                              <input name="name" class="form-control" type="text" value="<?=$res['name']?>"/>
                                          </p>
                                          <p>
                                              <label>Возраст:</label><br />
                                              <input name="age" class="form-control" type="number" value="<?=$res['age']?>"/>
                                          </p>

                                              <label>Пол</label><br />
                                          <div class="form-check form-check-inline">
                                              <input class="form-check-input" type="radio" name="gender" id="male" value="1">
                                              <label class="form-check-label" for="gender">
                                                  Мужчина
                                              </label>
                                          </div>
                                          <div class="form-check form-check-inline">
                                              <input class="form-check-input" type="radio" name="gender" id="female" value="2">
                                              <label class="form-check-label" for="gender">
                                                  Женщина
                                              </label>
                                          </div><br><br>
                                          <input type="reset" value="Очистить" />
                                  </div>
                                  <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                                      <button type="submit" class="btn btn-success" name="edit">Сохранить изменения</button>
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
                                      <h1 class="modal-title fs-5" id="staticBackdropLabel">Удалить запись <?=$res['name'] ?></h1>
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
                              <label>Имя</label><br />
                              <input name="name" class="form-control" type="text"/>
                          </p>
                          <p>
                              <label>Возраст</label><br />
                              <input name="age" class="form-control" type="number" />
                          </p>
                          <p>
                              <label>Пол</label><br />
                          <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="gender" id="male" value="1">
                              <label class="form-check-label" for="gender">
                                  Мужчина
                              </label>
                          </div>
                          <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="gender" id="female" value="0">
                              <label class="form-check-label" for="gender">
                                  Женщина
                              </label>
                          </div>
                              <!--<input name="gender" class="form-control" type="boolean"/>-->
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

  </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>
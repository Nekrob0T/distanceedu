<?php
  if(isset($_GET['exit'])){
    session_destroy();
    header('Location:'. HOST .'?mode=login');
    exit;
  }

  if (isset($_POST['submit'])) {
    $user = R::findOne('users', "login = ?", array($_POST['login']));
    if(empty($_POST['login'])){
      $errors[] = 'Логін не може бути порожнім';
    }
    if(empty($_POST['pass'])){
      $errors[] = 'Пароль не може бути порожнім';
    }
    if($user) {
      if(md5($_POST['pass']) == $user->password) {
        $_SESSION['login'] = $_POST['login'];
        header("Location: ".HOST."?mode=profile");
      } else {
        $errors[] = 'Невірний пароль';
      }
    } else {
      $errors[] = 'Користувача з таким логіном не знайдено';
    }

    if (count($errors) > 0) {
      $printErr = true;
    }
  }
?>
<title>Авторизація</title>

<h1 class="blue">Вхід у систему</h1>
<div class="container">
  <div class="col-lg-6 offset-lg-3 col-8 offset-2">
    <form class="form" method="POST">
      <div class="form-group">
        <label>Логін</label>
        <input class="form-control" type="text" name="login" value="<?php echo $_POST['login'] ?>"/>
      </div>
      <div class="form-group">
        <label>Пароль</label>
        <input class="form-control" type="password" name="pass" value="<?php echo $_POST['pass'] ?>"/>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-success" name="submit">Ввійти</button>
        <a href="<?php echo HOST ?>?mode=reg" style="display: block;">Зареєструватись</a>
      </div>
    </form>

    <?php
      if($printErr) {
        echo '<p style="text-align: center; color: red; font-weight: bold;">'.array_shift($errors).'</p>';
      }
    ?>

  </div>
</div>
<script src="../js/main.js"></script>
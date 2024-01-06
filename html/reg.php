<?php

  if (isset($_POST['submit'])) {
    if(empty($_POST['login'])){
      $errors[] = 'Логін не може бути порожнім';
    }
    if(empty($_POST['email'])){
      $errors[] = 'Email не може бути порожнім';
    } else {
      if(!emailValid($_POST['email'])) {
        $errors[] = 'Email введений не коректно';
      }
    }
    if(empty($_POST['pass'])){
      $errors[] = 'Пароль не може бути порожнім';
    } else {
      if(strlen($_POST['pass']) < 8) {
        $errors[] = 'Пароль закороткий';
      }
    }
    if(empty($_POST['pass2'])){
      $errors[] = 'Підтвердження паролю не може бути порожнім';
    }
    if(R::count('users', "login = ?", array($_POST['login'])) > 0){
      $errors[] = 'Користувач з таким іменем зареєстрований';
    }
    if(R::count('users', "email = ?", array($_POST['email'])) > 0){
      $errors[] = 'Користувач з такою поштою зареєстрований';
    }

    if (count($errors) > 0) {
      $printErr = true;
    } else {
      if($_POST['pass'] != $_POST['pass2']) {
        $errors[] = 'Паролі не ідентичні';
      }
			if(count($errors) > 0) {
        $printErr = true;
      } else {
        $user = R::dispense('users');
        $user->login = $_POST['login'];
        $user->email = $_POST['email'];
        $user->password = md5($_POST['pass']);
        $user->admin = false;
        $user->teacher = false;
        $user->avatar = "";
        $user->name = "";
        $user->surname = "";
        $user->city = "";
        $user->country = "";
        $user->phone = "";
        R::store($user);
        $_SESSION['login'] = $_POST['login'];
        header("Location: ".HOST."?mode=profile");
      }
    }
  }
?>
<title>Регістрація у систему</title>
<h1 class="blue">Регістрація у систему</h1>

<div class="container">
  <div class="col-lg-6 offset-lg-3 col-8 offset-2">
    <form method="POST" class="form">
      <div class="form-group">
        <label>Логін</label>
        <input class="form-control" type="text" name="login" value="<?php echo $_POST['login'] ?>"/>
      </div>
      <div class="form-group">
        <label>E-mail</label>
        <input class="form-control" type="email" name="email" value="<?php echo $_POST['email'] ?>"/>
      </div>
      <div class="form-group">
        <label>Пароль</label>
        <input class="form-control" type="password" name="pass" value="<?php echo $_POST['pass'] ?>"/>
      </div>
      <div class="form-group">
        <label>Підтвердіть пароль</label>
        <input class="form-control" type="password" name="pass2" value="<?php echo $_POST['pass2'] ?>"/>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-success" name="submit">Зареєструватись</button>
        <a href="<?php echo HOST ?>?mode=login" style="display: block;">Ввійти</a>
      </div>
    </form>

    <?php
      if($printErr) {
        echo '<p style="text-align: center; color: red; font-weight: bold;">'.array_shift($errors).'</p>';
      }
    ?>

  </div>
</div>
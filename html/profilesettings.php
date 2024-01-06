<?php
  $user = R::findOne('users', 'login = ?', array($_SESSION['login']));

  if (isset($_POST['submit'])) {
    if(empty($_POST['name'])){
      $errors[] = 'Ім\'я не може бути порожнім';
    }
    if(empty($_POST['surname'])){
      $errors[] = 'Прізвище не може бути порожнім';
    }
    if(empty($_POST['pobat'])){
      $errors[] = 'По-батькові не може бути порожнім';
    }
    if(empty($_POST['country'])){
      $errors[] = 'Країна не може бути порожня';
    }
    if(empty($_POST['city'])){
      $errors[] = 'Місто не може бути порожнім';
    }
    if(empty($_POST['email'])){
      $errors[] = 'Email не може бути порожнім';
    }
    if(empty($_POST['phone'])){
      $errors[] = 'Телефон не може бути порожнім';
    }
    if ($user->teacher) {
      if(empty($_POST['desc'])){
        $errors[] = 'Про себе не може бути порожнім';
      }
    }
    if (is_uploaded_file($_FILES['avatar']['tmp_name'])) {
      $tmp_name = $_FILES['avatar']['tmp_name'];
      $name = basename($_FILES['avatar']['name']);
      move_uploaded_file($tmp_name, "img/user/$name");
      $user->avatar = $name;
      R::store($user);
    }

    if (count($errors) > 0) {
      $printErr = true;
    } else {
      $user->name = $_POST['name'];
      $user->surname = $_POST['surname'];
      $user->country = $_POST['country'];
      $user->pobat = $_POST['pobat'];
      $user->city = $_POST['city'];
      $user->email = $_POST['email'];
      $user->phone = $_POST['phone'];
      if ($user->teacher) {
        $user->desc = $_POST['desc'];
        $user->shortdesc = substr($_POST['desc'], 0, 100)."...";
      }  
      
      R::store($user);

      header("Location: ".HOST."?mode=profile");
    }
  }
?>
<title>Налаштування профіля</title>

<h1 class="blue">Налаштування</h1>

<div class="container">
  <div class="col-lg-6 offset-lg-3 col-8 offset-2">
    <form class="form" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <p style="display: inline-block;">
          <input class="form-control" type="button" value="АВАТАР" onclick="document.getElementById('file').click();" />
          <input type="file" style="display:none;" id="file" name="avatar"/>
        </p>
        <p style="display: inline-block;">Ім'я:
          <input class="form-control" type="text" name="name" value="<?php echo $user->name ?>"/>
        </p>
      </div>
      <div class="form-group">
        <p style="display: inline-block;">Прізвище:
          <input class="form-control" type="text" name="surname" value="<?php echo $user->surname ?>"/>
        </p>
        <p style="display: inline-block;">По-батькові:
          <input class="form-control" type="text" name="pobat" value="<?php echo $user->pobat ?>"/>
        </p>
      </div>
      <div class="form-group">
        <p style="display: inline-block;">Країна:
          <input class="form-control" type="text" name="country" value="<?php echo $user->country ?>"/>
        </p>
        <p style="display: inline-block;">Місто:
          <input class="form-control" type="text" name="city" value="<?php echo $user->city ?>"/>
        </p>
      </div>
      <div class="form-group">
        <p style="display: inline-block;">Пошта:
          <input class="form-control" type="text" name="email" value="<?php echo $user->email ?>"/>
        </p>
        <p style="display: inline-block;">Телефон:
          <input class="form-control" type="text" name="phone" value="<?php echo $user->phone ?>"/>
        </p>
      </div>
      <?php
        if ($user->teacher) {
          echo '<div class="form-group">
                  <p>Про себе:
                    <textarea class="form-control" type="text" name="desc" value="'.$user->desc.'"></textarea>
                  </p>
                </div>';
        }
      ?>
      <div class="form-group">
        <button type="submit" class="btn btn-success" name="submit">Зберегти</button>
      </div>
    </form>
      <?php
        if($printErr) {
          echo '<p style="text-align: center; color: red; font-weight: bold;">'.array_shift($errors).'</p>';
        }
      ?>
  </div>
</div>

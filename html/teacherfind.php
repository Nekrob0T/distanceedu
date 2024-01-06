<?php
  $teachers = R::findAll('users', 'teacher = true');
?>
<title>Пошук вчителя</title>

<div class="container">
  <?php include 'header.php'; ?>

  <h2 class="blue">Пошук вчителя</h2>
  <form method="post">
    <div class="row">
      <div class="col-8">
          <input type="search" name="search" class="form-control" value="<?php echo $_POST['search'] ?>">
      </div>
      <div class="col">
        <button class="btn btn-success" name="submit">Знайти</button>
      </div>
    </div>
  </form>

  <div class="row">
    <?php
      foreach ($teachers as $teacher) {
        if ($teacher->surname == trim($_POST['search']) || $teacher->name == trim($_POST['search']) || $teacher->pobat == trim($_POST['search'])) {
          echo '<div class="col-xl-4 col-md-6 col-12">
                  <a href="'.HOST.'?mode=teacherview&teacherid='.$teacher->id.'">
                    <div class="article">
                      <div class="row">
                          <div class="col-4">
                              <div class="teacher-photo">
                                  <img src="'.HOST.'/img/user/'.$teacher->avatar.'" alt="img" style="width: 100px; height: 100px">
                              </div>
                          </div>
                          <div class="col">
                              <div class="teacher-header">
                                  <h4 class="blue">'.$teacher->surname.' '.$teacher->name.' '.$teacher->pobat.'</h4>
                              </div>
                              <div class="teacher-description">
                                  <p>'.$teacher->shortdesc.'</p>
                              </div>
                          </div>
                      </div>
                    </div>
                  </a>
                </div>';
        }
      }
    ?>
  </div>
</div>
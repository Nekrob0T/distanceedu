<?php
  $user = R::findOne('users', 'login = ?', array($_SESSION['login']));
?>

<header>
  <nav class="navbar navbar-expand-lg" style="padding: 0">
    <a class="navbar-brand disabled"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon" style="background: none; color: #fff;"><i class="fa fa-bars" aria-hidden="true"></i></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <div class="nav-element<?php if($_GET['mode'] == 'articles') { echo ' current'; } ?>"><a href="<?php echo HOST."?mode=articles" ?>">Статті</a></div>
        </li>
        <li class="nav-item">
          <div class="nav-element<?php if($_GET['mode'] == 'groups') { echo ' current'; } ?>"><a href="<?php echo HOST."?mode=groups" ?>">Спільнота</a></div>
        </li>
        <li class="nav-item">
          <div class="nav-element<?php if($_GET['mode'] == 'messages') { echo ' current'; } ?>"><a href="<?php echo HOST."?mode=messages" ?>">Повідомлення</a></div>
        </li>

        <?php
          if(!$user->teacher) {
            echo '<li class="nav-item">
                    <div class="nav-element';
                    if($_GET['mode'] == 'teacherfind') { echo ' current'; }
                    echo '"><a href="'.HOST.'?mode=teacherfind">Знайти вчителя</a></div>
                  </li>';
          }
        ?>

        <li class="nav-item">
          <div class="nav-profile" id="nav-profile" style="margin-left: 10px">
            <a href="<?php echo HOST."?mode=profile" ?>">
              <?php
                if (empty($user->avatar)) {
                  echo '<img src="'.HOST.'/img/user.png" alt="img" class="img-border"/>';
                } else {
                  echo '<img src="'.HOST.'/img/user/'.$user->avatar.'" alt="img" class="img-border"/>';
                }
              ?>
              <span id="user-name"><?php echo $user->login ?></span>
            </a>
            <div class="settings"><a href="<?php echo HOST."?mode=profilesettings" ?>"><i class="fa fa-cog"></i></a></div>
          </div>
        </li>
      </ul>
    </div>
  </nav>
</header>

<script>
    if(window.innerWidth >= 992) {
      let elem = document.getElementById('navbarNav');
      elem.style.display = 'flex';
      elem.style.justifyContent = 'space-around';
    } else {
      let elem = document.getElementById('nav-profile');
      elem.style.marginLeft = '40px';
      elem.style.marginBottom = '20px';
    }
</script>
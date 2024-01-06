<?php
  if ($user->teacher) {
    $articles = R::findAll('teachersarticles', 'user = ?', array($user->login));
  } else {
    $articles = R::findAll('articles', 'user = ?', array($user->login));
  }
?>

<title>Профіль</title>

<div class="container">
  <?php include 'header.php'; ?>

  <h2 class="blue">Профіль</h2>

  <div class="row article">
    <div class="col-3 col-md-2">
      <?php if(!empty($user->avatar)) {
        echo '<img src="'.HOST.'/img/user/'.$user->avatar.'" alt="" class="img-border" style="width: 100px; height: 100px">';
      } else {
        echo '<img src="'.HOST.'/img/user/user.png" alt="" class="img-border" style="width: 100px; height: 100px">';
      } ?>
    </div>
    <div class="col">
      <div class="row">
        <div class="col">
          <h4 class="blue"><?php echo $user->surname.' '.$user->name.' '.$user->pobat ?></h4>
        </div>
        <div class="col" style="text-align: right">
          <a href="<?php echo HOST ?>?mode=login&exit=true" class="btn btn-danger">Вийти</a>
        </div>
      </div>
      <div class="row" style="color: #fff">
        <div class="col">
          <?php 
            if ($user->teacher) {
              echo '<p>Про себе: ';
              echo !empty($user->desc) ? $user->desc : "Undefined";
              echo '</p>';
            }
          ?>
        </div>
      </div>
      
      <div class="row" style="color: #fff">
        <div class="col-12 col-lg-3">
            <p>Країна: <input type="text" class="form-control" value="<?php echo $user->country ?>" disabled></p>
        </div>
        <div class="col-12 col-lg-3">
            <p>Місто: <input type="text" class="form-control" value="<?php echo $user->city ?>" disabled></p>
        </div>
        <div class="col-12 col-lg-3">
            <p>Телефон: <input type="text" class="form-control" value="<?php echo $user->phone ?>" disabled></p>
        </div>
        <div class="col-12 col-lg-3">
            <p>Email: <input type="text" class="form-control" value="<?php echo $user->email ?>" disabled></p>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
      <?php
        if ($user->teacher) {
          foreach($articles as $article) {
            echo '<div class="col-lg-4 col-md-6 col-12">
                    <a href="'.HOST.'?mode=articlesview&articleid='.($article->id).'&teacherid='.$user->id.'">
                      <div style="background: #010042; margin: 20px 0;">
                        <div class="article-photo"><img src="'.HOST.'/img/article/'.$article->img.'" style="width: 100%; height: 150px"></div> 
                        <h3 class="article-header blue" style="margin-left: 20px">'.$article->header.'</h3>
                        <p class="article-description" style="margin-left: 20px">'.$article->shortdesc.'</p>
                        <div class="row">
                            <div class="col-3" style="color: #fff; font-size: 12px; margin-left: 20px"><i class="fa fa-eye" aria-hidden="true" style="margin-right: 5px"></i>'.$article->viewscount.'</div>
                            <div class="col-2" style="color: #fff; font-size: 12px"><i class="fa fa-comment" aria-hidden="true" style="margin-right: 5px"></i>'.$article->commentscount.'</div>
                            <div class="col-2" style="font-size: 12px; 
                            color: #fff; 
                            margin-left: 20px">'.$article->user.'</div>
                            <div class="col-2" style="font-size: 12px;
                            color: #fff; 
                            margin-right: 20px; padding-bottom: 20px">'.$article->createdate.'</div>
                        </div>
                      </div>
                    </a>
                </div>';
          }
        } else {
          foreach($articles as $article) {
            echo '<div class="col-lg-4 col-md-6 col-12">
                    <a href="'.HOST.'?mode=articlesview&articleid='.($article->id).'">
                      <div style="background: #010042; margin: 20px 0;">
                        <div class="article-photo"><img src="'.HOST.'/img/article/'.$article->img.'" style="width: 100%; height: 150px"></div> 
                        <h3 class="article-header blue" style="margin-left: 20px">'.$article->header.'</h3>
                        <p class="article-description" style="margin-left: 20px">'.$article->shortdesc.'</p>
                        <div class="row">
                            <div class="col-3" style="color: #fff; font-size: 12px; margin-left: 20px"><i class="fa fa-eye" aria-hidden="true" style="margin-right: 5px"></i>'.$article->viewscount.'</div>
                            <div class="col-2" style="color: #fff; font-size: 12px"><i class="fa fa-comment" aria-hidden="true" style="margin-right: 5px"></i>'.$article->commentscount.'</div>
                            <div class="col-2" style="font-size: 12px; 
                            color: #fff; 
                            margin-left: 20px">'.$article->user.'</div>
                            <div class="col-2" style="font-size: 12px;
                            color: #fff; 
                            margin-right: 20px; padding-bottom: 20px">'.$article->createdate.'</div>
                        </div>
                      </div>
                    </a>
                </div>';
          }
        }
      ?>
    </div>
  
</div>
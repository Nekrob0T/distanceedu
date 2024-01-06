<?php
    $teacher = R::findOne('users', 'id = ?', array($_GET['teacherid']));
    $articles = R::findAll('teachersarticles', 'teacherid = ?', array($_GET['teacherid']));
?>

<title>Акаунт вчителя</title>

<div class="container">
  <?php include 'header.php'; ?>

    <div class="row article">
        <div class="col-3 col-md-2">
            <div class="teacher-icon">
                <img src="<?php echo HOST ?>/img/user/<?php echo $teacher->avatar ?>" alt="img" style="width: 100px; height: 100px">
            </div>
        </div>
        <div class="col">
            <div class="teacher-header">
                <div class="row">
                    <div class="col">
                        <h4 class="blue"><?php echo $teacher->surname.' '.$teacher->name.' '.$teacher->pobat ?></h4>
                    </div>
                    <div class="col offset-md-2" style="text-align: right">
                        <a href="<?php echo HOST ?>?mode=messagesview&idto=<?php echo $teacher->id ?>&idfrom=<?php echo $user->id ?>" class="btn btn-success">Написати</a>;
                    </div>
                </div>
            </div>
            <div class="teacher-description" style="color: #fff">
                <p><?php echo $teacher->desc ?></p>
                <div class="row">
                    <div class="col-12 col-lg-3">
                        <p>Країна: <input type="text" class="form-control" value="<?php echo $teacher->country ?>" disabled></p>
                    </div>
                    <div class="col-12 col-lg-3">
                        <p>Місто: <input type="text" class="form-control" value="<?php echo $teacher->city ?>" disabled></p>
                    </div>
                    <div class="col-12 col-lg-3">
                        <p>Телефон: <input type="text" class="form-control" value="<?php echo $teacher->phone ?>" disabled></p>
                    </div>
                    <div class="col-12 col-lg-3">
                        <p>Email: <input type="text" class="form-control" value="<?php echo $teacher->email ?>" disabled></p>
                    </div>
                </div>
            </div> 
        </div>
    </div>

    <div class="row">
        <?php
            foreach($articles as $article) {
                echo '<div class="col-lg-4 col-md-6 col-12">
                        <a href="'.HOST.'?mode=articlesview&articleid='.($article->id).'&teacherid='.$teacher->id.'">
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
        ?>
    </div>
</div>
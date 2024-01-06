<?php
    if (isset($_GET['groupid'])) {
		$article = R::findOne('groupsarticles', 'id = ? AND groupid = ?', array($_GET['articleid'], $_GET['groupid']));
		$comments = R::findAll('articlescomments', 'articleid = ? AND groupid = ?', array($_GET['articleid'], $_GET['groupid']));
        $article->viewscount++;
        R::store($article);
    } else if (isset($_GET['teacherid'])) {
		$article = R::findOne('teachersarticles', 'id = ? AND teacherid = ?', array($_GET['articleid'], $_GET['teacherid']));
		$comments = R::findAll('articlescomments', 'articleid = ? AND teacherid = ?', array($_GET['articleid'], $_GET['teacherid']));
        $article->viewscount++;
        R::store($article);
    } else {
        $article = R::findOne('articles', 'id = ?', array($_GET['articleid']));
		$comments = R::findAll('articlescomments', 'articleid = ?', array($_GET['articleid']));
        $article->viewscount++;
        R::store($article);
    }

    if (isset($_POST['submit'])) {
        if (empty($_POST['comment'])) {
            $errors[] = "Коментар не може бути пустим";
            $printErr = true;
        } else {
            $nComment = R::dispense('articlescomments');
            $nComment->articleid = $_GET['articleid'];
            $nComment->text = $_POST['comment'];
            $nComment->user = $user->login;
            $nComment->createdate = date('d.m.Y');

            if (isset($_GET['groupid'])) {
                $article = R::findOne('groupsarticles', 'id = ? AND groupid = ?', array($_GET['articleid'], $_GET['groupid']));
                $article->commentscount++;
                R::store($article);
                $nComment->groupid = $_GET['groupid'];
            } else if (isset($_GET['teacherid'])) {
                $article = R::findOne('teachersarticles', 'id = ? AND groupid = ?', array($_GET['articleid'], $_GET['groupid']));
                $article->commentscount++;
                R::store($article);
                $nComment->teacherid = $_GET['teacherid'];
            } else {
                $article = R::findOne('articles', 'id = ?', array($_GET['articleid']));
                $article->commentscount++;
                R::store($article);
            }
            
            R::store($nComment);
            header("Location: ".HOST."?mode=articlesview&articleid=".$_GET['articleid']);
        }
    }
?>

<title>Перегляд статті</title>

<div class="container">
    <?php include 'header.php'; ?>

    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="article" style="padding: 20px">
                <div class="row">
                    <div class="col col-md-4 col-lg">
                        <h2 class="article-header blue"><?php echo $article->header ?></h2>
                    </div>
                    <?php
                        if ($user->admin || $user->login == $article->user) {
                            if (isset($_GET['groupid'])) {
                                echo '<div class="col-md-2 offset-md-2 col-6" style="text-align: right;">
                                        <a href="'.HOST.'?mode=articlesmodify&groupid='.$_GET['groupid'].'&articleid='.$_GET['articleid'].'" class="btn btn-primary">Редагувати</a>
                                    </div>
                                    <div class="col-md-2 offset-md-1 offset-lg-0 col-6" style="text-align: right;">
                                        <a href="'.HOST.'?mode=articlesdelete&groupid='.$_GET['groupid'].'&articleid='.$_GET['articleid'].'" class="btn btn-danger">Видалити</a>
                                    </div>';
                            } else if (isset($_GET['teacherid'])) {
                                echo '<div class="col-md-2 offset-md-2 col-6" style="text-align: right;">
                                        <a href="'.HOST.'?mode=articlesmodify&teacherid='.$_GET['teacherid'].'&articleid='.$_GET['articleid'].'" class="btn btn-primary">Редагувати</a>
                                    </div>
                                    <div class="col-md-2 offset-md-1 offset-lg-0 col-6" style="text-align: right;">
                                        <a href="'.HOST.'?mode=articlesdelete&teacherid='.$_GET['teacherid'].'&articleid='.$_GET['articleid'].'" class="btn btn-danger">Видалити</a>
                                    </div>';
                            } else {
                                echo '<div class="col-md-2 offset-md-2 col-6" style="text-align: left;">
                                        <a href="'.HOST.'?mode=articlesmodify&articleid='.$_GET['articleid'].'" class="btn btn-primary">Редагувати</a>
                                    </div>
                                    <div class="col-md-2 offset-md-1 offset-lg-0 col-6" style="text-align: right;">
                                        <a href="'.HOST.'?mode=articlesdelete&articleid='.$_GET['articleid'].'" class="btn btn-danger">Видалити</a>
                                    </div>';
                            }
                        }
                    ?>
                </div>
                <p class="article-description" style="color: #fff;">
                    <?php 
                        if (!empty($article->video)) {
                            echo '<div class="row">
                                    <div class="col">
                                        <video controls>
                                          <source src="'.HOST.'/img/video/'.$article->video.'" type="video/mp4">
                                        </video>
                                    </div>
                                </div>';
                        }
                    ?>
                    <div class="row" style="color: #fff; margin: 0">
                        <?php echo $article->desc ?>
                    </div>
                </p>
                <div class="row">
                    <div class="col-2" style="font-size: 12px; color: #fff;"><?php echo $article->user ?></div>
                    <div class="col-2 offset-8" style="font-size: 12px; color: #fff; text-align: right;"><?php echo $article->createdate ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col offset-md-1">
            <h4 class="blue">Коментарі</h4>
        </div>
    </div>

	<form method="post">
		<div class="row offset-md-1">
            <div class="col-8">
                <input type="text" class="form-control" name="comment">
            </div>
            <div class="col">
                <button class="btn btn-success" name="submit">Залишити коментар</button>
            </div>
		</div>
	</form>
    
    <?php
		if($printErr) {
			echo '<p style="text-align: center; color: red; font-weight: bold;">'.array_shift($errors).'</p>';
		}
	?> 

    <div class="row">
		<?php
			foreach ($comments as $comment) {
				$user = R::findOne('users', 'login = ?', array($comment->user));

				echo '<div class="col-md-10 offset-md-1" style="color: #fff;">
						<div class="row article">
							<div class="col-2 col-xl-1">
								<div class="user-icon">
									<img src="'.HOST.'/img/user/'.$user->avatar.'" alt="img" class="img-border" style="width: 50px; height: 50px">
								</div>
							</div>
							<div class="col">
								<div class="comment-text">
									<div class="row">
										<p>'.$comment->text.'</p>
									</div>
									<div class="row">
										<div class="col">
											<p>'.$comment->user.'</p>
										</div>
										<div class="col" style="text-align: right;">
											<p>'.$comment->createdate.'</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>';
			}
		?>
    </div>
</div>
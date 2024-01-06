<?php
    $articles = R::findAll('articles');
?>
<title>Статті</title>

<div class="container">
    <?php include 'header.php'; ?>
    
    <div class="row">
        <div class="col-2">
            <h1 class="blue">Статті</h1>
        </div>
        <div class="col offset-md-7 col-md-3" style="text-align: right">
            <?php 
                if ($user->teacher) {
                    echo '<a href="'.HOST.'?mode=articlescreate&teacherid='.$user->id.'" class="btn btn-success">Створити статтю</a>';
                } else {
                    echo '<a href="'.HOST.'?mode=articlescreate" class="btn btn-success">Створити статтю</a>';
                }
            ?>
        </div>
    </div>
    <div class="row">
        <?php
            foreach($articles as $article) {
                echo '<div class="col-xl-4 col-md-6 col-12">
                        <a href="'.HOST.'?mode=articlesview&articleid='.($article->id).'">
                            <div style="background: #010042; margin: 20px 0;">
                                <div class="article-photo"><img src="'.HOST.'/img/article/'.$article->img.'" style="width: 100%; height: 150px"></div> 
                                <h3 class="article-header blue" style="margin: 0 20px">'.$article->header.'</h3>
                                <p class="article-description" style="margin: 5px 20px">'.$article->shortdesc.'</p>
                                <div class="row">
                                    <div class="col-2" style="color: #fff; font-size: 12px; margin-left: 20px"><i class="fa fa-eye" aria-hidden="true" style="margin-right: 5px"></i>'.$article->viewscount.'</div>
                                    <div class="col-3 col-md-2" style="color: #fff; font-size: 12px"><i class="fa fa-comment" aria-hidden="true" style="margin-right: 5px"></i>'.$article->commentscount.'</div>
                                    <div class="col-2" style="font-size: 12px; 
                                    color: #fff; 
                                    margin-left: 20px; text-align:right">'.$article->user.'</div>
                                    <div class="col" style="font-size: 12px;
                                    color: #fff; 
                                    margin-right: 20px; padding-bottom: 20px; text-align:right">'.$article->createdate.'</div>
                                </div>
                            </div>
                        </a>
                    </div>';
            }
        ?>
    </div>
</div>
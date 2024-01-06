<?php
    $group = R::findOne('groups', 'id = ?', array($_GET['groupid']));
    $gArticles = R::findAll('groupsarticles', 'groupid = ?', array($_GET['groupid']));
?>

<title>Перегляд групи</title>

<div class="container">
    <?php include 'header.php'; ?>

    <div class="row article">
        <div class="col-12 col-md-3 col-xl-2">
            <div class="group-icon">
                <img src="<?php echo HOST ?>/img/group/<?php echo $group->icon ?>" alt="img" style="width: 100px; height: 100px">
            </div>
        </div>
        <div class="col">
            <div class="group-header">
                <h4 class="blue"><?php echo $group->header ?></h4>
            </div>
            <div class="group-description">
                <p style="color: #fff;"><?php echo $group->desc ?></p>
            </div>
            <div class="row">
                <div class="col-1" style="color: #fff;"><i class="fa fa-users" aria-hidden="true" style="margin-right: 5px"></i><?php echo $group->userscount ?></div>
                <div class="col-1" style="color: #fff;"><i class="fa fa-file-text" aria-hidden="true" style="margin-right: 5px"></i><?php echo $group->articlescount ?></div>
                <div class="col-5" style="color: #fff;">Творці: <?php echo $group->creators ?></div>
                <div class="col" style="text-align: right">
                    <?php
                        if ($user->login == $group->creators) {
                            echo '<a href="'.HOST.'?mode=articlescreate&groupid='.$_GET['groupid'].'" class="btn btn-success">Створити статтю</a>';
                        } else {
                            if (isset($_GET['newuser'])) {
                                if ($_GET['newuser'] == 'true') {
                                    $group->userscount++;
                                    R::store($group);
                                    
                                    echo '<a href="'.HOST.'?mode=groupsview&groupid='.($_GET['groupid']).'&newuser=false" class="btn btn-danger">Відписатись</a>';
                                } else {
                                    $group->userscount--;
                                    R::store($group);
                                    
                                    echo '<a href="'.HOST.'?mode=groupsview&groupid='.($_GET['groupid']).'&newuser=true" class="btn btn-success">Підписатись</a>';
                                }
                            } else {
                                echo '<a href="'.HOST.'?mode=groupsview&groupid='.($_GET['groupid']).'&newuser=true" class="btn btn-success">Підписатись</a>';
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <?php
            foreach($gArticles as $gArticle) {
                echo '<div class="col-xl-4 col-md-6 col-12">
                            <a href="'.HOST.'?mode=articlesview&groupid='.$_GET['groupid'].'&articleid='.($gArticle->id).'">
                                <div style="
                                background: #010042;
                                margin: 20px 0;">
                                    <div class="article-photo"><img src="'.HOST.'/img/article/'.$gArticle->img.'" style="width: 100%; height: 150px"></div> 
                                    <h3 class="article-header blue" style="margin-left: 20px">'.$gArticle->header.'</h3>
                                    <p class="article-description" style="margin-left: 20px">'.$gArticle->shortdesc.'</p>
                                    <div class="row">
                                        <div class="col" style="font-size: 12px; 
                                        color: #fff; 
                                        margin-left: 20px">'.$gArticle->user.'</div>
                                        <div class="col" style="font-size: 12px;
                                        color: #fff;
                                        text-align: right;
                                        margin-right: 20px; padding-bottom: 20px">'.$gArticle->createdate.'</div>
                                    </div>
                                </div>
                            </a>
                        </div>';
            }
        ?>
    </div>
</div>
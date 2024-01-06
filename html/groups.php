<?php
    $groups = R::findAll('groups');
?>
<title>Спільнота</title>
    
<div class="container">
    <?php include 'header.php'; ?>
    
    <div class="row">
        <div class="col col-md-2">
            <h1 class="blue">Спільнота</h1>
        </div>
        <div class="col offset-6" style="text-align: right">
            <a href="<?php HOST ?>?mode=groupscreate" class="btn btn-success">Створити спільноту</a>
        </div>
    </div>

    <div class="row">
        <?php
            foreach ($groups as $group) {
                echo '<div class="col-12 col-md-6 col-xl-4">
                        <a href="'.HOST.'?mode=groupsview&groupid='.($group->id).'">
                            <div class="article">
                                <div class="row">
                                    <div class="col-3 col-md-4">
                                        <div class="group-icon">
                                            <img src="'.HOST.'/img/group/'.$group->icon.'" alt="img" style="width: 100px; height: 100px">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="group-header">
                                            <h4 class="blue">'.$group->header.'</h4>
                                        </div>
                                        <div class="group-description">
                                            <p>'.$group->shortdesc.'</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>';
            }
        ?>
    </div>
</div>
</body>

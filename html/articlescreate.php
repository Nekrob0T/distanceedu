<?php
    if (isset($_POST['submit'])) {
        if (empty($_POST['header'])) {
            $errors[] = "Заговолок не може бути пустим";
        } else {
            if (strlen($_POST['header']) < 5) {
                $errors[] = "Заговолок закороткий";
            } else if (strlen($_POST['header']) > 100) {
                $errors[] = "Заговолок задовгий";
            }
        }
        if (empty($_POST['desc'])) {
            $errors[] = "Опис не може бути пустим";
            if (strlen($_POST['desc']) < 70) {
                $errors[] = "Опис закороткий";
            } else if (strlen($_POST['desc']) > 700) {
                $errors[] = "Опис задовгий";
            }
        }

        if (count($errors) > 0) {
            $printErr = true;
        } else {
            if (isset($_GET['groupid'])) {
                $article = R::dispense('groupsarticles');
                $article->groupid = $_GET['groupid'];

                $group = R::findOne('groups', 'id = ?', array($_GET['groupid']));
                $group->articlescount++;

                R::store($group);
            } else if (isset($_GET['teacherid'])) {
                $article = R::dispense('teachersarticles');
                $article->teacherid = $_GET['teacherid'];

                $teacher = R::findOne('users', 'id = ?', array($_GET['teacherid']));
                $teacher->articlescount++;

                R::store($teacher);
            } else {
                $article = R::dispense('articles');
            }

            $article->header = $_POST['header'];
            $article->shortdesc = substr($_POST['desc'], 0, 100)."...";
            $article->desc = $_POST['desc'];
            $article->createdate = date('d.m.Y');
            $article->viewscount = 0;
            $article->commentscount = 0;
            $article->user = $user->login;

            if (is_uploaded_file($_FILES['img']['tmp_name'])) {
                $tmp_name = $_FILES['img']['tmp_name'];
                $name = basename($_FILES['img']['name']);
                move_uploaded_file($tmp_name, "img/article/$name");
                $article->img = $name;
            }

            // if (is_uploaded_file($_FILES['video']['tmp_name'])) {
            //     $tmp_name = $_FILES['video']['tmp_name'];
            //     $name = basename($_FILES['video']['name']);
            //     move_uploaded_file($tmp_name, "img/video/$name");
            //     $article->video = $name;
            // }

            R::store($article);
            if (isset($_GET['groupid'])) {
                header("Location: ".HOST."?mode=groupsview&groupid=".$_GET['groupid']);
            } else if (isset($_GET['teacherid'])) {
                header("Location: ".HOST."?mode=profile");
            } else {
                header("Location: ".HOST."?mode=articles");
            }
        }
    }
?>

<title>Створити статтю</title>

<div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-2">
            <h1 class="blue">Створення статті</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <form class="form" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Заголовок</label>
                    <input class="form-control" type="text" name="header" value="<?php echo $_POST['header'] ?>"/>
                </div>
                <div class="form-group">
                    <label>Опис</label>
                    <textarea name="desc" class="form-control" rows="10" style="resize: none;"><?php echo $_POST['desc'] ?></textarea>
                <div>
                <div class="form-group">
                    <label>Фото</label>
                    <input class="form-control" type="button" value="Виберіть фото" onclick="document.getElementById('file').click();" />
                    <input type="file" style="display:none;" id="file" name="img"/>
                </div>
                <!-- <div class="form-group">
                    <label>Відео</label>
                    <input class="form-control" type="button" value="Виберіть відео" onclick="document.getElementById('file1').click();" />
                    <input type="file" style="display:none;" id="file1" name="video"/>
                </div> -->
                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-success">Створити статтю</button>
                </div>
            </form>

            <?php
                if ($printErr) {
                    echo '<p id="err">'.array_shift($errors).'</p>';
                }
            ?>
        </div>
    </div>
</div>
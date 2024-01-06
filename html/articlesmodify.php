<?php
    if (isset($_GET['groupid'])) {
        $article = R::findOne('groupsarticles', 'id = ? AND groupid = ?', array($_GET['articleid'], $_GET['groupid']));
    } else if (isset($_GET['teacherid'])) {
        $article = R::findOne('teachersarticles', 'id = ? AND teacherid = ?', array($_GET['articleid'], $_GET['teacherid']));
    } else {
        $article = R::findOne('articles', $_GET['articleid']);
    }

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
            $article->header = $_POST['header'];
            $article->shortdesc = substr($_POST['desc'], 0, 100)."...";
            $article->desc = $_POST['desc'];

            if (is_uploaded_file($_FILES['img']['tmp_name'])) {
                $tmp_name = $_FILES['img']['tmp_name'];
                $name = basename($_FILES['img']['name']);
                move_uploaded_file($tmp_name, "img/article/$name");
                $article->img = $name;
            }

            // if (is_uploaded_file($_FILES["video"]["tmp_name"])) {
            //     $tmp_name = $_FILES['video']['tmp_name'];
            //     $name = basename($_FILES['video']['name']);
            //     move_uploaded_file($tmp_name, "img/video/$name");
            //     $article->video = $name;
            // }

            R::store($article);

            if (isset($_GET['groupid'])) {
                header("Location: ".HOST."?mode=articlesview&groupid=".$_GET['groupid']."&articleid=".$_GET['articleid']);
            } else if (isset($_GET['teacherid'])) {
                header("Location: ".HOST."?mode=articlesview&teacherid=".$_GET['teacherid']."&articleid=".$_GET['articleid']);
            } else {
                header("Location: ".HOST."?mode=articlesview&articleid=".$_GET['articleid']);
            }
        }
    }
?>
<title>Редагувати статтю</title>

<div class="container">
    <h1 class="blue">Редагування статті</h1>
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <form class="form" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Заголовок</label>
                    <input class="form-control" type="text" name="header" value="<?php echo $article->header ?>"/>
                </div>
                <div class="form-group">
                    <label>Опис</label>
                    <textarea name="desc" class="form-control" rows="10" style="resize: none;"><?php echo $article->desc ?></textarea>
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
                    <button type="submit" name="submit" class="btn btn-success">Зберегти</button>
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
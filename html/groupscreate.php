<?php
if (isset($_POST['submit'])) {
    if (empty($_POST['header'])) {
        $errors[] = "Назва не може бути пустою";
    } else {
        if (strlen($_POST['header']) < 5) {
            $errors[] = "Назва закоротка";
        } else if (strlen($_POST['header']) > 40) {
            $errors[] = "Назва задовга";
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
        $group = R::dispense('groups');
        $group->header = $_POST['header'];
        $group->desc = $_POST['desc'];
        $group->shortdesc = substr($_POST['desc'], 0, 50)."...";
        $group->users_count = 0;
        $group->articles_count = 0;
        $group->creators = $user->login;

        if (is_uploaded_file($_FILES['icon']['tmp_name'])) {
            $tmp_name = $_FILES['icon']['tmp_name'];
            $name = basename($_FILES['icon']['name']);
            move_uploaded_file($tmp_name, "img/group/$name");
            $group->icon = $name;
        }

        R::store($group);
        header("Location: ".HOST."?mode=groups");
    }
}
?>

<title>Створити групу</title>

<div class="container">
    <div class="row">
        <div class="col col-md-4 offset-md-2">
            <h1 class="blue">Створення групи</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <form class="form" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Назва</label>
                    <input class="form-control" type="text" name="header"/>
                </div>
                <div class="form-group">
                    <label>Опис</label>
                    <textarea name="desc" class="form-control" rows="10" style="resize: none;"></textarea>
                <div>
                <div class="form-group">
                    <label>Іконка</label>
                    <input class="form-control" type="button" value="Аватар" onclick="document.getElementById('file').click();" />
                    <input type="file" style="display:none;" id="file" name="icon"/>
                </div>
                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-success">Створити групу</button>
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

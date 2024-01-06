<?php
    $messages = R::findAll('messages', 'idfrom = ? AND idto = ? ORDER BY createdate ASC, createtime ASC', array($_GET['idfrom'], $_GET['idto']));

    if (isset($_POST['submit'])) {
        if (!empty($_POST['message'])) {
            $message = R::dispense('messages');
            $message->idfrom = $_GET['idfrom'];
            $message->idto = $_GET['idto'];
            $message->text = $_POST['message'];
            $message->createdate = date('d.m.Y');
            $message->createtime = date('H:i');

            if ($user->teacher) {
                $message->teacher = 'yes';
            }

            R::store($message);
            header("Location: ".HOST."?mode=messagesview&idto=".$_GET['idto']."&idfrom=".$_GET['idfrom']);
        } else {
            $errors[] = "Повідомлення не може бути пустим";
            $printErr = true;
        }
    }
?>

<title>Перегляд повідомлення</title>

<div class="container">
    <?php include 'header.php' ?>

    <?php 
        if (!empty($messages)) {
            echo '<div class="article">';
            foreach($messages as $message) {
                if (isset($message->teacher)) {
                    $tempUser = R::findOne('users', 'id = ?', array($_GET['idto']));
                } else {
                    $tempUser = R::findOne('users', 'id = ?', array($_GET['idfrom']));
                }

                echo '<div class="row" style="margin-top: 15px">
                        <div class="col" style="color: #fff;">
                            <div class="row">
                                <div class="col-2 col-lg-1">
                                    <div class="user-icon">
                                        <img src="'.HOST.'/img/user/'.$tempUser->avatar.'" alt="img" style="width: 50px; height: 50px">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="message-text">
                                        <div class="row">
                                            <p>'.$message->text.'</p>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <p>'.$tempUser->login.'</p>
                                            </div>
                                            <div class="col" style="text-align: right;">
                                                <p>'.$message->createtime.' '.$message->createdate.'</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="line" style="border: 1px solid #fff; height: 2px"></div>';
            }
            echo '</div>';
        }  
    ?>

    <form method="post">
        <div class="row">
            <div class="col-8">
                <input type="search" name="message" class="form-control" placeholder="Повідомлення">
            </div>
            <div class="col">
                <button class="btn btn-success" name="submit">Написати</button>
            </div>
        </div>
    </form>

    <?php
		if($printErr) {
			echo '<p style="text-align: center; color: red; font-weight: bold;">'.array_shift($errors).'</p>';
		}
	?>
</div>
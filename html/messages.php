<?php
    if ($user->teacher) {
        $messages = R::findAll('messages', 'idto = ? ORDER BY idfrom, createdate DESC', array($user->id));
    } else {
        $messages = R::findAll('messages', 'idfrom = ? ORDER BY idfrom, createdate DESC', array($user->id));
    }
    $idToCheck = 0;
?>

<title>Повідомлення</title>

<div class="container">
    <?php include 'header.php'; ?>
    
    <div class="row">
        <div class="col col-md-2">
            <h1 class="blue">Повідомлення</h1>
        </div>
    </div>

    <div class="row">
        <?php
            if (!empty($messages)) {
                foreach($messages as $message) {
                    if (isset($message->teacher)) {
                        $tempUser2 = R::findOne('users', 'id = ?', array($message->idto));
                    } else {
                        $tempUser2 = R::findOne('users', 'id = ?', array($message->idfrom));
                    }

                    if ($user->teacher) {
                        $tempUser = R::findOne('users', 'id = ?', array($message->idfrom));
                    } else {
                        $tempUser = R::findOne('users', 'id = ?', array($message->idto));
                    }

                    if ($idToCheck != $message->idfrom) {
                        $idToCheck = $message->idfrom;

                        echo '<div class="col-12 col-md-6">
                                <a href="'.HOST.'?mode=messagesview&idto='.$message->idto.'&idfrom='.$message->idfrom.'">
                                    <div class="article" style="color: #fff">
                                        <div class="row">
                                            <div class="col-3">
                                                <img src="'.HOST.'/img/user/'.$tempUser->avatar.'" alt="img" style="width: 80px;
                                                    height: 80px;"/>
                                            </div>
                                            <div class="col">
                                                <h4 class="header blue">'.$tempUser->name.' '.$tempUser->pobat.'</h4>
                                                <p style="margin-top: 5px">'.$tempUser2->login.': '. substr($message->text,0,46) .'</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>';
                    }
                }
            }
        ?>
    </div>
</div>
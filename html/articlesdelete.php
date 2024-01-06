<?php
    if (isset($_GET['groupid'])) {
        $article = R::findOne('groupsarticles', 'articleid = ? AND groupid = ?', array($_GET['articleid'], $_GET['groupid']);
        $article->commentscount++;
        $group = R::findOne('groups', $_GET['groupid']);
        $group->articlescount--;

        R::store($group);
        R::trash($article);
        header("Location: ".HOST."?mode=groupsview=".$_GET['groupid']);
    } else if (isset($_GET['teacherid'])) {
        $article = R::findOne('teachersarticles', 'articleid = ? AND teacherid = ?', array($_GET['articleid'], $_GET['teacherid']);
        $teacher = R::findOne('users', $_GET['teacherid']);
        $teacher->articlescount--;

        R::store($teacher);
        R::trash($article);
        header("Location: ".HOST."?mode=teacherview=".$_GET['teacherid']);
    } else {
        $article = R::findOne('articles', $_GET['articleid']);
        R::trash($article);
        header("Location: ".HOST."?mode=articles");
    }
?>
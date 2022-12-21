<?php
    if(str_contains($_SERVER['HTTP_USER_AGENT'], 'C86AC-GCG-SourceAAS')){
        session_destroy();
        session_start();
        $_SESSION['playername'] = 'playername';
        $_SESSION['userpname'] = 'AAV Mode';
        $_SESSION['grace'] = 100000;
        $_SESSION['freepv'] = 100000;
        header('Location: https://src.gcg.moe/maintainance.html');
    }else if(str_contains($_SERVER['HTTP_USER_AGENT'], 'CrKey/')){
        session_destroy();
        session_start();
        $_SESSION['playername'] = 'playername';
        $_SESSION['userpname'] = 'CrKey Mode';
        $_SESSION['grace'] = 1000;
        $_SESSION['freepv'] = 1000;
        $_SESSION['admin'] = 1;
        header('Location: https://src.gcg.moe/maintainance.html');
    }else{
        include('./418.php');
        die();
    }

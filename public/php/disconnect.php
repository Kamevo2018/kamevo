<?php
    session_start();
    $_SESSION = array();
    session_destroy();
    sleep(1);
    header('Location: ../../connection?err=disconnected');
?>
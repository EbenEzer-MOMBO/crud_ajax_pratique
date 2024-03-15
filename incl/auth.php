<?php

//session_start();
if ($_SESSION['connecte']=false) {
    header("Location: login.php");
}
<?php

if(!session_status()) {
    session_start();
}

require "../vendor/autoload.php";
require '../app/start.php';
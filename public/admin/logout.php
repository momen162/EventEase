<?php
require __DIR__.'/_config.php';
session_destroy();
header('Location: /admin/login.php');

<?php
session_start();
include 'nav.php';
session_unset();
session_destroy();

header("Location: dashboard.php");
exit;
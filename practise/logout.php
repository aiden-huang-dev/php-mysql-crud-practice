<?php
require_once("auth.php"); // session_start()

require_login();

session_unset();
session_destroy();

header("Location: index.php");
exit;

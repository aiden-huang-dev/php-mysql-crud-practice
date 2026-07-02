<?php

session_start();

function is_login(): bool
{
	return isset($_SESSION["uid"]);
}

function require_login(): void
{
	if (!is_login()) {
		header("Location:login.php");
		exit;
	}
}

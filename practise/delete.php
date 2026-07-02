<?php
require_once("db.php");
require_once("auth.php");
require_login();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
	header("Location: index.php");
	exit;
}

$bid = (int)($_POST["bid"] ?? 0);

if ($bid > 0) {
	$sql = "DELETE FROM board WHERE bid = ?";
	$stmt = mysqli_prepare($link, $sql);
	mysqli_stmt_bind_param($stmt, "i", $bid);
	mysqli_stmt_execute($stmt);
}

header("Location: index.php");
exit;

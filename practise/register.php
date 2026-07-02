<?php

require_once("db.php");
require_once("auth.php");
require_once("helpers.php");

$username = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	$username = trim($_POST["username"] ?? "");
	$password = $_POST["password"] ?? "";

	if ($username === "" || $password === "") {
		$error = "請輸入帳密";
	} else {
		$password_hash = password_hash($password, PASSWORD_DEFAULT);

		$sql = "INSERT INTO board_users(username,password)VALUES(?,?)";
		$stmt = mysqli_prepare($link, $sql);
		mysqli_stmt_bind_param($stmt, "ss", $username, $password_hash);
		mysqli_stmt_execute($stmt);

		header("Location:login.php");
		exit;
	}
}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>註冊</title>
</head>

<body>
	<a href="index.php">回首頁</a> |
	<a href="login.php">登入</a>

	<hr>
	<h2>會員註冊</h2>

	<?php if ($error !== ""): ?>
		<p style="color:red;"><?= e($error) ?></p>
	<?php endif; ?>

	<form method="POST">
		帳號:<input name="username" autocomplete="username" value="<?= e($username) ?>"><br><br>
		密碼:<input name="password" autocomplete="new-password" type="password"><br><br>
		<button type="submit">註冊</button>
	</form>
</body>

</html>
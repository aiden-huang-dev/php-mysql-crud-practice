<?php

require_once("db.php");
require_once("auth.php");
require_once("helpers.php");

$username = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	$username = trim($_POST["username"] ?? "");
	$password = $_POST["password"] ?? "";

	$sql = "SELECT uid,username,password FROM board_users WHERE username=?";
	$stmt = mysqli_prepare($link, $sql);
	mysqli_stmt_bind_param($stmt, "s", $username);
	mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);
	$user = mysqli_fetch_assoc($result);

	if ($user && password_verify($password, $user["password"])) {
		session_regenerate_id(true);

		$_SESSION["uid"] = (int)$user["uid"];
		$_SESSION["username"] = $user["username"];

		header("Location:index.php");
		exit;
	}
	$error = "帳密錯誤";
}

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>登入</title>
</head>

<body>
	<a href=index.php>回首頁</a>
	<a href=register.php>註冊</a>

	<hr>
	<h2>會員登入</h2>

	<?php if ($error !== ""): ?>
		<p style="color:red;"><?= e($error) ?></p>
	<?php endif; ?>

	<form method="POST">
		帳號:<input name="username" autocomplete="username" value="<?= e($username) ?>"><br><br>
		密碼:<input name="password" autocomplete="current-password" type="password"><br><br>
		<button type="submit">登入</button>
	</form>
</body>

</html>
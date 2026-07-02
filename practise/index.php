<?php
require_once("db.php");
require_once("auth.php");
require_once("helpers.php");

$username = $_SESSION["username"] ?? "";
$isLogin = is_login();

$sql = "SELECT * FROM board ORDER BY bid ASC";
$result = mysqli_query($link, $sql);

if (!$result) {
	die("query err");
}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>留言板</title>
</head>

<body>
	<a href="index.php">重整</a> |

	<?php if ($isLogin): ?>
		<a href="add.php">新增</a> |
		<span>歡迎，<?= e($username) ?> |</span>
		<a href="logout.php" onclick="return confirm('確認登出?');">登出</a>
	<?php else: ?>
		<a href="register.php">註冊</a> |
		<a href="login.php">登入</a>
	<?php endif; ?>

	<hr>

	<table border="1" cellpadding="6">
		<tr>
			<th>bid</th>
			<th>name</th>
			<th>gender</th>
			<th>department</th>
			<th>interest</th>
			<th>subject</th>
			<th>content</th>
			<th>img</th>
			<?php if ($isLogin): ?><th>op</th><?php endif; ?>
		</tr>
		<?php while ($row = mysqli_fetch_assoc($result)): ?>
			<tr>
				<td><?= (int)$row["bid"] ?></td>
				<td><?= e($row["name"]) ?></td>
				<td><?= e($row["gender"]) ?></td>
				<td><?= e($row["department"]) ?></td>
				<td><?= e($row["interest"]) ?></td>
				<td><?= e($row["subject"]) ?></td>
				<td><?= e($row["content"]) ?></td>
				<td>
					<?php if (!empty($row["img_path"])): ?>
						<img src="<?= e($row["img_path"]) ?>" width="100">
					<?php endif; ?>
				</td>
				<?php if ($isLogin): ?>
					<td>
						<a href="edit.php?bid=<?= (int)$row["bid"] ?>">修改</a>
						<form method="POST" action="delete.php" style="display: inline;" onsubmit="return confirm('確認刪除?');">
							<input type="hidden" name="bid" value="<?= (int)$row["bid"] ?>">
							<button type="submit">刪除</button>
						</form>
					</td>
				<?php endif; ?>
			</tr>
		<?php endwhile; ?>
	</table>
</body>

</html>
<?php
require_once("db.php");
require_once("auth.php");
require_once("helpers.php");
require_login();

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	$name = trim($_POST["name"] ?? "");
	$gender = $_POST["gender"] ?? "";
	$department = $_POST["department"] ?? "";
	$subject = trim($_POST["subject"] ?? "");
	$content = trim($_POST["content"] ?? "");

	$interestArr = $_POST["interest"] ?? [];
	$interestArr = is_array($interestArr) ? $interestArr : [];
	$interestStr = implode(",", $interestArr);

	if ($name === "" || $subject === "" || $content === "") {
		$error = "name,subject,content不可為空";
	} else {
		$imgPath = upload_image("file") ?? "";

		$sql = "INSERT INTO board(name,gender,department,subject,content,interest,img_path)VALUES(?,?,?,?,?,?,?)";
		$stmt = mysqli_prepare($link, $sql);
		mysqli_stmt_bind_param(
			$stmt,
			"sssssss",
			$name,
			$gender,
			$department,
			$subject,
			$content,
			$interestStr,
			$imgPath
		);
		mysqli_stmt_execute($stmt);

		header("Location:index.php");
		exit;
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>新增</title>
	<style>
		.outer {
			border: 1px solid black;
			border-collapse: collapse;
		}

		.outer td,
		.outer th {
			border: none;
		}
	</style>
</head>

<body>
	<a href="index.php">回首頁</a>
	<hr>

	<?php if ($error !== ""): ?>
		<p style="color:red;"><?= e($error) ?></p>
	<?php endif; ?>

	<form method="POST" enctype="multipart/form-data">
		<div style="display:flex;gap:10px;">
			<table class="outer">
				<tr>
					<td>name:</td>
					<td><input name="name" value="<?= e($name ?? "") ?>"></td>
				</tr>
				<tr>
					<td>gender:</td>
					<td>
						<label><input type="radio" name="gender" value="M" <?= (($gender ?? "") === "M") ? "checked" : "" ?>>男</label>
						<label><input type="radio" name="gender" value="F" <?= (($gender ?? "") === "F") ? "checked" : "" ?>>女</label>
						<label><input type="radio" name="gender" value="O" <?= (($gender ?? "") === "O") ? "checked" : "" ?>>其他</label>
					</td>
				</tr>
				<tr>
					<td>department:</td>
					<td>
						<select name="department">
							<option value="">請選擇科系</option>
							<option value="IM" <?= (($department ?? "") === "IM") ? "selected" : "" ?>>資訊管理學系</option>
							<option value="CS" <?= (($department ?? "") === "CS") ? "selected" : "" ?>>資訊工程學系</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>interest:</td>
					<td>
						<?php
						$checked = $interestArr ?? [];
						?>
						<label><input type="checkbox" name="interest[]" value="read" <?= in_array("read", $checked, true) ? "checked" : "" ?>>看書</label>
						<label><input type="checkbox" name="interest[]" value="sleep" <?= in_array("sleep", $checked, true) ? "checked" : "" ?>>睡覺</label>
					</td>
				</tr>
				<tr>
					<td>subject:</td>
					<td><input name="subject" value="<?= e($subject ?? "") ?>"></td>
				</tr>
				<tr>
					<td valign="TOP">content:</td>
					<td><textarea rows="5" cols="20" name="content"><?= e($content ?? "") ?></textarea></td>
				</tr>
				<tr>
					<td></td>
					<td>
						<button type="submit">確認新增</button>
						<button type="reset">重置</button>
					</td>
				</tr>
			</table>

			<table class="outer">
				<tr>
					<td>上傳圖片</td>
				</tr>
				<tr>
					<td>
						<img id="preview" width="200" alt=""><br><br>
						<input type="file" name="file" accept="image/*" onchange="previewImage(event)">
						<script>
							function previewImage(event) {
								const f = event.target.files[0];
								if (!f) return;
								const reader = new FileReader();
								reader.onload = function() {
									document.getElementById("preview").src = reader.result;
								};
								reader.readAsDataURL(f);
							}
						</script>
					</td>
				</tr>
			</table>
		</div>
	</form>
</body>

</html>
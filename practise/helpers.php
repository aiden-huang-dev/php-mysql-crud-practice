<?php

function e($s): string
{
	return htmlspecialchars((string)$s, ENT_QUOTES, "UTF-8");
}

function upload_image(string $fieldName = "file", int $maxBytes = 2097152): ?string
{
	if (!isset($_FILES[$fieldName])) {
		return null;
	}

	$f = $_FILES[$fieldName];

	if ($f["error"] === UPLOAD_ERR_NO_FILE) {
		return null;
	}

	if ($f["error"] !== UPLOAD_ERR_OK) {
		if ($f["error"] === UPLOAD_ERR_INI_SIZE) {
			die("檔案太大（超過系統限制）");
		}

		die("上傳失敗:" . $f["error"]);
	}

	if (($f["size"] ?? 0) > $maxBytes) {
		die("檔案大小限制2MB");
	}

	$ext = strtolower(pathinfo($f["name"] ?? "", PATHINFO_EXTENSION));
	$allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
	if (!in_array($ext, $allowed, true)) {
		die("只允許上傳圖片jpg,jpeg,png,gif,webp");
	}

	$uploadDir = __DIR__ . "/uploads/";
	if (!is_dir($uploadDir)) {
		mkdir($uploadDir, 0755, true);
	}

	$newName = uniqid("img_", true) . '.' . $ext;
	$targetFsPath = $uploadDir . $newName;
	$imgPath = "uploads/" . $newName;

	if (!move_uploaded_file($f["tmp_name"], $targetFsPath)) {
		die("move err");
	}
	return $imgPath;
}

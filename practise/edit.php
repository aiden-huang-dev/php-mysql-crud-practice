<?php
require_once("db.php");
require_once("auth.php");
require_once("helpers.php");
require_login();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $bid = (int)$_POST["bid"] ?? 0;
    if ($bid <= 0) {
        die("bid err");
    }

    $name = trim($_POST["name"] ?? "");
    $gender = $_POST["gender"] ?? "";
    $department = $_POST["department"] ?? "";
    $subject = trim($_POST["subject"] ?? "");
    $content = trim($_POST["content"] ?? "");

    $interestArr = $_POST["interest"] ?? [];
    $interestArr = is_array($interestArr) ? $interestArr : [];
    $interestStr = implode(",", $interestArr);

    $imgPath = $_POST["img_path"] ?? "";

    $newImgPath = upload_image("file");

    if ($newImgPath !== null) {
        $imgPath = $newImgPath;
    }

    $sql = "  UPDATE board
            SET name=?,gender=?,department=?,subject=?,content=?,interest=?,img_path=? 
            WHERE bid=?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param(
        $stmt,
        "sssssssi",
        $name,
        $gender,
        $department,
        $subject,
        $content,
        $interestStr,
        $imgPath,
        $bid
    );
    mysqli_stmt_execute($stmt);

    header("Location:index.php");
    exit;
}

$bid = (int)$_GET["bid"] ?? 0;
if ($bid <= 0) {
    die("bid err");
}

$sql = "SELECT *FROM board WHERE bid=?";
$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($stmt, "i", $bid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    die("找不到資料");
}

$interestArr = !empty($row["interest"]) ? explode(",", $row["interest"]) : [];
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>修改</title>
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

    <form method="POST" enctype="multipart/form-data">
        <div style="display:flex;gap:10px;">

            <input type="hidden" name="bid" value="<?= (int)$row["bid"] ?>">

            <table class="outer">
                <tr>
                    <td>name:</td>
                    <td><input name="name" value="<?= e($row["name"]) ?>"></td>
                </tr>
                <tr>
                    <td>gender:</td>
                    <td>
                        <label><input type="radio" name="gender" value="M" <?= (($row["gender"]) === "M") ? "checked" : "" ?>>男</label>
                        <label><input type="radio" name="gender" value="F" <?= (($row["gender"]) === "F") ? "checked" : "" ?>>女</label>
                        <label><input type="radio" name="gender" value="O" <?= (($row["gender"]) === "O") ? "checked" : "" ?>>其他</label>
                    </td>
                </tr>
                <tr>
                    <td>department</td>
                    <td>
                        <select name="department">
                            <option value="">請選擇科系</option>
                            <option value="IM" <?= (($row["department"]) === "IM") ? "selected" : "" ?>>資訊管理學系</option>
                            <option value="CS" <?= (($row["department"]) === "CS") ? "selected" : "" ?>>資訊工程學系</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>interest</td>
                    <td>
                        <label><input type="checkbox" name="interest[]" value="read" <?= in_array("read", $interestArr, true) ? "checked" : "" ?>>看書</label>
                        <label><input type="checkbox" name="interest[]" value="sleep" <?= in_array("sleep", $interestArr, true) ? "checked" : "" ?>>睡覺</label>
                    </td>
                </tr>
                <tr>
                    <td>subject</td>
                    <td><input name="subject" value="<?= e($row["subject"]) ?>"></td>
                </tr>
                <tr>
                    <td valign="TOP">content</td>
                    <td><textarea rows="5" cols="20" name="content"><?= e($row["content"]) ?></textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <button type="submit">確認修改</button>
                        <button type="reset">重置</button>
                    </td>
                </tr>
            </table>

            <table class="outer">
                <tr>
                    <td>修改圖片</td>
                </tr>
                <tr>
                    <td>
                        <img id="preview" width="200" alt="" src="<?= e($row["img_path"] ?? "") ?>"><br><br>
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
                        <input type="hidden" id="img_path" name="img_path" value="<?= e($row["img_path"] ?? "") ?>">
                    </td>
                </tr>
            </table>
        </div>
    </form>
</body>

</html>
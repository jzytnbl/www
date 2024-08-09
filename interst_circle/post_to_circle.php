<?php
session_start();

if (empty($_POST["content"])) {
    die("帖子内容不能为空！");
}

$content = $_POST["content"];
$image_path = ""; // 初始化图片路径

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    die("用户未登录或会话已过期！");
}

if (empty($_POST["circlename"])) {
    die("缺少必要的参数！");
}

$circlename = $_POST["circlename"];

// 处理图片上传
if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
    $upload_dir = 'uploads/'; // 设置上传目录
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true); // 创建目录
    }
    $image_path = $upload_dir . basename($_FILES['image']['name']);
    if (!move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
        die("图片上传失败！");
    }
}

$mysqli = new mysqli("localhost", "root", "root", "lo_db");
if ($mysqli->connect_errno) {
    die("数据库连接错误:" . $mysqli->connect_error);
}

$sql = "INSERT INTO tcircle (username, content, image_path, circlename) VALUES (?, ?, ?, ?)";
$stmt = $mysqli->prepare($sql);
if (!$stmt) {
    die("准备语句失败: " . $mysqli->error);
}
$stmt->bind_param("ssss", $username, $content, $image_path, $circlename);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    // 更新用户总分数
    updateUserScore($username, 5, $mysqli);
    echo "<script>window.alert('发布成功！');window.location.href = 'circle_page.php?circlename=" . urlencode($circlename) . "';</script>";
} else {
    echo "发布失败，请重试。错误信息: " . $stmt->error;
}

$stmt->close();
$mysqli->close();

function updateUserScore($username, $score, $mysqli) {
    $sql = "UPDATE tuser SET total_score = total_score + ? WHERE name = ?";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        die("准备语句失败: " . $mysqli->error);
    }
    $stmt->bind_param("is", $score, $username);
    $stmt->execute();
    $stmt->close();
}
?>
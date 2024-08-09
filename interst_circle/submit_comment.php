<?php
session_start();

if (empty($_POST["content"])) {
    die("评论内容不能为空！");
}

$content = $_POST["content"];

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    die("用户未登录或会话已过期！");
}

if (empty($_POST["circlename"]) || empty($_POST["post_id"])) {
    die("缺少必要的参数！");
}

$circlename = $_POST["circlename"];
$post_id = $_POST["post_id"];

$mysqli = new mysqli("localhost", "root", "root", "lo_db");
if ($mysqli->connect_errno) {
    die("数据库连接错误:" . $mysqli->connect_error);
}

$sql = "INSERT INTO comments (post_id, username, content, circlename) VALUES (?, ?, ?, ?)";
$stmt = $mysqli->prepare($sql);
if (!$stmt) {
    die("准备语句失败: " . $mysqli->error);
}
$stmt->bind_param("isss", $post_id, $username, $content, $circlename);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    // 更新用户总分数
    updateUserScore($username, 1, $mysqli);
    echo "<script>window.alert('评论成功！');window.location.href = 'circle_page.php?circlename=" . urlencode($circlename) . "';</script>";
} else {
    echo "评论失败，请重试。错误信息: " . $stmt->error;
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
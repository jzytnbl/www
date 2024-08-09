<?php
session_start();
$mysqli = new mysqli("localhost","root","root","lo_db");
if($mysqli->connect_errno){
    die("数据库连接错误:".$mysqli->connect_error);
}
$name = $_POST["name"];
$psd = $_POST["psd"];
if(isset($_POST["login"])){
    $sql = "SELECT password FROM tuser WHERE name='$name'";
    $res = $mysqli->query($sql)->fetch_assoc();
    if($res){
        if($_POST["psd"]==$res["password"]){
            $_SESSION['username'] = $name;
            echo "<script>window.location.href='兴趣圈.html?name=$name';</script>";
        }else{
            echo "<script>window.alert('密码输入有误！');history.go(-1);</script>";
        }
    }else{
        echo "<script>window.alert('用户不存在！');history.go(-1);</script>";
    }
}
?>
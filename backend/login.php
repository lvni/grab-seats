<?php 
require_once "common/bootstrap.php";

checkAuthCode();

//检查用户
if (!isset($_POST['account']) || !isset($_POST['password'])) {
    R(42, "请检查参数");
}

$dboHanlder = DBFactory::getReadDb();
$userDao = new UsersEntity();
$user = $userDao->getByAccount($_POST['account']);
if ($user->row == false) {
    //数据库中没有这个用户
    R(501, "用户不存在");
} 

//检查密码
$encryPwd = encodePassword($_POST['password']);
if ($user->row['password'] != passCrypt($encryPwd, $user->row['salt'])) {
   //密码错误
   R(502, "密码错误");
}

$_SESSION['user'] = $user->row;
R(0,"登录成功");
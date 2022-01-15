<?php
$install = true;
require_once('../includes/inc.php');
$config_ver=config('ver');
@header('Content-Type: text/html; charset=UTF-8');
if($config_ver==''){
	$file='sql/update1.sql';
	if(file_exists($file)==false)exit('网站缺少数据库文件/install/'.$file.'，请下载完整安装包');
	$sqls = file_get_contents($file);
	$version=1100;
}elseif($config_ver=='1100'){
	$file='sql/update2.sql';
	if(file_exists($file)==false)exit('网站缺少数据库文件/install/'.$file.'，请下载完整安装包');
	$sqls = file_get_contents($file);
	$version=1150;
}elseif($config_ver=='1150'){
	$file='sql/update3.sql';
	if(file_exists($file)==false)exit('网站缺少数据库文件/install/'.$file.'，请下载完整安装包');
	$sqls = file_get_contents($file);
	$version=1200;
}elseif($config_ver=='1200'){
	$file='sql/update4.sql';
	if(file_exists($file)==false)exit('网站缺少数据库文件/install/'.$file.'，请下载完整安装包');
	$sqls = file_get_contents($file);
	$version=1300;
}else{
	set_config('ver',$v);
	exit('你的网站已经升级到最新版本了');
}
$explode = explode(';', $sqls);
$num = count($explode);
foreach ($explode as $sql) {
    if ($sql = trim($sql)) {
        $DB->query($sql);
    }
}
set_config('ver',$version);
exit("<script language='javascript'>alert('网站数据库升级成功！');window.location.href='../';</script>");
?>
<?
// TODO фильтрация
$_GET['name']=str_replace('..','',$_GET['name']);
$_GET['name']=str_replace('/','',$_GET['name']);
$_GET['name']=str_replace('\\','',$_GET['name']);
$_GET['name']=str_replace('\'','',$_GET['name']);
$_GET['name']=str_replace('"','',$_GET['name']);
$_GET['name']=str_replace(';','',$_GET['name']);
$_GET['name']=str_replace('%','',$_GET['name']);
$_GET['name']=str_replace('&','',$_GET['name']);
unlink('../../data/files/'.$_GET['name']);
?>
<?
if (!defined('PKASASS') || PKASASS!=md5('PKASASS')) { echo 'WTF?'; exit(); }

	$_listS=listS();
	if (count($_listS)>0) {
		foreach(listS() as $k => $v) {
			echo '<a href="'.$_cfg['www'].'/admin/?act=editS&page='.$k.'">edit</a> | <a href="'.$_cfg['www'].'/admin/?act=delS&page='.$k.'">del</a> -> '. mb_substr($v, 0, 90).'...<br>';
		}
	}
	unset($_listS);
?>
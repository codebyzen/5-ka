<? include('./config.php'); ?>
<? define("PKASASS",md5('PKASASS')); ?>
<? include('./func.php'); ?>
<?
// unauth
if (isset($_GET['act']) && $_GET['act']=='out') { 
	unset($_SERVER['PHP_AUTH_USER']); 
	unset($_SERVER['PHP_AUTH_PW']);
	header('Location: '.$_cfg['www'].'/admin');
}
// Basic auth
if(!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_USER'] !== $_cfg["login"] || md5($_SERVER['PHP_AUTH_PW']) !== $_cfg["pass"])
{
	header('WWW-Authenticate: Basic realm="Control Panel"');
	header('HTTP/1.0 401 Unauthorized');
	echo "Sorry!";
	exit;
}
//echo "<pre>";print_r($_GET);echo "</pre>";
//echo "<pre>";print_r($_POST);echo "</pre>";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<HEAD>
	<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="shortcut icon" href="favicon.ico" >
	<TITLE>Administration</TITLE>
<link type="text/css" rel="stylesheet" href="<?=$_cfg['www'];?>/gear/style.css"> 
</HEAD>

<BODY>

<DIV id="main">
	<DIV class="head">
		<UL id="menu">
			<LI><A href="<?=$_cfg['www'];?>/admin/?act=addA">add article</A></LI>
			<LI><A href="<?=$_cfg['www'];?>/admin/?act=listA">articles</A></LI>
			<LI><A href="<?=$_cfg['www'];?>/admin/?act=addS">add static page</A></LI>
			<LI><A href="<?=$_cfg['www'];?>/admin/?act=listS">pages</A></LI>
			<LI><A href="<?=$_cfg['www'];?>/admin/?act=cfg">settings</A></LI>
			<LI><A href="<?=$_cfg['www'];?>/admin/?act=out">log out</A></LI>
		</UL>
		
	</DIV>
	<B class="u4"></B><B class="u3"></B><B class="u2"></B><B class="u1"></B>
	<div style="height:5px;"></div>
	<B class="b1"></B><B class="b2"></B><B class="b3"></B><B class="b4"></B>
	<DIV class="content">
<?

if (isset($_GET['act']) && $_GET['act']=='addA') { include('./interface/addA.php'); }
if (isset($_GET['act']) && $_GET['act']=='editA') { include('./interface/editA.php'); }
if (isset($_GET['act']) && $_GET['act']=='listA') { include('./interface/listA.php'); }
if (isset($_GET['act']) && $_GET['act']=='delA') { delA($_GET['article']); echo '<script> document.location.href="'.$_cfg['www'].'/admin/?act=listA";</script>'; }
if (isset($_GET['act']) && $_GET['act']=='addS') { include('./interface/addS.php'); }
if (isset($_GET['act']) && $_GET['act']=='editS') { include('./interface/editS.php'); }
if (isset($_GET['act']) && $_GET['act']=='listS') { include('./interface/listS.php'); }
if (isset($_GET['act']) && $_GET['act']=='delS') { delS($_GET['page']); }
if (isset($_GET['act']) && $_GET['act']=='cfg') { include('./interface/cfg.php'); }

?>
	</DIV>
	<B class="b4"></B><B class="b3"></B><B class="b2"></B><B class="b1"></B>
 
	<div style="height:5px;"></div>
	<B class="f1"></B><B class="f2"></B><B class="f3"></B><B class="f4"></B>
 	<P class="foot">
		<A href="<?=$_cfg['www'];?>">5-ka 0.0.1</A> 
	</P>
 	<B class="u4"></B><B class="u3"></B><B class="u2"></B><B class="u1"></B>
	<div style="height:5px;"></div>

</DIV>
</BODY>
</HTML>


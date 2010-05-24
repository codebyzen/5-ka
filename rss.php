<?php
// RSS модуль
Error_Reporting(E_ALL & ~E_NOTICE);

//header('Pragma: no-cache');
header('Content-type: application/xml');

define('INCLUDED', TRUE);
include ('./gear/config.php');

$_s['rss_title']		= $_cfg['title'];
$_s['rss_description']	= $_cfg['decsription'];
$_s['rss_language'] 	= 'ru';
$_s['rss_link']			= $_cfg['www'].'/rss.php';
$_s['rss_logo_file']	= '';
$_s['rss_logo_title']	= '';
$_s['rss_logo_link']	= '';
$_s['rss_ppp']			= 10;
$_s['short']			= 1;
$_s['convtoUTF']		= 0;

function pre($str)
{
		$str[0] = str_replace(array("\r", "\n"), array('',"\r"), $str[0]);
		return $str[0];
}

if(isset($_REQUEST['short'])) {
	$_s['short']=$_REQUEST['short'];
} else {
	$_s['short']=0;
}

?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom"> 
	<channel>
		<atom:link href="<?=$_s['rss_link'];?>" rel="self" type="application/rss+xml"/> 
		<title><?php echo $_s['rss_title']; ?></title>
		<link><?php echo $_s['rss_link']; ?></link>
		
		<description><?php echo $_s['rss_description']; ?></description>
	
		<language><?php echo $_s['rss_language']; ?></language>
<?
if (!empty($_s['rss_logo_file']) && !empty($_s['rss_logo_title']) && !empty($_s['rss_logo_link'])) {
?>
		<image>
			<url><?php echo $_s['rss_logo_file']; ?></url>
			<title><?php echo $_s['rss_logo_title']; ?></title>
			<link><?php echo $_s['rss_logo_link']; ?></link>
		</image>
<? 
} 

	$d = dir('data/articles');
	while (false !== ($entry = $d->read()))
			if (is_numeric($entry)) $posts[] = $entry;
	$d->close();

	if (empty($posts)) exit();
	rsort($posts);
	if (sizeof($posts) > $_s['rss_ppp']) $posts = array_slice($posts, 0, $_s['rss_ppp']);

	for ($i = 0; $i< sizeof($posts); $i++)
	{
		$_tmp = explode("\r\n",file_get_contents('./data/articles/'.$posts[$i]));
		$post['id'] = $posts[$i];
		$post['title'] = $_tmp[0];
		array_shift($_tmp);
		$post['text'] = implode("\r\n",$_tmp);
		$post_id = $post['id'];
		unset ($_tmp);

		$post['text'] = preg_replace_callback("#\<pre\>(.*)\<\/pre\>#is", "pre", $post['text']);
		$post['text'] = str_replace("\n", "<br>\n", $post['text']);
		$post['text'] = str_replace("\r", "\n", $post['text']);
		$post['text'] = eregi_replace("<cut", "<cut", $post['text']);
		$post['text'] = eregi_replace("<lj-cut", "<cut", $post['text']);
		$text = htmlspecialchars(stripslashes($post['text']), ENT_QUOTES);

		if($_s['short']==1) {
			if(preg_match("#(.*)<cut text=\"(.*)\">#sU", $post['text'], $cut) or preg_match("#(.*)<cut>#sU", $post['text'], $cut))
			{
				$origtxt=$post['text'];
				$post['text'] = str_replace("</cut>", "", $post['text']);
				if(isset($cut[2])) {
					$post['text'] = $cut[1].'<a href="'.$_cfg['www'].'/'.$post['id'].'">'.$cut[2].'</a>';
				} else {
					$post['text'] = $cut[1].'<a href="'.$_cfg['www'].'/'.$post['id'].'">'.$_l['more'].'</a>';
				}
			}
			$text = htmlspecialchars($post['text'], ENT_QUOTES);
		}

		if ($_s['short']==2) {
			$text = "";
		}

		$title = htmlspecialchars($post['title'], ENT_QUOTES);

		$date = date("D, d M Y H:i:s ", $post_id).'GMT';

		//$title=str_replace("&gt;"," /&gt;",$title);
		//$text=str_replace("&gt;"," /&gt;",$text);

		?>
		<item>
			<title><?php echo $title; ?></title>
			<link><?php echo $_cfg['www'].'/'.$post['id']; ?></link>
			<description><?php echo $text; ?></description>
			<pubDate><?php echo $date; ?></pubDate>
			<guid isPermaLink="true"><?php echo $_cfg['www'].'/'.$post['id']; ?></guid>
		</item>
<?php
	}
	?>
	</channel>
</rss>
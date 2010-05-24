<?
if (!defined('PKASASS') || PKASASS!=md5('PKASASS')) { echo 'WTF?'; exit(); }

/*   */
/* User functions */
/*   */

// выводим одну статью
function getArticle($url) {
	global $_cfg;
	if (!file_exists("./data/articles/".$url) || empty($url)) {
		ob_start();
		include('./tpls/'.$_cfg['theme'].'/404.php');
		$page404=ob_get_contents();
		ob_end_clean();
		return $page404;
	}	

	$_tmp=explode("\r\n",file_get_contents("./data/articles/".$url));
	$_article['title']=$_tmp[0];
	$_article['time']=date("Y/m/d H:i",$url);
	$_article['full']='';
	$_article['url_title']=$_article['title'];
	$_article['url']=$_cfg['www']."/".$url;
	
	array_shift($_tmp);
	$_article['text']=implode("\r\n",$_tmp);
	$_article['text']=stripslashes($_article['text']);
	$_article['text']=str_replace("\r\n","<br />",$_article['text']);
	
	ob_start();
	include('./tpls/'.$_cfg['theme'].'/article.php');
	$out=ob_get_contents();
	ob_end_clean();
	return $out;
}

// выводим статьи в соответствии с заданной страницей
function getArticles($page=0) {
	global $_cfg;
	$start=$page*$_cfg['articlesperpage'];
	$_articles=getArtFlow($start,$_cfg['articlesperpage']);
	ob_start();
	if (count($_articles)<=0) return;
	foreach ($_articles as $i => $value) {
		if (!file_exists("./data/articles/".$value) || empty($value)) {
			break 1;
		}
		$_tmp=explode("\r\n",file_get_contents("./data/articles/".$value));
		$_article['title']=$_tmp[0];
		$_article['time']=date("Y/m/d H:i",$value);
		$_article['full']='<A name="cmt" href="'.$_cfg['www'].'/'.$value.'">полностью...</A>';
		$_article['url_title']='<a href="'.$_cfg['www'].'/'.$value.'" class="articleHeader">'.$_tmp[0].'</a>';		
		$_article['url']=$_cfg['www']."/".$value;

		array_shift($_tmp);
		$_article['text']=implode("\r\n",$_tmp);
		$_article['text']=stripslashes($_article['text']);
		
		$_article['text']=explode('<!-- cut -->',$_article['text']);
		$_article['text']=$_article['text'][0];
		$_article['text']=str_replace("\r\n","<br />",$_article['text']);
		include('./tpls/'.$_cfg['theme'].'/article.php');
	}
	$out=ob_get_contents();
	ob_end_clean();
	return $out;
}

// ищем статьи из указанного промежутка
function getArtFlow($start=0,$num=10) {
	//echo $start."/".$num;
	$dh  = opendir("./data/articles");
	while (false !== ($filename = readdir($dh))) {
		if ($filename!='.' && $filename!='..') $files[] = $filename;
	}
	if (count($files)<=0) return;
	rsort($files);
	closedir($dh);
	
	for ($count=$start;$count<=intval($start+$num-1);$count++) {
		$out[]=$files[$count];
	}
	
	return $out;
}

// пагинация
function paginator($page=0) {
	global $_cfg,$_GET;

	if (isset($_GET['article'])) return;

	$dh  = opendir("./data/articles");
	$articles=0;
	while (false !== ($filename = readdir($dh))) {
		if ($filename!='.' && $filename!='..') $articles++;
	}
	closedir($dh);
	
	if ($page>0) {
		echo '<A href="'.$_cfg['www'].'/page/'.intval($_GET['page']-1).'"><<<</A>';
	}

	if ($page!=0) { echo '<a href="'.$_cfg['www'].'">0</a>'.' ... '; }
	if (intval(($page+1)*$_cfg['articlesperpage'])<$articles) {
		echo intval($page).' ... <a href="'.$_cfg['www'].'/page/'.intval($articles/$_cfg['articlesperpage']).'">'.intval($articles/$_cfg['articlesperpage']).'</a>';
	}
	if (intval(($page+1)*$_cfg['articlesperpage'])<=$articles) {
		echo '<A href="'.$_cfg['www'].'/page/'.intval($_GET['page']+1).'">>>></A>';
	}
}

// выводим меню статических страниц
function menu($pre='<LI>',$post='</LI>',$tabs="\t\t\t") {
	global $_cfg;
	$dh  = opendir("./data/pages");
	$pages=0;
	while (false !== ($filename = readdir($dh))) {
		if ($filename!='.' && $filename!='..') {
			$title=file_get_contents("./data/pages/".$filename);
			$title=explode("\r\n",$title);
			$title=$title[0];
			$out.=$tabs.$pre.'<A href="'.$_cfg['www'].'/'.$filename.'">'.$title.'</A>'."\r\n";
		}
	}
	closedir($dh);
	return $out;
}

// выводим содержание статической стриницы
function getStatic($name) {
	global $_cfg;
	if (!file_exists("./data/pages/".$name) || empty($name)) {
		ob_start();
		include('./tpls/'.$_cfg['theme'].'/404.php');
		$page404=ob_get_contents();
		ob_end_clean();
		return $page404;
	}	

	$_tmp=explode("\r\n",file_get_contents("./data/pages/".$name));
	$_article['title']=$_tmp[0];
	$_article['time']=date("Y/m/d H:i",filemtime("./data/pages/".$name));
	$_article['url_title']=$_article['title'];
	$_article['url']=$_cfg['www']."/".$name;
	
	array_shift($_tmp);
	$_article['text']=implode("\r\n",$_tmp);
	$_article['text']=stripslashes($_article['text']);
	$_article['text']=str_replace("\r\n","<br />",$_article['text']);
	
	ob_start();
	include('./tpls/'.$_cfg['theme'].'/article.php');
	$out=ob_get_contents();
	ob_end_clean();
	return $out;
}

/*   */
/* Admin functions */
/*  */

function addA($title,$text) {
	if (file_put_contents('../data/articles/'.time(),$title."\r\n".$text)) return true;
}

function delA($article) {
	if (unlink('../data/articles/'.$article)) return true;
}

function delS($page) {
	if (unlink('../data/pages/'.$page)) return true;
}

function listA() {
	$dh  = opendir("../data/articles");
	while (false !== ($filename = readdir($dh))) {
		if ($filename!='.' && $filename!='..') {
			$_tmp=explode("\r\n",file_get_contents("../data/articles/".$filename));
			$files[$filename] = $_tmp[0];
		}
	}
	if (count($files)<=0) return;
	krsort($files);
	closedir($dh);
	return $files;
}

function listS() {
	$dh  = opendir("../data/pages");
	while (false !== ($filename = readdir($dh))) {
		if ($filename!='.' && $filename!='..') {
			$_tmp=explode("\r\n",file_get_contents("../data/pages/".$filename));
			$files[$filename] = $_tmp[0];
		}
	}
	if (count($files)<=0) return;
	krsort($files);
	closedir($dh);
	return $files;
}

function translit($string) {
	$trans=mb_strtolower($string,'UTF-8');
	$trans=str_replace(' ','_',$trans);
	$trans=str_replace('.','_',$trans);
	$trans=str_replace(',','_',$trans);
	$trans=str_replace("'",'_',$trans);
	$trans=str_replace('"','_',$trans);
	$trans=str_replace('`','_',$trans);
	$trans=str_replace('<','_',$trans);
	$trans=str_replace('>','_',$trans);
	$trans=str_replace('!','_',$trans);
	$trans=str_replace('@','_',$trans);
	$trans=str_replace('#','_',$trans);
	$trans=str_replace('$','_',$trans);
	$trans=str_replace('%','_',$trans);
	$trans=str_replace('^','_',$trans);
	$trans=str_replace('&','_',$trans);
	$trans=str_replace('*','_',$trans);
	$trans=str_replace('(','_',$trans);
	$trans=str_replace(')','_',$trans);
	$trans=str_replace('+','_',$trans);
	$trans=str_replace('=','_',$trans);
	$trans=str_replace('-','_',$trans);
	$trans=str_replace('|','_',$trans);
	$trans=str_replace(':','_',$trans);
	$trans=str_replace('?','_',$trans);
	$trans=str_replace('}','_',$trans);
	$trans=str_replace('{','_',$trans);
	$trans=str_replace('й','y',$trans);
	$trans=str_replace('ф','f',$trans);
	$trans=str_replace('я','ya',$trans);
	$trans=str_replace('ц','ts',$trans);
	$trans=str_replace('ы','y',$trans);
	$trans=str_replace('ч','ch',$trans);
	$trans=str_replace('у','u',$trans);
	$trans=str_replace('в','v',$trans);
	$trans=str_replace('с','s',$trans);
	$trans=str_replace('к','k',$trans);
	$trans=str_replace('а','a',$trans);
	$trans=str_replace('м','m',$trans);
	$trans=str_replace('е','e',$trans);
	$trans=str_replace('п','p',$trans);
	$trans=str_replace('и','i',$trans);
	$trans=str_replace('н','n',$trans);
	$trans=str_replace('р','r',$trans);
	$trans=str_replace('т','t',$trans);
	$trans=str_replace('г','g',$trans);
	$trans=str_replace('о','o',$trans);
	$trans=str_replace('ь','',$trans);
	$trans=str_replace('ш','sh',$trans);
	$trans=str_replace('л','l',$trans);
	$trans=str_replace('б','b',$trans);
	$trans=str_replace('щ','sch',$trans);
	$trans=str_replace('д','d',$trans);
	$trans=str_replace('ю','yu',$trans);
	$trans=str_replace('з','z',$trans);
	$trans=str_replace('ж','j',$trans);
	$trans=str_replace('х','h',$trans);
	$trans=str_replace('э','e',$trans);
	$trans=str_replace('ъ','',$trans);
return $trans;
}

?>
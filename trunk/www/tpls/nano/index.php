<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<HEAD>
	<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="shortcut icon" href="favicon.ico" >
	<META name="Keywords" content="<?=$_cfg['keywords'];?>">
	<META name="Description" content="<?=$_cfg['description'];?>">
	<LINK rel="alternate" type="application/rss+xml" title="rss" href="http://feeds.feedburner.com/5ka">
	<TITLE><?=$_cfg['title'];?></TITLE>
	<STYLE type="text/css">
		<?=$_css;?>
	</STYLE>
</HEAD>

<BODY>



<DIV id="main">
	<DIV class="head">
		<UL id="menu">
			<?=menu('<LI>','</LI>',"\t\t\t");?>
		</UL>
		
		<H1><a href="<?=$_cfg['www'];?>" style="text-decoration:none;color:white;">5-ka</a></H1>
		<FORM method="post" action="">
			<INPUT type="hidden" name="act" value="se">
			<INPUT type="text" name="sw" value=" поиск " onclick="this.value=''">
		</FORM>
	</DIV>
	<B class="u4"></B><B class="u3"></B><B class="u2"></B><B class="u1"></B>
	<div style="height:5px;"></div>
	<B class="b1"></B><B class="b2"></B><B class="b3"></B><B class="b4"></B>
	<DIV class="content">
		<?=$_content;?>
	</DIV>
	<B class="b4"></B><B class="b3"></B><B class="b2"></B><B class="b1"></B>


	<DIV class="paging">
		<?=paginator($_GET['page']);?>
	</DIV>
 
	<div style="height:5px;"></div>
	<B class="f1"></B><B class="f2"></B><B class="f3"></B><B class="f4"></B>
 	<P class="foot">
		<A href="<?=$_cfg['www'];?>">5-ka 0.0.1</A> 
		<A class="rss" href="http://feeds.feedburner.com/p/5-ka">rss</A>
	</P>
 	<B class="u4"></B><B class="u3"></B><B class="u2"></B><B class="u1"></B>
	<div style="height:5px;"></div>
	<div style="text-align:center;">
	<!--LiveInternet counter--><script type="text/javascript">document.write("<a href='http://www.liveinternet.ru/click' target=_blank><img src='//counter.yadro.ru/hit?t25.2;r" + escape(document.referrer) + ((typeof(screen)=="undefined")?"":";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?screen.colorDepth:screen.pixelDepth)) + ";u" + escape(document.URL) +";i" + escape("Жж"+document.title.substring(0,80)) + ";" + Math.random() + "' border=0 width=88 height=15 alt='' title='LiveInternet: показано число посетителей за сегодня'><\/a>")</script><!--/LiveInternet-->
	</div>
	<div style="height:5px;"></div>

</DIV>
</BODY>
</HTML>
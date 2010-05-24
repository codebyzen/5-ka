		<DL class="post">
			<H2>§ <?=$_article['url_title'];?></H2>
			<DIV>
			<?=$_article['text'];?>
			</DIV>
			<DIV style="color:gray;font-size:0.85em;">
				<?=$_article['full'];?>
				<?=$_article['time'];?> by <?=$_cfg['author'];?>
			</DIV>
			
				<div id="disqus_thread"></div>
				<script type="text/javascript">
				  /**
					* var disqus_identifier; [Optional but recommended: Define a unique identifier (e.g. post id or slug) for this thread] 
					*/
				  (function() {
				   var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
				   dsq.src = 'http://5ka.disqus.com/embed.js';
				   (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
				  })();
				</script>
				<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript=5ka">comments powered by Disqus.</a></noscript>
				<a href="http://disqus.com" class="dsq-brlink">blog comments powered by <span class="logo-disqus">Disqus</span></a>
							
		</DL>

			<!-- jQueryプラグイン -->
			<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/common/jquery-1.9.1-min.js"></script>
			<!-- 自作プラグイン -->
			<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/common/common.js"></script>
			<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/common/retina_image.js"></script>
			<!-- html5プラグイン -->			
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
			<!-- コード表示プラグイン -->
			<script type="text/javascript" src="<?php echo HTTP; ?>assets/syntaxhighlighter/scripts/shCore.js"></script>
			<script type="text/javascript" src="<?php echo HTTP; ?>assets/syntaxhighlighter/scripts/shBrushXml.js"></script>
			<script type="text/javascript" src="<?php echo HTTP; ?>assets/syntaxhighlighter/scripts/shBrushCss.js"></script>
			<script type="text/javascript" src="<?php echo HTTP; ?>assets/syntaxhighlighter/scripts/shBrushJScript.js"></script>
			<script type="text/javascript" src="<?php echo HTTP; ?>assets/syntaxhighlighter/scripts/shBrushPhp.js"></script>
			<script type="text/javascript" src="<?php echo HTTP; ?>assets/syntaxhighlighter/scripts/shBrushSql.js"></script>
			<link type="text/css" rel="stylesheet" href="<?php echo HTTP; ?>assets/syntaxhighlighter/styles/shThemeDefault.css"/>
			<script type="text/javascript">SyntaxHighlighter.all();</script>
			<!-- FBページプラグイン -->
			<div id="fb-root"></div>
			<script>
				(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js       = d.createElement(s);
				  js.id    = id;
				  js.src   = "//connect.facebook.net/ja_JP/all.js#xfbml=1";
				  js.async = true;
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));
			</script>
			<!-- Twitterプラグイン -->
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			<!-- はてなプラグイン -->
			<script type="text/javascript" src="http://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script>
			<!-- Pocketプラグイン -->
			<script type="text/javascript">!function(d,i){if(!d.getElementById(i)){var j=d.createElement("script");j.id=i;j.src="https://widgets.getpocket.com/v1/j/btn.js?v=1";var w=d.getElementById(i);d.body.appendChild(j);}}(document,"pocket-btn-js");</script>
			<!-- グーグル+プラグイン -->
			<script type="text/javascript">
			  window.___gcfg = {lang: 'ja'};
			
			  (function() {
			    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			    po.src = 'https://apis.google.com/js/plusone.js';
			    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
			  })();
			</script>
			<?php 
			if($_SERVER["HTTP_HOST"] == "localhost") {
				
			}
				else if($_SERVER["HTTP_HOST"] == "programmer-box.net") {
					
				}
				else {?>
			<!-- アナリティクス -->
			<script type="text/javascript">
		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-37919803-1']);
		  _gaq.push(['_trackPageview']);
		
		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		</script>
		<?php 
				} ?>


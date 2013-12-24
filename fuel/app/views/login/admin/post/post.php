<!DOCTYPE html>
	<html xmlns="http://www.w3.org/1999/xhtml" lang="ja">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>ポスト | アドミン | ログイン | <?php echo TITLE; ?></title>
		<link rel="stylesheet" href="<?php echo Uri::base(); ?>assets/css/common/common_flat.css" type="text/css">
		<link rel="stylesheet" href="<?php echo Uri::base(); ?>assets/css/login/common.css" type="text/css">
		<link rel="stylesheet" href="<?php echo Uri::base(); ?>assets/css/writing/writing.css" type="text/css">
		<meta name='robots' content='noindex,nofollow' />
	</head>
	<body>
		<!--  -->
		<div class="admin">
			<!--  -->
			<div class="admin_left">
				<!--  -->
				<div class="admin_left_menu">
					<a href="">ダッシュボード</a>
				</div>
				<!--  -->
				<div class="admin_left_menu">
					<ol>
						<li>
							<dl>
								<dt>投稿</dt>
								<dd><a href="<?php echo HTTP; ?>/login/admin/post/">新規追加</a></dd>
								<dd><a href="">投稿一覧</a></dd>
								<dd><a href="">カテゴリー</a></dd>
							</dl>
						</li>
					</ol>
				</div>
				<!--  -->
				<div class="admin_left_menu">
					
				</div>
			</div>
			<!--  -->
			<div class="admin_right">
				<!--  -->
				<div class="admin_right_block_logout">
					<a href="<?php echo Uri::base(); ?>login/admin/logout/">ログアウト</a>
				</div>
				<div class="columns_2 clearfix">

					<?php
//				var_dump($_POST);
//				var_dump($_FILES);
?>

					<!-- new_post -->
					<div class="new_post">
						<div class="new_post_contents">
							<h1>新規投稿を追加</h1>
							<form action="" method="post" enctype="multipart/form-data">
								<p>タイトル</p>
								<input type="text" name="title">
								<p>記事パス</p>
								<?php echo HTTP;?><input type="text" name="path">
								<p>本文</p>
								<textarea name="press">
				<p>ああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああ</p>
				<nav class="detail_press_index clearfix">
					<h2 id="s_0p"><span class="color">目次</span></h2>
					<ul class="left no_width">
						<li class="n_0"><span class="scroll_btn"></span></li>
						<li class="n_1"><span class="scroll_btn"></span></li>
						<li class="n_9"><span class="scroll_btn">まとめ</span></li>
					</ul>
				</nav>
				<h2 class="heading"></h2>
				<p></p>
				
				<h2 class="heading"></h2>
				<p></p>					
				
				<h2 class="heading"></h2>
				<p></p>
								</textarea>
								<p>タグ</p>
								<input type="text" name="tag">
						</div>
					</div> <!-- new_post -->
					<!-- postboxs -->
					<div class="postboxs">
						<!-- postbox -->
						<div class="postbox">
							<h3>公開</h3>
							<div class="postbox_contents">
								<input type="submit" name="draft" value="下書きとして保存">
								<input type="submit" name="submit" value="投稿する">
							</div>
						</div> <!-- postbox -->
						<!-- postbox -->
						<div class="postbox">
							<h3>サムネイル</h3>
							<div class="postbox_contents">
								<input type="file" name="file">
							</div>
						</div> <!-- postbox -->
						<!-- postbox -->
						<div class="postbox">
							<h3>カテゴリー</h3>
							<div class="postbox_contents">
								<select name="category">
									<option value="">なし</option>
									<option value="webデザイン">webデザイン</option>
									<option value="HTML・CSS">HTML・CSS</option>
									<option value="プログラミング">プログラミング</option>
									<option value="SEO">SEO</option>
									<option value="JavaScript">JavaScript</option>
									<option value="webサービス">webサービス</option>
									<option value="ソフト・ツール">ソフト・ツール</option>
									<option value="つくってみた">つくってみた</option>
									<option value="Macアプリ">Macアプリ</option>
									<option value="便利">便利</option>
									<option value="サーバ">サーバ</option>
								</select>
							</div>
						</div> <!-- postbox -->
							</form>
					</div> <!-- postboxs -->
				</div>
			</div>
		</div>
	</body>
</html>
<!DOCTYPE html>
	<html xmlns="http://www.w3.org/1999/xhtml" lang="ja">
	<head>
		<meta charset="UTF-8">
		<meta name='robots' content='noindex,nofollow'>
		<title>アドミン | ログイン | <?php echo TITLE; ?></title>
		<link rel="stylesheet" href="<?php echo Uri::base(); ?>assets/css/common/common_flat.css" type="text/css">
		<link rel="stylesheet" href="<?php echo Uri::base(); ?>assets/css/login/common.css" type="text/css">
	</head>
	<body>
		<!--  -->
		<div class="admin">
			<div class="admin_left">
				<div class="admin_left_menu">
					<a href="<?php echo Uri::base(); ?>login/admin/">ダッシュボード</a>
				</div>
				<div class="admin_left_menu">
					<ol>
						<li>
							<dl>
								<dt>投稿</dt>
								<dd><a href="<?php echo Uri::base(); ?>login/admin/post/">新規追加</a></dd>
								<dd><a href="<?php echo Uri::base(); ?>login/admin/list/">投稿一覧</a></dd>
								<dd><a href="<?php echo Uri::base(); ?>login/admin/category/">カテゴリー</a></dd>
							</dl>
						</li>
					</ol>
				</div>
				<div class="admin_left_menu">
					
				</div>
			</div>
			<div class="admin_right">
				<div class="admin_right_block_logout">
					<a href="<?php echo Uri::base(); ?>login/admin/logout/">ログアウト</a>
				</div>
				<div class="admin_right_block">
					ブロック
				</div>
			</div>
		</div>
	</body>
</html>
<!DOCTYPE html>
	<html xmlns="http://www.w3.org/1999/xhtml" lang="ja">
	<head>
		<meta charset="UTF-8">
		<meta name='robots' content='noindex,nofollow'>
		<title>ログイン | <?php echo TITLE; ?></title>
		<link rel="stylesheet" href="<?php echo Uri::base(); ?>assets/css/common/common_flat.css" type="text/css">
		<link rel="stylesheet" href="<?php echo Uri::base(); ?>assets/css/login/common.css" type="text/css">
	</head>
	<body>
		<!--  -->
		<div class="login">
			<h1><a href="<?php echo Uri::base(); ?>" title="Powered by Programmerbox"><img width="200" height="76" alt="プログラマーボックス" src="<?php echo Uri::base(); ?>assets/img/logo/programmerbox_logo19.png"></a></h1>
			<!-- login_form -->
			<form class="login_form" name="login_form" action="" method="post">
				<!-- block -->
				<div class="block">
					<p>
						<label for="user_login">ユーザー名
					</p>
							<input type="text" class="input" id="user_login" name="login_user" value="" size="20">
						</label>
				</div>
				<!-- block -->
				<div class="block">
					<p>
						<label for="user_pass">パスワード
					</p>
							<input type="password" class="input" id="user_pass" name="login_pass" value="" size="20">
						</label>
				</div>
				<!-- submit -->
				<p class="submit clearfix">
					<input type="submit" class="login_button" name="login_submit" value="ログイン">
				</p>
			</form>
			<!--  -->
			<!--
			<p><a href="<?php echo Uri::base(); ?>" title="">&larr; Programmerbox へ戻る</a></p>
			-->
			<?php echo $content_data["login_message"]; ?>
		</div>
	</body>
</html>
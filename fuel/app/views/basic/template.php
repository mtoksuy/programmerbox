<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $view_data["title"]; ?></title>
		<!-- meta -->
		<?php echo $view_data["meta"]; ?>
		<link rel="shortcut icon" href="<?php echo Uri::base(); ?>assets/img/icon/favicon_1.ico" type="image/vnd.microsoft.icon">
		<link rel="icon" href="<?php echo Uri::base(); ?>assets/img/icon/favicon_1.ico" type="image/vnd.microsoft.icon">
		<link rel="alternate" type="application/rss+xml" title="ProgrammerBOX RSSフィード" href="<?php echo Uri::base(); ?>feed.xml">
		<link rel="stylesheet" href="<?php echo Uri::base(); ?>assets/css/common/common_flat.css" type="text/css">
		<?php echo $view_data["external_css"]; ?>
	</head>
	<body>
		<!-- header -->
		<?php echo $view_data["header"]; ?>
		<div id="wrapper">
			<!-- main -->
			<div class="main">
				<!-- main_left -->
				<div class="main_left">
					<?php echo $view_data["content"]; ?>
					<?php echo $view_data["paging"]; ?>
				</div>
				<!-- main_rigth -->
				<div class="main_right">
					<?php echo $view_data["side_bar"]; ?>
				</div>
			</div>
			<!-- footer -->
			<?php echo $view_data["footer"]; ?>
			<?php echo $view_data["script"]; ?>
		</div>
	</body>
</html>

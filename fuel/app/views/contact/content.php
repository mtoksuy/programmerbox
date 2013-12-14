<?php 
//--------
//変数生成
//--------
$post = array();



//var_dump($_POST);
// post変数生成
foreach($_POST as $key => $value) {
	$post[$key] = $value;
}
//var_dump($post);

//------------------------------
//フォームの内容をメール通知する
//------------------------------
if($post != NULL) {
	$message = ("CONTACTからフォーム送信されました。
	お名前:{$post['name']}
	メールアドレス:{$post['email']}
	web:{$post['web']}
	---------------------------------
	メッセージ:{$post['text_area']}");

	$post_array = array(
		'from'    => 'mtoksuy@programmerbox.com',
		'to'      => 'mtoksuy@programmerbox.com',
		'subject' => 'ProgrammerBOXのフォーム通知',
		'message' => $message,
		'param'   => array(
			'host'     => 'localhost',
			'port'     => 25,
			'from'     => 'mtoksuy@programmerbox.com', 
			'protocol' => 'SMTP',
			'user'     => '',
			'pass'     => '',),
	);
//var_dump($post_array);

// メール送信
Model_Mail_Basis::qbmail_post($post_array);
?>
			<p>フォームメッセージ受付けました。</p>
			<p>内容を確認致します。</p>
<?php 
}
	else {
?>

			<div class="contact_form">
				<div class="contact_form_p">
					<p>こんにちは!ProgrammerBOX中の人、マツオカソウヤです。</p>
					<p>ブログを見てわからなかった事、個人的なコメント</p>
					<p>お仕事の相談、広告出稿等を受け付けていますので</p>
					<p>気軽にメッセージ下さい。</p>
				</div>
				<form class="contact_form" action="" method="post">
					<label for="name">名前<span class="red">*</span></label>
					<input type="text" id="name" name="name"  required="required" value="" placeholder="お名前を記入して下さい。">
					<label for="email">メールアドレス<span class="red">*</span></label>
					<input type="email" id="email" name="email" value="" placeholder="メールアドレスを記入して下さい。">
					<label for="web">webサイト or Twitter or facebook</label>
					<input type="text" id="web" name="web" value=""  placeholder="URL or IDを記入して下さい。">
					<label for="text_area">メッセージ</label>
					<textarea id="text_area" name="text_area" placeholder="メッセージを記入して下さい。"></textarea>
					<input type="submit" name="submit" value="送信">
				</form>
			</div>
<?php 
}
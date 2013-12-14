<?php 
class Model_Mail_Basis extends Model {
	//------------------
	//qbmailでメール送信
	//------------------
	public static function qbmail_post($post_array) {
			// エラー表示設定(qbmail仕様上エラー非表示にする)
			error_reporting(0);
			ini_set('display_errors', 1);

			// qdmail呼び出し
			require_once PATH."assets/qdmail/qdmail.php";
			require_once PATH."assets/qdmail/qdsmtp.php";

//			$mail = & new Qdmail(); ??
			$mail = new Qdmail();

//			var_dump($mail);
			$mail->smtp(true);

			// param設定
			$mail -> smtpServer($post_array["param"]);
			// 送信先
			$mail ->to($post_array["to"]);
			// 題名
			$mail ->subject($post_array["subject"]);
			// 送信元情報
			$mail ->from($post_array["from"]);
			// 本文挿入
			$mail ->text($post_array["message"]);
			// 送信
			$return_flag = $mail ->send();
	}
		//--------------------------------------------------------------------------
		//コンタクトformメール送信(PEARを利用した関数。一応サンプルとして残しておく)
		//--------------------------------------------------------------------------
		function contact_post($post) {
			$mail = 'info@programmerbox.com';
			// mb_encode_mimeheader用エンコードの設定
			mb_language("japanese");
			mb_internal_encoding("UTF-8");
			require_once 'Mail.php';
			require_once 'Mail/mime.php';
			// ① Mail_Mimeクラスのインスタンス化
			$mime = new Mail_Mime("\n");
			// ② テキスト本文の設定
			$mime->setTxtBody("CONTACTからフォーム送信されました。
お名前:{$post['name']}
メールアドレス:{$post['email']}
web:{$post['web']}
---------------------------------
メッセージ:{$post['text_area']}");
			// ③ 添付ファイルの指定
//			$mime->addAttachment("nagoya.jpg", "image/jpg");

			// ④ メッセージの設定
			$bodyParam = array(
			"head_charset"  => "ISO-2022-JP",
			"text_encoding" => "ISO-2022-JP",
			"text_charset"  => "UTF-8"
			);
			// ⑤ メッセージを構築する
			$body = $mime->get($bodyParam);

			$addHeaders = array(
			'From'    => 'info@programmerbox.com',                            //送信元
			'To'      =>  'info@programmerbox.com',                           //送信宛
			'Subject' =>  mb_encode_mimeheader("Programmerboxのフォーム通知") //タイトル
			);
			// ⑥ ヘッダ行を構築する
			$headers = $mime->headers($addHeaders);

			// 送信元smtp設定
			$params = array(
			'host'     => 'smtp.souya-matsuoka.net',
			'port'     => 587,
			'auth'     => true,
			'username' => 'info@programmerbox.com',
			'password' => 'matu1012'
			);
			$recipients =  $mail;
			$smtp = Mail::factory( 'smtp', $params);
//			var_dump($smtp);
			$e = $smtp->send( $recipients, $headers, $body);
			if ( PEAR::isError($e) )
			{
				print( $e->getMessage() );
			}
				else
				{
//					print( "<h2>詳細を{$recipients}様宛にメールを送りました。</h2>" );
				}
				return $event_date;
		} // function contact_post($post)
}
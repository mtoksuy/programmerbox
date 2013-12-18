<?php 
class Model_Login_Basis extends Model {
	//--------
	//ログイン
	//--------
	public static function login($post) {
		$query = DB::query("
			SELECT *
			FROM user
			WHERE	programmerbox_id = '".$post["login_user"]."'
			AND   password         = '".md5($post["login_pass"])."'")->execute();
		foreach($query as $key => $value) {
			$_SESSION["programmerbox_id"] = $value["programmerbox_id"];
			header('Location: '.HTTP.'login/admin/');
			exit;
		}
		// ログイン出来ない場合
		$lohin_message = 'ユーザー名かパスワードが間違っています。';
		return $lohin_message;
	}
	//----------------
	//ログインチェック
	//----------------
	public static function login_check() {
			// エラー表示設定()
			error_reporting(0);
			ini_set('display_errors', 1);

		$login_check = '';
		if($_SESSION["programmerbox_id"]) {
//			var_dump($_SESSION);
			$login_check = true;
		}
			else {
				$login_check = false;
			}
		return $login_check;
	}
	//----------
	//ログアウト
	//----------
	public static function logout() {
		$_SESSION = array();
		session_destroy();
		header('location: '.HTTP.'');
		exit;
	}
}
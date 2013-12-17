<?php 
/**
 * ログインを操作するコントローラー
 * 
 * Viewのbasic群をforgeしてテンプレートに流し込み値を返す。
 * 
 * 
 */

class Controller_Login extends Controller_Login_Template {
	public function action_index() {
		// ログインチェック
		$login_check = Model_Login_Basis::login_check();
		if($login_check) {
			header('location: '.HTTP.'login/admin/');
			exit;
		}
			else {
				// ポスト取得
				$post = Library_Security::post_security();
				$lohin_message = '';
				// ログイン
				if($post == true) {
					$lohin_message = Model_Login_Basis::login($post);
				}
				// ビュー
				$admin_html = View::forge('login/login');
				$admin_html->set('content_data',array(
					'login_message' => $lohin_message,
				), false);
				return $admin_html;
		}
	}
}
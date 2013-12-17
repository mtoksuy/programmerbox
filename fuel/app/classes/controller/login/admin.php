<?php 
/**
 * Programmerbox管理画面を操作するコントローラー
 * 
 * 
 * 
 * 
 */

class Controller_Login_Admin extends Controller_Login_template {
	public function action_index() {
		// ログインチェック
		$login_check = Model_Login_Basis::login_check();
		if($login_check) {
			$admin_login_html = View::forge('login/admin/admin');
			return $admin_login_html;
		}
			else {
				header('Location: '.HTTP.'');
				exit;
			}
	}
}
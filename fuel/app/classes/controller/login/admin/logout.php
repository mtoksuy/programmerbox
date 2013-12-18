<?php 
/**
 * Programmerbox管理画面を操作するコントローラー
 * 
 * 
 * 
 * 
 */

class Controller_Login_Admin_Logout extends Controller_Login_template {
	public function action_index() {
		Model_Login_Basis::logout();
	}
}
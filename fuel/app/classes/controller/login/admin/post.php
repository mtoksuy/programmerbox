<?php 
/**
 * ページングを操作するコントローラー
 * 
 * Viewのbasic群をforgeしてテンプレートに流し込み値を返す。
 * 
 * 
 */

class Controller_Login_Admin_Post extends Controller_Login_Template {
	public function action_index() {
		// ログインチェック
		$login_check = Model_Login_Basis::login_check();
		if($login_check) {
			// ポスト取得
			$post = Library_Security::post_security();
			// 投稿
			if($post == true) {
				// 記事作成
				Model_Login_Post_Basis::article_create($post);
			}
			$admin_login_post_html = View::forge('login/admin/post/post');
			return $admin_login_post_html;
		}
			else {
				header('Location: '.HTTP.'');
				exit;
			}
	}
}
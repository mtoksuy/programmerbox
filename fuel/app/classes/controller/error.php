<?php 
/**
 * コントローラーベーシックテンプレート
 * 
 * Viewのbasic群をforgeしてテンプレートに流し込み値を返す。
 * 
 * 
 */
class Controller_Error extends Controller {
	public function action_404() {
	$error_html = View::forge('error/404');
	return $error_html;
	}
}
<?php 
/**
 * ページングを操作するコントローラー
 * 
 * Viewのbasic群をforgeしてテンプレートに流し込み値を返す。
 * 
 * 
 */

class Controller_Login_Admin_Post extends Controller {
	public function action_index() {
		session_start();
	}
}
<?php 
class Controller_Status extends Controller_Layout_Template {
	public function before() {
		parent::before();
	}
	public function action_index() {
		$results = Model_Status::find_body_by_username('foo');
		var_dump($results);
//		var_dump($GLOBALS);
//		Debug::dump($GLOBALS);
//		Debug::dump($HOME);
//		Debug::dump(HOME);
/*
		$data = array('user' => 'てすと', 
									'data' => 'データ',);
*/
		// ビューファイル全体に$title をセットする
		$this->layout_template->set_global('title', 'レイアウト機能のサンプル');
		// テンプレートレイアウトを渡す
		$this->layout_template->content = View::forge('layout/content');
		$this->layout_template->content->data = 'de-ta';
		return ;
	}
	public function action_blog($cat = 'php', $page = '1') {
		// ビューファイル全体に$title をセットする
		$this->layout_template->set_global('title', 'レイアウssssssssssト機能のサンプル');
		// テンプレートレイアウトを渡す
		$this->layout_template->content = View::forge('layout/content');

	}
}
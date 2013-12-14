<?php 
class Controller_Test extends Controller {
/*
	public function before() {
		// 必ず親クラスの before() メソッドを実行する
		parent::before();
		$this->current_user = 'Sawako';
	}
*/
	public function action_index() {
		 $test = View::forge('test');
		 var_dump($test);
		 Debug::dump($test);
		return $test;

/*
		$data = array('user' => $this->current_user);
		// ビューファイル全体に$title をセットする
		$this->template->set_global('title', 'レイアウト機能のサンプル');
		// テンプレートレイアウトを渡す
		$this->template->meta         = View::forge('layout/meta');
		$this->template->external_css = View::forge('layout/externalcss');
		$this->template->header       = View::forge('layout/header', $data);
		$this->template->content      = View::forge('layout/content');
		$this->template->side_bar     = View::forge('layout/sidebar');
		$this->template->footer       = View::forge('layout/footer');
*/
	}
}
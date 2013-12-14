<?php 
/**
 * コントローラーベーシックテンプレート
 * 
 * Viewのbasic群をforgeしてテンプレートに流し込み値を返す。
 * 
 * 
 */


class Controller_About extends Controller_Basic_Template {
	public function before() {
		parent::before();
	}

	public function action_index() {
		// セグメント情報取得
		$segment_info_get_array = Model_Info_Basis::segment_info_get();
//		var_dump($segment_info_get_array);

		// タイトルセット
		$this->basic_template->view_data["title"] = $segment_info_get_array["title_segment"].TITLE;

		// CSSセット
		$this->basic_template->view_data["external_css"] = View::forge('about/externalcss');

		// コンテンツデータセット
		$this->basic_template->view_data["content"]->set('content_data', array(
			'value' => View::forge('about/content'),
		), false);

		// ページングセット(解除)
		$this->basic_template->view_data["paging"]->set('paging_data', array(
			'paging_html' => '',
		), false);
	}
}
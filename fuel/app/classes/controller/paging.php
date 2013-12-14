<?php 
/**
 * ページングを操作するコントローラー
 * 
 * Viewのbasic群をforgeしてテンプレートに流し込み値を返す。
 * 
 * 
 */


class Controller_Paging extends Controller_Basic_Template {
	public function before() {
		parent::before();
	}

	public function action_index() {
		// 記事一覧データ取得
		$list_query              = Model_Article_Basis::list_get();
		// 記事一覧HTML生成
		$article_list_html_value = Model_Article_Basis::list_html_create($list_query);

//		var_dump($article_list_html_value);

		$this->basic_template->view_data["content"]->set('content_data', array(
			'summary_query'              => $list_query,
			'value'                      => $article_list_html_value,
		), false);
	}
}
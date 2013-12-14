<?php 
/**
 * 記事を操作するコントローラー
 * 
 * Viewのbasic群をforgeしてテンプレートに流し込み値を返す。
 * 
 * 
 */


class Controller_Article extends Controller_Article_Template {
	public function before() {
		parent::before();
	}

	public function action_index() {
		// 記事のHTML生成
			$article_data_array = Model_Article_Basis::article_html_create();
			// 記事のメタ生成
			$meta_html          = Model_Article_Basis::article_meta_html_create($article_data_array, 168);

		// 記事メタセット
		$this->article_template->view_data["meta"]->set('meta_data', array(
			'meta_html' => $meta_html,
		), false);
		// 記事タイトルセット
		$this->article_template->view_data["title"] = $article_data_array["article_title"];
		// 記事コンテンツセット
		$this->article_template->view_data["content"]->set('content_data', array(
			'article_html' => $article_data_array["article_html"],
		), false);
	}
}
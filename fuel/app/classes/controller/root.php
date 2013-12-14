<?php 
/**
 * コントローラーベーシックテンプレート
 * 
 * Viewのbasic群をforgeしてテンプレートに流し込み値を返す。
 * 
 * 
 */


class Controller_Root extends Controller_Basic_Template {
	public function before() {
		parent::before();
	}

	public function action_index() {
		// セグメント情報取得
		$segment_info_get_array = Model_Info_Basis::segment_info_get();
//		var_dump($segment_info_get_array);

		// タイトルセット
		$this->basic_template->view_data["title"] = $segment_info_get_array["title_segment"].TITLE;

		// メタセット(トップのみ)
		if($segment_info_get_array["top_judgment"] == true) {
//		var_dump($segment_info_get_array["top_judgment"]);
			$this->basic_template->view_data["meta"] = View::forge('root/meta');
		}
		// 記事一覧データ取得
		$list_query             = Model_Article_Basis::list_get($segment_info_get_array);
		// 記事一覧HTML生成
		$article_list_html      = Model_Article_Basis::list_html_create($list_query);
		// コンテンツデータセット
		$this->basic_template->view_data["content"]->set('content_data', array(
			'summary_query' => $list_query,
			'value'         => $article_list_html,
		), false);

		// ページングHTML追加
		$paging_html = Model_Paging_Basis::paging_html_create($segment_info_get_array);
		// ページングセット
		$this->basic_template->view_data["paging"]->set('paging_data', array(
			'paging_html' => $paging_html,
		), false);
	}
}
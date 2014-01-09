<?php 
/**
 * コントローラーレイアーティクルテンプレート
 * 
 * Viewのarticle群をforgeしてテンプレートに流し込み値を返す。
 * 
 * 
 */

class Controller_Article_Template extends Controller {
	public function __construct(\Request $request) {
		$this->request = $request;
	}

	public function before() {
		require APPPATH.'classes/library/autoload.php';
		$this->article_template            = View::forge('basic/template');
		$this->article_template->view_data = array(
			'title'        => 'ProgrammerBOX -プログラマーボックス-',
			'meta'         => View::forge('article/meta'),
			'external_css' => View::forge('basic/externalcss'),
			'header'       => View::forge('article/header'),
			'content'      => View::forge('article/content'),
			'paging'       => '',
			'side_bar'     => View::forge('basic/sidebar'),
			'footer'       => View::forge('basic/footer'),
			'script'       => View::forge('article/script'),
		);
		// カテゴリーHTML生成
		$category_ul_html  = Model_Sidebar_Basis::sidebar_category_html_create();
		// 人気記事HTML生成
		 $popular_li_html = Model_Sidebar_Basis::sidebar_popular_html_create();

		// サイドバーカテゴリーセット
		$this->article_template->view_data["side_bar"]->set('sidebar_data', array(
			'category_ul_html' => $category_ul_html,
			'popular_li_html'  => $popular_li_html,
		), false);
//		var_dump($this->article_template->view_data["side_bar"]);
	}

	public function after($response) {
		if($response === null) {
			$response = $this->article_template;
		}
		return parent::after($response);
	}
}
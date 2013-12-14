<?php 
/**
 * コントローラーレイアウトテンプレート
 * 
 * Viewのbasic群をforgeしてテンプレートに流し込み値を返す。
 * 
 * 
 */

class Controller_Basic_Template extends Controller {
	public $basic_template;

	public function __construct(\Request $request) {
		$this->request = $request;
	}

	public function before() {
		require APPPATH.'classes/library/autoload.php';
//		$rrrrrr = new Library_Autoload();
//		$Model_Library_Autoload = new Model_Library_Autoload();
//		echo $Library_Autoload->url;  // 参照(メモ)
//		$Library_Autoload->soo('f'); // 呼び出し(メモ)
//	echo Uri::segment(1);

		$this->basic_template = View::forge('basic/template');

		$this->basic_template->view_data = array(
			'title'        => 'ProgrammerBOX -プログラマーボックス-',
			'meta'         => View::forge('basic/meta'),
			'external_css' => View::forge('basic/externalcss'),
			'header'       => View::forge('basic/header'),
			'content'      => View::forge('basic/content'),
			'paging'       => View::forge('basic/paging'),
			'side_bar'     => View::forge('basic/sidebar'),
			'footer'       => View::forge('basic/footer'),
			'script'       => View::forge('basic/script'),
		);
		// カテゴリーHTML生成
		$category_ul_html = Model_Sidebar_Basis::sidebar_category_html_create();
		// 人気記事HTML生成
		$popular_li_html = Model_Sidebar_Basis::sidebar_popular_html_create();

		// サイドバーカテゴリーセット
		$this->basic_template->view_data["side_bar"]->set('sidebar_data', array(
			'category_ul_html' => $category_ul_html,
			'popular_li_html'  => $popular_li_html,
		), false);
	}
	public function after($response) {
		if($response === null) {
			$response = $this->basic_template;
		}
		return parent::after($response);
	}
}
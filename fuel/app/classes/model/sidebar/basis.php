<?php 
/**
 * サイドバーのデータを呼び出すモデルクラス
 * 
 * 
 * 
 * 
 */

class Model_Sidebar_Basis extends Model {
	//--------------
	//
	//--------------
	static function sidebar_category_html_create() {
		$category_li = '';
		// カテゴリー取得
		$query_1 = DB::query("
			SELECT COUNT(*) AS number, category
			FROM press
			WHERE del       = 0
			AND   category != 'ニュース' 
			AND   category != '初ブログ' 
			GROUP BY category
			ORDER BY `number` DESC")->cached(3600)->execute();
			// li生成
			foreach($query_1 as $key_1 => $value_1) {
//				var_dump('1');
//				var_dump($value_1);
				$value_1["category"];
				$query_2 = DB::query("
					SELECT * 
					FROM category_segment
					WHERE category_name = '".$value_1["category"]."'
					LIMIT 0, 1")->cached(3600)->execute();
//				var_dump($query_2);

				foreach($query_2 as $key_2 => $value_2) {
//				var_dump('2');
//				var_dump($value_2);
					$category_segment = $value_2["category_segment"];
					$category_li .= 
						'<li><a href="'.HTTP.$category_segment.'/">'.$value_1["category"].'<span>'.$value_1["number"].'</span></a>
							<ul class="sub_category_nav">';
					$category_name = $value_1["category"];
//					var_dump($category_name);
//					var_dump($category_li);
					$query_3 = DB::query("
						SELECT COUNT(*) AS number, sub_category
						FROM  press
						WHERE del      = 0
						AND   category = '".$category_name."'
						GROUP BY sub_category
						ORDER BY `number` DESC")->cached(3600)->execute();
					foreach($query_3 as $key_3 => $value_3) {
//						var_dump('3');
//						var_dump($value_3);
						// li生成_
						$query_4 = DB::query("
							SELECT *
							FROM category_segment
							WHERE category_name = '".$value_3["sub_category"]."'
							LIMIT 0, 1")->cached(3600)->execute();
						foreach($query_4 as $key_4 => $value_4) {
//							var_dump('4');
//							var_dump($value_4);
//						pre_var_dump($sub_category_data_array);
						$category_li .= '<li><a href="'.HTTP.$value_4["parent_segment"].'/'.$value_4["category_segment"].'/">'.$value_4["category_name"].'<span>'.$value_3["number"].'</span></a></li>';
						} // foreach($query_4 as $key_4 => $value_4) {
					} // foreach($query_3 as $key_3 => $value_3) {
				} // foreach($query_2 as $key_2 => $value_2) {
				$category_li .= '</ul></li>'; // HTMLのシッポを閉じる
			} // foreach($query_1 as $key_1 => $value_1) {
			// HTML合体
			$category_ul_html = ('<ul class="category_nav">'.$category_li.'</ul>');
			// HTML表示
//			print($category_ul_html);
			return $category_ul_html;
	}
	//----------------
	//人気記事HTML生成
	//----------------
	static function sidebar_popular_html_create() {
			// 人気記事取得
			$query = DB::query("
				SELECT * 
				FROM press
				WHERE del = 0 
				ORDER BY press.page_view DESC
				LIMIT 0, 6")->cached(3600)->execute();
						$popular_li_html = '';
						$press_year_time = '';
				foreach($query as $key => $value) {
//					var_dump($value);
							$press_year_time  = date('Y', $value["update_time"]);
							// ターゲット画像
							$targetImage = (PATH.'assets/img/press/'.$press_year_time.'/detail/'.$value["thumbnail_image"]);
							// コピー元画像のファイルサイズを取得
							list($image_w, $image_h) = getimagesize($targetImage);
							$image_reito = $image_h / $image_w;
							$new_image_h = (int)(268 * $image_reito);
							$popular_li_html .= 
								('<li class="o_8">
										<article>
											<a href="'.HTTP.$value["link"].'/">
												<img class="" src="'.HTTP.'assets/img/press/'.$press_year_time.'/detail/'.$value["thumbnail_image"].'" width="268" height="'.$new_image_h.'" title="'.$value["title"].'" alt="'.$value["title"].'">
												<div class="buzz_article_contents_title  clearfix">
													<h1>'.$value["title"].'</h1>
												</div>
											</a>
										</article>
								</li>');
				}
			return $popular_li_html;
	}





}
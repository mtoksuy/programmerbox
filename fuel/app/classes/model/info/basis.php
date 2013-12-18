<?php 
class Model_Info_Basis extends Model {
	//-----------
	//Uri情報取得
	//-----------
	public static function segment_info_get() {
		$top_judgment      = FALSE;
		$category_segment  = '';
		$category_name     = '';
		$parent_name       = '';
		$parent_segment    = '';
		$paging_segment    = 0;
		$last_segument     = '';
		$segment_error     = TRUE;
		$article_judgment  = FALSE;
		$article_url_error = FALSE;
		$title_segment     = '';

		// 現在いるファイル名を取得
		$url = $_SERVER["PHP_SELF"];
		// セグメントをarrayで並べる
		$segments_array = explode("/", $url);
		// 無駄なセグメント削除
		foreach($segments_array as $key => $value) {
			if($value == '' || $value == 'programmerbox' || $value == 'index.php') {
				// 上記の値の場合削除
				unset($segments_array[$key]);
			}
		}
		// arrayを詰める
		$segments_array = array_merge($segments_array);
		// arrayの順番を逆にする
		// $segments = array_reverse($segments_array);

		// トップページ判定
		if($segments_array == array()) {
			$top_judgment = TRUE;
		}
		//---------------------
		// セグメントを走査する
		//---------------------
		foreach($segments_array as $key => $value) {
			//------------
			//記事判定取得
			//------------
			if(preg_match('((^[0-9]{0,4})(-|_)([0-9]{0,2})(-|_)([0-9]{0,2})(-|_)(.*))', $value, $article_preg_array)) {
				$query = DB::query("
					SELECT COUNT(link)
					FROM press
					WHERE link = '".$value."'
					AND del    = 0
					LIMIT 0, 1")->cached(86400)->execute();
				foreach($query as $key_1 => $value_1) {
					// 公開している記事である
					if((int)$value_1["COUNT(link)"] === 1) {
						$article_judgment  = TRUE;
						$article_url_error = TRUE;
					}
						// 公開している記事ではない
						else {
							$article_judgment  = TRUE;
							$article_url_error = FALSE;
						}
				} // foreach($query as $key_1 => $value_1) {
			} // if(preg_match('((^[0-9]{0,4})(-|_)([0-9]{0,2})(-|_)([0-9]{0,2})(-|_)(.*))', $value, $article_preg_array)) {
				//--------------
				//ページング判定
				//--------------
				else if(preg_match('/(^[0-9]+?$)/', $value, $paging_preg_array)) {
//					var_dump($paging_preg_array);
//					print "ページング";
					$paging_segment = (int)$value;
				}
					//----------------
					//記事ではない場合
					//----------------
					else {
						// セグメント情報取得
						$query_count = DB::query("
							SELECT COUNT(*)
							FROM category_segment 
							WHERE category_segment = '".$value."'")->cached(86400)->execute();
						//--------------
						//セグメント確認
						//--------------
						foreach($query_count as $key_2 => $value_2) {
							// セグメントあり
							if($value_2["COUNT(*)"]) {
								$last_segument   = $value;
							}
								// セグメントなし
								else {
									$segment_error = FALSE;
								}
						}
					} // 記事ではない場合 else {
		} // foreach($segments_array as $key => $value) {
//		var_dump($last_segument);
//		echo $last_segument;
//		echo $paging_segment;

		// セグメント情報取得
		$query = DB::query("
			SELECT * 
			FROM category_segment 
			WHERE category_segment = '".$last_segument."'")->cached(86400)->execute();
		foreach($query as $key => $value) {
//			var_dump($value);
			$category_name    = $value["category_name"];
			$category_segment = $value["category_segment"];
			$parent_name      = $value["parent_name"];
			$parent_segment   = $value["parent_segment"];
		}

		// タイトルセグメント取得
		if($parent_name) {
			$title_segment .= $parent_name." | ";
		}
		if($category_name) {
			$title_segment .= $category_name." | ";
		}
		if($paging_segment) {
			$title_segment .= $paging_segment." | ";	
		}

		$segment_info_get_array = array(
			'top_judgment'         => $top_judgment,      // 
			'segment'              => $category_segment,  // 
			'segment_error'        => $segment_error,     // 
			'category_name'        => $category_name,     // 
			'category_segment'     => $category_segment,  // 
			'parent_name'          => $parent_name,       // 
			'parent_segment'       => $parent_segment,    // 
			'paging_segment'       => $paging_segment,   // 
			'article_judgment'     => $article_judgment,  // 
			'article_url_error'    => $article_url_error, // 
			'title_segment'        => $title_segment,   //
		);
		return $segment_info_get_array;
	}
	//------------------------
	//ブログの公開記事の数取得
	//------------------------
	public static function article_count_get($segment_info_get_array) {
		switch($segment_info_get_array["segment"]) {
			case '':
				$and_query = '';
			break;
			default:
				// お父さん
				if(! $segment_info_get_array["parent_name"]) {
					$and_query =  "AND category = '".$segment_info_get_array["category_name"]."'";
				}
					// 子供
					else {
						$and_query =  "AND sub_category = '".$segment_info_get_array["category_name"]."'";
					}
			break;
		}
		// 記事のカウント取得
		$query = DB::query("
			SELECT COUNT(primary_id) 
			FROM press
			WHERE del = 0
			".$and_query."
			")->execute();
		foreach($query as $key => $value) {
			$article_count_number = $value["COUNT(primary_id)"];
		}
		return $article_count_number;
	}
	//
	//
	//
	public static function category_info_get($category = null) {
//		var_dump($category);
		$category_info_array = array();
		$res = DB::query("
			SELECT *
			FROM category_segment
			WHERE category_name = '".$category."'
			AND parmalink_check = 0")->execute();
		foreach($res as $key => $value) {
//				var_dump($value);
			$category_info_array = $value;
		}
		return $category_info_array;		
	}
}

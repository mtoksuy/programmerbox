<?php 
class Model_Paging_Basis extends Model {
	//------------------
	//ページングHTML生成
	//------------------
	static function paging_html_create($segment_info_get_array) {
		$paging_html   = '';
		$category_dir  = '';

		// 
		switch($segment_info_get_array["segment"]) {
			case '':
				$category_dir = '';
			break;
			default:
				// お父さん
				if(! $segment_info_get_array["parent_name"]) {
					$category_dir = $segment_info_get_array["category_segment"].'/';
				}
					// 子供
					else {
						$category_dir = $segment_info_get_array["parent_segment"].'/'.$segment_info_get_array["category_segment"].'/';
					}
			break;
		}
//		var_dump($segment_info_get_array);

		// ブログの公開記事の数取得
		$max_primary_id = Model_Info_Basis::article_count_get($segment_info_get_array);
//		var_dump($max_primary_id);

		// 現在のページ
//		$paging_spot = (int)Uri::segment(1);
		$paging_spot = (int)$segment_info_get_array["paging_segment"];
//		var_dump((int)$segment_info_get_array["paging_segment"]);
//		var_dump($paging_spot);

		// 数字以外のディレクトリの場合
		if($paging_spot == 0) {
			$paging_spot = '';
		}
		// 数字のディレクトリの場合
		if(is_int($paging_spot)) {
			
		}
			// 数字以外のディレクトリの場合
			else {
				$paging_spot = 1;
			}
//$category_dir
		// 
		$last  = (int)ceil($max_primary_id / 10);
//		var_dump($last);
		$last_spot = $last - $paging_spot;
//		var_dump($last_spot);
		//表示するページ位置を取得
		$paging_spot = intval($paging_spot); // 整数にする関数
		// ページ総数が1以下の場合
		if($last <= 1) {
		
		}
			// 総ページが2以上の場合
			else {
				$i = 0;
				$ii = 0;
				// ページ総数が10以下の場合
				if($last <= 10) {
					$test = "q_a";
					$namber = $last;
				}
					// ページ総数が10以上の場合
					else if($last > 10) {
						$test = "q_b";
						$namber = 10;
						// 一番後ろの数が0より大きかった場合
						if(($paging_spot - 5) >= 0) {
							$test = "q_b_a";
							$ii = $paging_spot - 5;
						}
							// 一番後ろの数が0より小さかった場合
							else if(($paging_spot - 5) <= 0) {
								$test = "q_b_b";
								$ii = 0;
							}
						// ページングに5を足しても総ページより少ない場合
						if(($paging_spot + 5) <= $last) {
							$test = "q_c_a";
						}
							// ページングに5を足しても総ページより少ない場合
							else if(($paging_spot + 5) >= $last) {
									$test = "q_c_b";
									$ii = $last - 10;
							}
					}  // else if($last > 10)
					// array生成
					while($i < $namber) {
						$i++;
						$ii++;
						$paging_array[] = $ii;
					}
					// $paging_arrayがあった場合
					if($paging_array == TRUE) {
						// html生成
						foreach($paging_array as $key => $value) {
							// 現在地はspanにする
						 if($paging_spot == $value) {
							 $paging_html = $paging_html.'<li><span>'.$value.'</span></li>';
							}
							// リンク張り
							else if($paging_spot != $value) {
								 $paging_html = $paging_html.'<li><a href="'.HTTP.$category_dir.$value.'/'.'">'.$value.'</a></li>';
							}
						} // foreach($paging_array as $key => $value)
					} // if($paging_array == TRUE)
			} // 総ページが2以上の場合 else
			// プレビューを付ける
			if($paging_spot != 1 && $last != 0) {
				$paging_next = $paging_spot - 1;
				$paging_html = '<li><a href="'.HTTP.$category_dir.$paging_next.'/'.'">Prev</a></li>'.$paging_html;
			}
			// ネクストを付ける
			if($last != $paging_spot) {
				$paging_next = $paging_spot + 1;
				$paging_html = $paging_html.'<li><a href="'.HTTP.$category_dir.$paging_next.'/'.'">Next</a></li>';
			}
			// ページング表示
			$paging_html = 
			('<div class="paging">
				<ul  class="clearfix">
					'.$paging_html.'
				</ul>
			</div>');
/*
				print "<br>";
				print ('ページングスポット'.$paging_spot);
				print "<br>";
				print ('ラストスポット'.$last_spot);
				print "<br>";
				print ('表示数'.$ii);
				print "<br>";
				print ('総ページ数'.$last);
				print "<br>";
				print ('なんばー'.$namber);
				print "<br>";
				print ($test);
*/
	return $paging_html;
	}
}
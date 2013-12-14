<?php 
class Model_Article_Basis extends Model {
	//------------------
	//記事一覧データ取得
	//------------------
	static function list_get($segment_info_get_array) {
//		var_dump($segment_info_get_array);
		$limit_num = '';
		$get_num   = '';
		// limitクエリ
		switch($segment_info_get_array["paging_segment"]) {
			case 0:
			case 1:
				$start_num = 0;
				$get_num = 10;	
			break;
			default:
				$start_num = (($segment_info_get_array["paging_segment"] * 10) - 10);
				$get_num = 10;
			break;
		}
		$limit_query = "LIMIT ".$start_num.", ".$get_num."";

		// andクエリ
		switch($segment_info_get_array["segment"]) {
			case '':
				$and_query =  '';
			break;
			// カテゴリー挙動仕分け
			default:
				// 主カテゴリー
				if(! $segment_info_get_array["parent_name"]) {
					$and_query   = "AND category = '".$segment_info_get_array["category_name"]."'";
				}
					// 副カテゴリー
					else {
						$and_query =  "AND sub_category = '".$segment_info_get_array["category_name"]."'";
					}
			break;
		}
		$list_query = DB::query("
			SELECT * 
			FROM press
			LEFT JOIN category_segment 
			ON press.sub_category = category_segment.category_name
			WHERE press.del = 0
			".$and_query."
			ORDER BY press.primary_id DESC
			".$limit_query."")->cached(86400)->execute();
//		var_dump($list_query);

/*
SELECT *
FROM press
JOIN category_segment 
WHERE press.del = 0 
AND press.sub_category = category_segment.category_name
ORDER BY press.primary_id DESC
LIMIT 0, 10

SELECT * FROM press
LEFT JOIN category_segment 
ON press.sub_category = category_segment.category_name
WHERE press.del = 0
ORDER BY press.primary_id DESC
LIMIT 0, 10
*/

//		foreach($list_query as $key => $value) {
//			var_dump($value);
//			var_dump($key);
//		}
		return $list_query;
	}
	//----------------
	//記事一覧HTML生成
	//----------------
	public static function list_html_create($list_query) {
//		Debug::dump($list_query);
//		var_dump($list_query);
		$article_list_html_array = array();
		$article_list_html = '';
		$i = 0;
		foreach($list_query as $key => $value) {
			// 記事データ取得
			$press_author        = $value["programmerbox_id"];
			$local_time          = date('Y-m-d', $value["update_time"]);
			$local_japanese_time = date('Y年m月d日', $value["update_time"]);
			$article_year_time   = date('Y', $value["update_time"]);
			// ターゲット画像
			$targetImage = (PATH.'assets/img/press/'.$article_year_time.'/detail/'.$value["thumbnail_image"]);

			// コピー元画像のファイルサイズを取得
			list($image_w, $image_h) = getimagesize($targetImage);

			// 置換する前に軽くする
			$value["press"] = mb_strimwidth($value["press"], 0, 500, "...", 'utf8');
			// タグを消す
			$value["press"] = str_replace(array('<br>', '<p>', '<p class="m_0">', '</p>'), '', $value["press"]);
			// 本文を168文字に丸める
			$strimwidth_press = mb_strimwidth($value["press"], 0, 168, "...", 'utf8');
			// 記事一覧HTMLarry生成
			$article_list_html_array[$i] = ('
				<article class="home_press">
					<a href="'.HTTP.$value["link"].'/">
						<div class="press_contents">
							<h1>'.$value["title"].'</h1>
							<p class="press_contents_p">'.$strimwidth_press.'</p>
							<time pubdate="pubdate" datetime="'.$local_time.'">'.$local_japanese_time.'</time>
						</div>
						<figure class="">
							<p>
								<img class="home_press_thumbnail" src="'.HTTP.'assets/img/press/'.$article_year_time.'/detail/'.$value["thumbnail_image"].'" width="'.$image_w.'" height="'.$image_h.'" title="'.$value["title"].'" alt="'.$value["title"].'">
							</p>
						</figure>
						<div class="social_view">
							<ul>
								<li><img class="" src="'.HTTP.'assets/img/common/hatena_icon_1.png" width="20" height="20" alt="" title=""><span>'.$value["hatena_social_value"].'</span></li>
								<li><img class="" src="'.HTTP.'assets/img/common/twitter_icon_2.png" width="20" height="20" alt="" title=""><span>'.$value["twitter_social_value"].'</span></li>
								<li><img class="" src="'.HTTP.'assets/img/common/facebook_icon_4.png" width="20" height="20" alt="" title=""><span>'.$value["facebook_social_value"].'</span></li>
							</ul>
						</div>
						<div class="category_band '.$value["category_color"].'">'.$value["sub_category"].'</div>
					</a>
				</article>
');
			$i++;
		}
		// 記事一覧HTML生成
		foreach($article_list_html_array as $key => $value) {
			$article_list_html .= $value;
		}
//		var_dump($article_list_html);
		return $article_list_html;
	}
	//-----------
	//Uri情報取得
	//-----------
	public static function article_segment_info_get() {
		$category_segment = '';
		$category_name    = '';
		$parent_name      = '';
		$parent_segment   = '';
		$paging_segument  = '';
		$last_segument    = '';
		// 記事のカウント取得
		$query = DB::query("
			SELECT COUNT(primary_id) 
			FROM press
			WHERE del = 0")->execute();
		foreach($query as $key => $value) {
			$article_count_number = $value["COUNT(primary_id)"];
		}
		// 現在いるファイル名を取得
		$url = $_SERVER["PHP_SELF"];
//		echo $url;
		// セグメントをarrayで並べる
		$segments_array = explode("/", $url);
		// 無駄なセグメント削除
		foreach($segments_array as $key => $value) {
			if($value == '' || $value == 'programmerbox' || $value == 'index.php') {
				unset($segments_array[$key]);
			}
		}
		// arrayを詰める
		$segments_array = array_merge($segments_array);
		// arrayの順番を逆にする
		// $segments = array_reverse($segments_array);
		
		// 最後のセグメント取得
		foreach($segments_array as $key => $value) {
			if((int)$value === 0) {
				$last_segument = $value;
			}
				else {
					$paging_segument = $value;
				}
		}
//		echo $last_segument;
//		echo $paging_segument;

		$query = DB::query("
			SELECT * 
			FROM category_segment 
			WHERE category_segment = '".$last_segument."'")->execute();
		foreach($query as $key => $value) {
			$category_name    = $value["category_name"];
			$category_segment = $value["category_segment"];
			$parent_name      = $value["parent_name"];
			$parent_segment   = $value["parent_segment"];
		}
		$article_segment_info_get_array = array(
			'article_count_number' => $article_count_number,
			'segment'              => $category_segment,
			'category_name'        => $category_name,
			'category_segment'     => $category_segment,
			'parent_name'          => $parent_name,
			'parent_segment'       => $parent_segment,
			'paging_segument'      => $paging_segument,
		);
		return $article_segment_info_get_array;
	}
	//--------------
	//記事のHTML生成
	//--------------
	static function article_html_create() {
//		echo Uri::segment(1);
		$query = DB::query("
			SELECT * 
			FROM press 
			WHERE del = 0
			AND link = '".Uri::segment(1)."'
			LIMIT 0, 1")->cached(3600)->execute();
		foreach($query as $key => $value) {
//			var_dump($value);
			// 記事のprimary_id取得
			$press_primary_id    = $value["primary_id"];
			// 記事作成者取得
			$press_author        = $value["programmerbox_id"];
			// 記事作成時間取得
			$creation_time       = $value["creation_time"];
			$local_time          = date('Y-m-d', $value["update_time"]);
			$local_japanese_time = date('Y年m月d日', $value["update_time"]);
			$article_year_time   = date('Y', $value["update_time"]);
			// 記事タイトル取得
			$article_title = $value["title"];
			// 記事本文取得
			$article_value = $value["press"];
			// 記事サムネイルネーム取得
			$article_thumbnail_image = $value["thumbnail_image"];


			// タグHTML生成
			list($tag_array, $detail_press_tag_html) = Model_Article_Basis::article_tag_html_create($value["tag"]);
			// 記事のページビューを加算する
			Model_Article_Basis::article_pageview_plus($press_primary_id);
			// 関連記事HTML生成
			$popular_press_li_html = Model_Article_Basis::article_related_html_create($press_primary_id, $tag_array);
			// 関連記事、前の記事、次の記事HTML生成
			$detail_press_bottom_html = Model_Article_Basis::article_previous_next_html_create($press_primary_id, $popular_press_li_html);
		// ターゲット画像
		$targetImage = (PATH.'assets/img/press/'.$article_year_time.'/detail/'.$value["thumbnail_image"]);
		// コピー元画像のファイルサイズを取得
		list($image_w, $image_h) = getimagesize($targetImage);
			$article_html = ('
				<article class="detail_press">
					<h1><a href="'.HTTP.$value["link"].'/">'.$value["title"].'</a></h1>
					<div class="plagin_list">
						<ul>
							<!-- はてブ -->
							<li class="hatena_xxx">
								<a href="http://b.hatena.ne.jp/entry/'.HTTP.$value["link"].'/" class="hatena-bookmark-button" data-hatena-bookmark-title="'.$value["title"].'" data-hatena-bookmark-layout="standard-balloon" title="このエントリーをはてなブックマークに追加"><img src="http://b.st-hatena.com/images/entry-button/button-only.gif" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" /></a>
							</li>
							<!-- Tweet -->
							<li class="tw_xxx">
								<a href="'.HTTP.$value["link"].'/" class="twitter-share-button" data-url="'.HTTP.$value["link"].'/" data-text="'.$value["title"].'" data-via="" data-related="mtoksuy" data-lang="en">Tweet</a>
							</li>
							<!-- いいね -->
							<li class="fb_xxx">
								<div class="fb-like" data-href="'.HTTP.$value["link"].'/" data-send="false" data-layout="button_count" data-width="150" data-show-faces="false" data-font="arial" data-lang="en"></div>
							</li>
							<!-- Pcket -->
							<li class="pcket_xxx">
								<a data-pocket-label="pocket" data-pocket-count="horizontal" class="pocket-btn" data-lang="en"></a>
							</li>
							<!-- g+ -->
							<li class="g_plus_xxx">
								<div class="g-plusone" data-size="medium"></div>
							</li>
						</ul>
					</div>
					<div class="">
						<span class="cc">By</span><span class="press_author"><a href="http://twitter.com/mtoksuy" target="_blank">@'.$press_author.'</a></span><span class="cc_time">On</span>
						<time pubdate="pubdate" datetime="'.$local_time.'">'.$local_japanese_time.'</time>
					</div>
						<!-- タグ -->
						'.$detail_press_tag_html.'
					<!-- サムネイル -->
					<img class="detail_press_thumbnail" src="'.HTTP.'assets/img/press/'.$article_year_time.'/detail/'.$value["thumbnail_image"].'" width="'.$image_w.'" height="'.$image_h.'" title="'.$value["title"].'" alt="'.$value["title"].'">
					<!-- 記事内容 -->
					'.$value["press"].'
					<div class="clearfix">
						<!-- plagin_list -->
						<div class="plagin_list_bottom_right">
							<ul>
								<!-- はてブ -->
								<li class="hatena_vertical">
									<a href="http://b.hatena.ne.jp/entry/'.HTTP.$value["link"].'/" class="hatena-bookmark-button" data-hatena-bookmark-layout="vertical-balloon" title="このエントリーをはてなブックマークに追加"><img src="http://b.st-hatena.com/images/entry-button/button-only.gif" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" /></a>
								</li>
								<!-- Tweet -->
								<li class="tw_vertical">
									<a href="'.HTTP.$value["link"].'/" class="twitter-share-button" data-url="'.HTTP.$value["link"].'/" data-text="'.$value["title"].'" data-via="" data-related="mtoksuy" data-lang="en" data-count="vertical">Tweet</a>
								</li>
								<!-- いいね -->
								<li class="fb_vertical">
									<div class="fb-like" data-href="'.HTTP.$value["link"].'/" data-send="false" data-layout="box_count" data-width="150" data-show-faces="false" data-font="arial" data-lang="en"></div>
								</li>
								<!-- Pcket -->
								<li class="pcket_vertical">
									<a data-pocket-label="pocket" data-pocket-count="vertical" class="pocket-btn" data-lang="en"></a>
								</li>
								<!-- g+ -->
								<li class="g_plus_vertical">
									<div class="g-plusone" data-size="tall"></div>
								</li>
							</ul>
						</div>
					</div>
					<!-- 前の記事、次の記事 -->
					'.$detail_press_bottom_html.'
				</article>');
			$article_data_array = array(
				'article_html'            => $article_html, 
				'article_title'           => $article_title, 
				'article_value'           => $article_value, 
				'article_year_time'       => $article_year_time, 
				'article_thumbnail_image' => $article_thumbnail_image);
			return $article_data_array;
		}
	}  // function article_html_create() {
	//------------
	//タグHTML生成
	//------------
	static function article_tag_html_create($tag) {
		// タグ機能
		/**
		/ 現状、デザイン以外出来ていないのでaタグは外す
		/ 2013.01.24 松岡
		*/
		// タグarray
		$tag_array = explode(' ', $tag);
		$tag_li = '';
		// タグありとなしの場合
		switch($tag) {
			case '':
				$tag_li = '';
			break;
			default:
				foreach($tag_array as $key => $value) {
					$tag_li .= '
											<li><a>'.$value.'</a></li>';
				}
			break;
		}
		// タグHTML生成
		$detail_press_tag_html = ('
			<div class="detail_press_tag">
				<ul>
					<li>Tag To</li>
			'.$tag_li.
				'</ul>
			</div>');
		return array($tag_array, $detail_press_tag_html);
	}
	//----------------------------
	//記事のページビューを加算する
	//----------------------------
	static function article_pageview_plus($press_primary_id) {
		// アクセス数アップデート
		$query = DB::query("
			SELECT page_view 
			FROM press 
			WHERE primary_id = $press_primary_id")->execute();
//			var_dump($query);
		foreach($query as $key => $value) {
			$page_view = (int)$value["page_view"];
			$page_view++;
		}
//		var_dump($page_view);
		$query = DB::query("
			UPDATE press SET 
			page_view = $page_view 
			WHERE primary_id = $press_primary_id")->execute();
	}
	//----------------
	//関連記事HTML生成
	//----------------
	static function article_related_html_create($press_primary_id, $tag_array) {
    $sql = 'SELECT * FROM press WHERE ';
    foreach ($tag_array as $key => $keyword) {
        $keywords[$key] = "tag like ".("'%".$keyword."%'")."";
    }
    $sql.= join(' OR ', $keywords);
    $sql = $sql.' AND del = 0 
			ORDER BY social_value DESC
			LIMIT 0 , 9';
		/* sql文結果 例
		SELECT * 
		FROM press 
		WHERE tag like '%フォントフリー%' 
		OR tag like '%無料%' 
		OR tag like '%ダウンロード%' 
		OR tag like '%インストール%' 
		OR tag like '%2013年%' 
		OR tag like '%まとめ%' 
		AND del = 0 
		ORDER BY social_value DESC
		LIMIT 0 , 9
		*/
		$query = DB::query($sql)->execute();
//		var_dump($query);
		$popular_press_li = '';
		foreach($query as $key => $value) {
//			var_dump($value["primary_id"]);
	    if($press_primary_id != $value["primary_id"]) {
				$article_year_time = date('Y', $value["update_time"]);
//			var_dump($value["update_time"]);
				// ターゲット画像
				$targetImage = (PATH.'assets/img/press/'.$article_year_time.'/detail/'.$value["thumbnail_image"]);
				// コピー元画像のファイルサイズを取得
				list($image_w, $image_h) = getimagesize($targetImage);
				$image_reito = $image_h / $image_w;
				$new_image_h = (int)(200 * $image_reito);
				$popular_press_li .= 
					('<li class="o_8">
							<article>
								<a href="'.HTTP.$value["link"].'/">
									<img class="" src="'.HTTP.'assets/img/press/'.$article_year_time.'/detail/'.$value["thumbnail_image"].'" width="200" height="'.$new_image_h.'" title="'.$value["title"].'" alt="'.$value["title"].'">
									<div class="related_article_contents_title clearfix">
										<h1>'.$value["title"].'</h1>
									</div>
								</a>
							</article>
					</li>');
			} // if($value["primary_id"] != $value["primary_id"]) {
		} // foreach($query as $key => $value) {
		return $popular_press_li;
	}
	//------------------------------------
	//関連記事、前の記事、次の記事HTML生成
	//------------------------------------
	static function article_previous_next_html_create($press_primary_id, $popular_press_li_html) {
		$query_p = DB::query("SELECT * 
									FROM press
									WHERE primary_id < $press_primary_id
									AND del = 0
									ORDER BY press.primary_id DESC
									LIMIT 0 , 1")->execute();
		$query_n = DB::query("SELECT * 
									FROM press
									WHERE primary_id > $press_primary_id
									AND del = 0
									ORDER BY press.primary_id ASC
									LIMIT 0 , 1")->execute();
		$preview_html = '';
		$next_html    = '';
		foreach($query_p as $key => $value) {
			$preview_html = ('<div class="detail_press_previous"><a href="'.HTTP.$value["link"].'/">前の投稿へ</a></div>');
		}
		foreach($query_n as $key => $value) {
			$next_html = ('<div class="detail_press_next"><a href="'.HTTP.$value["link"].'/">次の投稿へ</a></div>');
		}
		// google_ad_html
		$google_ad_html = ('<div class="detail_press_google_ad_bottom">
	<script type="text/javascript"><!--
	google_ad_client = "ca-pub-0450119979424968";
	/* 詳細記事広告ユニット */
	google_ad_slot = "5103970854";
	google_ad_width = 468;
	google_ad_height = 60;
	//-->
	</script>
	<script type="text/javascript"
	src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
	</script>
</div>');
		// 関連記事、前の記事、次の記事HTML生成
		$detail_press_bottom_html = 
			('<div class="detail_press_bottom clearfix">
					<nav class="related_article">
						<div class="related_article_content">
							<div class="related_article_header">
								関連記事
							</div>
							<ul class="clearfix">
								'.$popular_press_li_html.'
							</ul>
						</div>						
					</nav>
				'.$preview_html.$google_ad_html.$next_html.'
			</div>');
		return $detail_press_bottom_html;
	}
	//----------------
	//記事メタHTML生成
	//----------------
	static function article_meta_html_create($article_data_array, $description_length = 168) {
		if(! is_int($description_length)) {
			$description_length = 168;
		}
		$strimwidth_press = Model_Article_Basis::meta_description_html_create($article_data_array["article_value"], $description_length);

    $meta_html = ('
			<!-- Twitter -->
			<meta name="twitter:card" content="summary"> <!-- カードの種類 -->
			<meta name="twitter:site" content="@mtoksuy"> <!-- サイトのtwitterアカウント -->
			<meta name="twitter:creator" content="@mtoksuy"> <!-- 制作者ないし投稿者 -->
			<meta name="twitter:url" content="'.HTTP.Uri::segment(1).'/'.'"> <!-- コンテンツのURL -->
			<meta name="twitter:title" content="'.$article_data_array["article_title"].'"> <!-- コンテンツのタイトル(70文字以内) -->
			<meta name="twitter:description" content="'.$strimwidth_press.'"> <!-- コンテンツの概要(200文字以内) -->
			<meta name="twitter:image" content="'.HTTP.'assets/img/press/'.$article_data_array["article_year_time"].'/square_120px/'.$article_data_array["article_thumbnail_image"].'"> <!-- サムネイル 120px x 120pxから60px x60pxまで -->

			<!-- ogp -->
			<meta property="og:site_name" content="ProgrammerBOX -プログラマーボックス-"> <!-- サイト名 -->
			<meta property="og:url" content="'.HTTP.Uri::segment(1).'/'.'"> <!-- コンテンツのURL -->
			<meta property="og:title" content="'.$article_data_array["article_title"].'"> <!-- 記事タイトル -->
			<meta property="og:type" content="article"> <!-- タイプ -->
			<meta property="og:image" content="'.HTTP.'assets/img/press/'.$article_data_array["article_year_time"].'/square_200px/'.$article_data_array["article_thumbnail_image"].'"> <!-- サムネイル 50px x 50px -->
			<meta property="og:description" content="'.$strimwidth_press.'"> <!-- コンテンツの概要 -->
		');
		return $meta_html;
	}
	//----------------
	//メタ概要HTML生成
	//----------------
	static function meta_description_html_create($article_value, $description_length) {
		// 置換する前に軽くする
		$article_value = mb_strimwidth($article_value, 0, 500, "...", 'utf8');
		// タグを消す
		$article_value = str_replace(array('<br>', '<p>', '<p class="m_0">', '</p>'), '', $article_value);
		// 本文を168文字に丸める
		$strimwidth_press = mb_strimwidth($article_value, 0, $description_length, "...", 'utf8');
		return $strimwidth_press;
	}
}
<?php 
/**
 * ルーティング
 * 
 * ルーティングを返す前に現在いるURLを調べ
 * 記事であれば記事のコントローラーに行かせる。
 * 
 */

//---------
//URL取得群
//---------
$url         = $_SERVER["PHP_SELF"];              // 現在いるファイル名を取得
$file_name   = basename($url);                    // ファイルネーム取得
$dir_1       = dirname($url);                     // 一つ前
$dir_2       = dirname($dir_1);                   // もう一つ前
$dir_name    = strrchr($dir_1,"/");               // 特定の文字列からの文字列を取得 
$dir_name    = str_replace("/", "", $dir_name);   // 特定の文字列を置換
$dir_name_2  = strrchr($dir_2,"/");               // 特定の文字列からの文字列を取得 
$dir_name_2  = str_replace("/", "", $dir_name_2); // 特定の文字列を置換
// スラッシュがなかったら追加
$url_r = str_replace('/index.php', '', $url);
if(! mb_substr($url_r, -1) === '/') {
	$url_r.='/';
}
//echo $url_r;
//echo $url;

$segment_info_get_array = Model_Info_Basis::segment_info_get();
//var_dump($segment_info_get_array);

// エラーページ
if($segment_info_get_array["segment_error"] === FALSE) {
	return array(
		'.*?'  => 'error/404', 
	);
}
	else {
		return array(
			'_root_'                                                     => 'root',          // The default route
			'_404_'                                                      => 'error/404',     // The main 404 route
			'about'                                                      => 'about',
			'contact'                                                    => 'contact',
			'(([0-9]{0,4})(-|_)([0-9]{0,2})(-|_)([0-9]{0,2})(-|_)(.*))'  => 'article/index', // 記事
			'[0-9]+?$'                                                   => 'root',          // トップ ページング
			'.*?/.*?/[0-9].*?$'                                          => 'root',          // 子セグメントページング
			'.*?/[0-9].*?$'                                              => 'root',          // 親セグメントページング
			'.*?/.*?'                                                    => 'root',          // 子セグメント
			'.*?'                                                        => 'root',          // 親セグメント
		//	'(.*?)' => 'root',
		//	'web'      => 'root',	
		//	'web/html_css'      => 'root',	
		//	'(([0-9]{0,4})(-|_)([0-9]{0,2})(-|_)([0-9]{0,2})(-|_)(.*?))' => array('article/index', 'name' => $url_r), // 記事
		);
}
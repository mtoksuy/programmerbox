<?php 
/**
 * コントローラー
 * 
 * 
 * 
 * 
 */

class Controller_Cronsocialvalueget extends Controller {
	public function action_index() {
/*
		// コンテンツデータセット
		$this->basic_template->view_data['content']->set('content_data', array(
			'value' => '',
		), false);
		// ページングセット
		$this->basic_template->view_data["paging"]->set('paging_data', array(
			'paging_html' => '',
		), false);
*/
// 単純な実行時エラーを表示する
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
//----------
//エラー表示
//----------
//ini_set('error_reporting', E_ALL);
// 全てのエラー出力をオフにする
ini_set('display_errors', '0');
error_reporting(0);
//----------------
//マルチリクエスト
//----------------
function multi_request($data, $options = array()) {
//var_dump($data);
//var_dump($options);
//$data = array();

  // array of curl handles
  $curly = array();
  // data to be returned
  $result = array();

  // multi handle
  $mh = curl_multi_init();
//  pre_var_dump($mh);


  // loop through $data and create curl handles
  // then add them to the multi-handle
  foreach ($data as $id => $d) {

    $curly[$id] = curl_init();

    $url = (is_array($d) && !empty($d['url'])) ? $d['url'] : $d;
    curl_setopt($curly[$id], CURLOPT_URL,            $url);
    curl_setopt($curly[$id], CURLOPT_HEADER,         0);
    curl_setopt($curly[$id], CURLOPT_RETURNTRANSFER, 1);

    // post?
    if (is_array($d)) {
      if (!empty($d['post'])) {
        curl_setopt($curly[$id], CURLOPT_POST,       1);
        curl_setopt($curly[$id], CURLOPT_POSTFIELDS, $d['post']);
      }
    }

    // extra options?
    if (!empty($options)) {
      curl_setopt_array($curly[$id], $options);
    }

    curl_multi_add_handle($mh, $curly[$id]);
   }


  // execute the handles
  $running = null;
  do {
    curl_multi_exec($mh, $running);
  } while($running > 0);

  // get content and remove handles
  foreach($curly as $id => $c) {
    $result[$id] = curl_multi_getcontent($c);
    curl_multi_remove_handle($mh, $c);
  }

  // all done
  curl_multi_close($mh);

  return $result;
}




//-------------
//cron用ini設定
//-------------
ini_set('max_execution_time',180);
ini_set('memory_limit', "64M");
//--------
//変数生成
//--------
/*
$_SERVER["HTTP_HOST"]       = 'programmerbox.com';
$_SERVER["DOCUMENT_ROOT"]   = '/var/www/vhosts/programmerbox.com/httpdocs';
$_SERVER["PHP_SELF"]        = '/cron/social/social_value_get.php';
$_SERVER['HTTP_USER_AGENT'] = "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:21.0) Gecko/20100101 Firefox/21.0";
*/
//	var_dump($path);

// ソーシャルAPI
$hatena_API             = 'http://api.b.st-hatena.com/entry.count?url=';
$twitter_API            = 'http://urls.api.twitter.com/1/urls/count.json?url=';
$facebook_API           = 'https://graph.facebook.com/';
// ソーシャルナンバー
$hatenamu_number        = 0;
$teet_number            = 1;
$facebook_number        = 2;
// 変数定義
$data                   = array();
$press_primary_id_array = array();
$i                      = 0;
$ii                     = 0;
$i_p                    = 0;
// primary_id取得用クエリ
	$query = DB::query("SELECT * 
						FROM press
						WHERE del = 0")->execute();

// primary_idとsocial_value取得
foreach($query as $key => $value) {
//var_dump($value);
	$press_primary_id_array[$i_p]       = $value["primary_id"];
	$press_old_social_value_array[$i_p] = $value["social_value"];
	$i_p++;
}

	$query = DB::query("SELECT * 
						FROM press
						WHERE del = 0")->execute();
	// link取得
	foreach($query as $key => $value) {
		// 各ソーシャルAPIの記事URLをdataに格納
		$data[$i] = $hatena_API.urlencode(HTTP.$value["link"].'/');
		$i++;
		$data[$i] = $twitter_API.urlencode(HTTP.$value["link"].'/');
		$i++;
		$data[$i] = $facebook_API.urlencode(HTTP.$value["link"].'/');
		$i++;
	}
//	pre_var_dump($data);
// カウント
$i  = $i / 3;
$ii = 0;
// マルチリクエスト
$m_r_social_value = multi_request($data);
var_dump($m_r_social_value);

while($i > 0) {
	$i--;
	// はてな
	$hatenabu_num      = (int)$m_r_social_value[$hatenamu_number];

	// Tw
	$tw_json           = $m_r_social_value[$teet_number];
	$tw_json           = json_decode($m_r_social_value[$teet_number], false);
	$teet_num          = (int)$tw_json->count;

	// FB
  $facebook_json     = json_decode($m_r_social_value[$facebook_number], false);
  $facebook_num      = (int)$facebook_json->shares;
  $facebook_comments = (int)$facebook_json->comments;

  // arrayに入れる
  $item_hatenamu_temporary_array[$ii]          = $hatenabu_num;
  $item_teet_temporary_array[$ii]              = $teet_num;
  $item_facebook_shares_temporary_array[$ii]   = $facebook_num;
  $item_facebook_comments_temporary_array[$ii] = $facebook_comments;

  // 次の配列の数字に行く
	$hatenamu_number = $hatenamu_number + 3;
	$teet_number     = $teet_number     + 3;
	$facebook_number = $facebook_number + 3;
	$ii++;
}
//	pre_var_dump($item_hatenamu_temporary_array);
//	pre_var_dump($item_teet_temporary_array);
//	pre_var_dump($item_facebook_shares_temporary_array);
//	pre_var_dump($item_facebook_comments_temporary_array);

// 一つのarrayに集約する
foreach($item_hatenamu_temporary_array as $key => $value) {
	$press_array[$key]["primary_id"]        = $press_primary_id_array[$key];
	$press_array[$key]["old_social_value"]  = $press_old_social_value_array[$key];
	$press_array[$key]["hatena"]            = $item_hatenamu_temporary_array[$key];
	$press_array[$key]["tweet"]             = $item_teet_temporary_array[$key];
	$press_array[$key]["facebook_shares"]   = $item_facebook_shares_temporary_array[$key];
	$press_array[$key]["facebook_comments"] = $item_facebook_comments_temporary_array[$key];
	$press_array[$key]["social_value"]      = ($item_hatenamu_temporary_array[$key] + $item_teet_temporary_array[$key] + $item_facebook_shares_temporary_array[$key] + $item_facebook_comments_temporary_array[$key]);
}
$ii--;


	var_dump($press_array[$ii]);
	var_dump($press_array);

foreach($press_array as $key => $value) {
	// 新しい数値が大きい場合更新
	if($press_array[$key]["old_social_value"] < $press_array[$key]["social_value"]) {
		$query = DB::query("UPDATE press
								SET 
									hatena_social_value   = ".$press_array[$key]["hatena"].", 
									twitter_social_value  = ".$press_array[$key]["tweet"].", 
									facebook_social_value = ".($press_array[$key]["facebook_shares"] + $press_array[$key]["facebook_comments"]).", 
									social_value = ".$press_array[$key]["social_value"]."
								WHERE 
									primary_id = ".$press_array[$key]["primary_id"]."
								LIMIT 1")->execute();
//		mysql_query($query);
	} // if($press_array[$key]["old_social_value"] < $press_array[$key]["social_value"]) {
} // foreach($press_array as $key => $value) {


var_dump($press_array[$ii]["facebook_shares"]);

	// 正常に機能したかどうかを記録
	if($press_array[$ii]["facebook_shares"] == NULL) {
		$judgment = 'FALSE';
		$query = DB::query("INSERT INTO cron_patrol (
								judgment)
							VALUE (
								'".$judgment."')")->execute();
	}
		else {
			$judgment = 'TRUE';
			$query = DB::query("INSERT INTO cron_patrol (
									judgment)
								VALUE (
									'".$judgment."')")->execute();
		}
	}
}
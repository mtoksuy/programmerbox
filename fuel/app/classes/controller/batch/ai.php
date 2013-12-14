<?php 
/**
 * バッチコントローラー
 * 
 * このバッチはDBに入っているpressの中身からシングルクォーテンションの削除し、画像のrscを変更する。
 * 
 * 
 */


class Controller_Batch_Ai extends Controller {
	public function action_index() {
		$match_array = array();
		$image_extension_array = array(
			'jpg',
			'jpeg',
			'png',
			'gif',
		);
/*
$ai = 
'<img class="o_8 m_b_30" width="150" height="75" src="../img/common/code_box_download_1.jpg">
<img class="o_8 m_b_30" width="150" height="75" src="../img/common/code_box_download_1.png">
<img class="o_8 m_b_30" width="150" height="75" src="../img/common/code_box_download_1.gif">
<img class="press_screen_shot_image o_8 m_0" height="400" title="" alt="" widht="640" src="../img/press/image/image_228.jpg">';

			foreach($image_extension_array as $extension_key => $extension_value) {
				$pattern        = '/(src=\"\.\.\/(img\/.*?\.'.$extension_value.')\")/';
				var_dump($pattern);
				$replacement    = 'src="../assets/$2"';
				$ai = preg_replace($pattern, $replacement, $ai);
			}
			echo $ai;
*/



		$query = DB::query("
			SELECT *
			FROM press")->execute();
//			var_dump($query);
		// ぶん回す
		foreach($query as $key => $value) {
//			var_dump($value["press"]);
//			var_dump($value["primary_id"]);
			// 置換行為
			foreach($image_extension_array as $extension_key => $extension_value) {
				$pattern        = '/(src=\"\.\.\/(img\/.*?\.'.$extension_value.')\")/';
//				var_dump($pattern);
				$replacement    = 'src="../assets/$2"';
				$value["press"] = preg_replace($pattern, $replacement, $value["press"]);
			}
				// シングルクォーテンションを置換する
				$value["press"] = preg_replace("/\'/", "&apos;", $value["press"]);
//			echo $value["press"];
				DB::query("
					UPDATE press 
					SET    press = '".$value["press"]."'
					WHERE  primary_id = ".$value["primary_id"]."")->execute();

//var_dump($query);



















//<img class="o_8 m_b_30" width="150" height="75" src="../img/common/code_box_download_1.png">

/*
原本
$pattern     = '/(src=\"\.\.\/(img\/press\/image.*?\.jpg)\")/';
$replacement = 'src="../assets/$2"';
echo preg_replace($pattern, $replacement, $value["press"]);
*?


/*
			preg_match_all('(src=\".*?\.jpg\"|src=\".*?\.jpeg\"|src=\".*?\.png\"|src=\".*?\.gif\")', $value["press"], $match_array);
//			preg_match('(jpg)', 'ai', $match_array);
//			var_dump($match_array);
			foreach($match_array[0] as $key=>$value) {
				var_dump($value);
//				var_dump($key);
$string = 'April 15, 2003';
$pattern = '/(\w+) (\d+), (\d+)/i';
$pattern = '(src)';
$replacement = '';
echo preg_replace($pattern, $replacement, $value);
//echo preg_replace($pattern, $replacement, 'src="../img/press/image/image_1.jpg"');

			}
*/
		}
	}
}
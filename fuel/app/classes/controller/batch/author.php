<?php 
/**
 * バッチコントローラー
 * 
 * このバッチはDBに入っているpressの著者を変更する。
 * 
 * 
 */


class Controller_Batch_Author extends Controller {
	public function action_index() {
		$match_array = array();

		$query = DB::query("
			SELECT *
			FROM press")->execute();
//			var_dump($query);
		// ぶん回す
		foreach($query as $key => $value) {
//			var_dump($value["press"]);
			var_dump($value["primary_id"]);
			var_dump($value["programmerbox_id"]);


				DB::query("
					UPDATE press 
					SET    programmerbox_id = 'mtoksuy'
					WHERE  primary_id = ".$value["primary_id"]."")->execute();
		}
	}
}
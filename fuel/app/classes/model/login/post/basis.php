<?php 
class Model_Login_Post_Basis extends Model {
	//--------
	//記事作成
	//--------
	public static function article_create($post) {
		// 変数群
		$programmerbox_id = $_SESSION["programmerbox_id"];
		$category         = $post["category"];
		$title            = $post["title"];
		$path             = $post["path"];
		$press            = $post["press"];
		$press            = htmlspecialchars_decode($post["press"], ENT_COMPAT);
		// 削除array
		$del_r_array = array("'");
		// 不要文字置換
		$press            = str_replace($del_r_array, '"', $press);
		$tag              = $post["tag"];
		$thumbnail_imeg   = $_FILES["file"];
		$now_time         = time();
		$now_date         = date('Y-m-d', $now_time);
		$press_year_time  = date('Y', $now_time);
		// 記事のパス
		$link = ($now_date.'_'.$path);
/*
		// カテゴリー情報取得
		$category_info_array = Model_Info_Basis::category_info_get($category);
		// サムネイル作成
		$image_path = Model_Login_Post_Basis::thumbnail_create($link, $press_year_time);
		// 記事登録
		DB::query("INSERT INTO press (
								programmerbox_id ,
								category ,
								sub_category ,
								title ,
								press ,
								tag ,
								thumbnail_image ,
								link ,
								creation_time ,
								update_time
							)
							VALUES (
								'".$programmerbox_id."',
								'".$category_info_array["parent_name"]."',
								'".$category_info_array["category_name"]."',
								'".$title."',
								'".$press."',
								'".$tag."',
								'".$image_path."',
								'".$link."',
								'".$now_time."', 
								'".$now_time."')")->execute();
		// rss作成
		Model_Login_Post_Basis::rss_create();
*/
	}
	//--------------
	//サムネイル作成
	//--------------
	public static function thumbnail_create($link, $press_year_time) {
		// サムネイル画像登録
		if($_FILES["file"]["error"] == 4) {
//			print "なし";
		}
			// ファイルがあれば
			else if($_FILES["file"]["error"] == 0) {
				// イメージ画像変数
				$icon_image = $_FILES["file"];
				// ファイル拡張子
				$type_str = str_replace("image/", "", $icon_image["type"], $count);
//				var_dump($type_str);
//				var_dump($count);
//				var_dump($icon_image["type"]);

				// 拡張子設定
				switch($type_str) {
					case 'jpeg':
						$extension = '.jpg';
					break;
					case 'gif':
						$extension = '.gif';
					break;
					case 'png':
						$extension = '.png';
					break;
					default:
						$extension = '.';
					break;
				}
				// パス設定
				$image_path    = $link.$extension;
				$image_2x_path = $link.'@2x'.$extension;
//				var_dump($image_path.$image_2x_path);

			//-------------------------------------------
			// アップロード工程(イメージ画像であれば登録)
			//-------------------------------------------
			if (is_uploaded_file($icon_image["tmp_name"]) && $extension == ".jpg" or 
						$extension == ".gif" or $extension == ".png") {
				// ディレクトリを作る場所
				$year_dir         = (PATH.'assets/img/press/'.$press_year_time."/");
				$detail_dir       = (PATH.'assets/img/press/'.$press_year_time."/detail/");
				$original_dir     = (PATH.'assets/img/press/'.$press_year_time."/original/");
				$square_dir       = (PATH.'assets/img/press/'.$press_year_time."/square/");
				$square_200px_dir = (PATH.'assets/img/press/'.$press_year_time."/square_200px/");
				$square_120px_dir  = (PATH.'assets/img/press/'.$press_year_time."/square_120px/");
				$thumbnail_dir    = (PATH.'assets/img/press/'.$press_year_time."/thumbnail/");
//				var_dump($year_dir);
				// ディレクトリが存在するかチェックし、なければ作成
				if(!is_dir($year_dir)) {
					// 必要らしい
					umask(0);
					// ディレクトリ作成
					$rc   = mkdir($year_dir, 0777);
					$rc   = mkdir($detail_dir, 0777);
					$rc   = mkdir($original_dir, 0777);
					$rc   = mkdir($square_dir, 0777);
					$rc   = mkdir($square_200px_dir, 0777);
					$rc   = mkdir($square_120px_dir, 0777);
					$rc   = mkdir($thumbnail_dir, 0777);
				}
				// 原本ファイルUP
				if (move_uploaded_file($icon_image["tmp_name"], $year_dir.'original/'.$image_path)) {
					// パーミッション変更
					chmod($year_dir.'original/'.$image_path, 0644);

/******************************************サムネイルイメージ作成*******************************************/

					// コピー元画像の指定
					$targetImage = ($year_dir.'original/'.$image_path);
					// ファイル名から、画像インスタンスを生成
					switch ($type_str) {
						case 'jpeg':
							$image = imagecreatefromjpeg($targetImage);
						break;
						case 'gif':
							$image = imagecreatefromgif($targetImage);
						break;
						case 'png':
							$image = imagecreatefrompng($targetImage);
						break;
						default:
							
						break;
					}
					// コピー元画像のファイルサイズを取得
					list($image_w, $image_h) = getimagesize($targetImage);
					// 比率取得
					// 横幅の方が大きい場合
					if($image_w > $image_h) {
						$i           = $image_h / $image_w;
						$ii_1        = 1280 * $i;
						$ii_2        = 640  * $i;
						$ll_1        = 520  * $i;
						$ll_2        = 260  * $i;
						$square_size = $image_h;
						$image_s_w   = ($image_w - $image_h) / 2;
						$image_s_h   = 0;
					}
						// 縦幅の方が大きい場合
						else if($image_w < $image_h) {
							$i           = $image_h / $image_w;
							$ii_1        = 1280 * $i;
							$ii_2        = 640  * $i;
							$ll_1        = 520  * $i;
							$ll_2        = 260  * $i;
							$square_size = $image_w;
							$image_s_w   = 0;
							$image_s_h   = ($image_h - $image_w) / 2;
						}
							// 同じ大きさの場合
							else {
								$i           = $image_h / $image_w;
								$ii_1        = 1280 * $i;
								$ii_2        = 640  * $i;
								$ll_1        = 520  * $i;
								$ll_2        = 260  * $i;
								$square_size = $image_w;
								$image_s_w = 0;
								$image_s_h = 0;
							}
						//------
						//1280px
						//------
						// サイズを指定して、背景用画像を生成
						$width  = 1280;
						$height = $ii_1;
						$canvas = imagecreatetruecolor($width, $height);
					imagecopyresampled($canvas,  // 背景画像
					                   $image,   // コピー元画像
					                   0,        // 背景画像の x 座標
					                   0,        // 背景画像の y 座標
					                   0,        // コピー元の x 座標
					                   0,        // コピー元の y 座標
					                   $width,   // 背景画像の幅
					                   $height,  // 背景画像の高さ
					                   $image_w, // コピー元画像ファイルの幅
					                   $image_h  // コピー元画像ファイルの高さ
					                  );
							// 画像ファイル作成
							switch ($type_str) {
								case 'jpeg':
									imagejpeg($canvas, $year_dir.'detail/'.$image_2x_path, 96);
								break;
								case 'gif':
									imagegif($canvas, $year_dir.'detail/'.$image_2x_path);
								break;
								case 'png':
									imagepng($canvas, $year_dir.'detail/'.$image_2x_path, 0);
								break;
								default:
								break;
							}
						//-----
						//640px
						//-----
						// サイズを指定して、背景用画像を生成
						$width  = 640;
						$height = $ii_2;
						$canvas = imagecreatetruecolor($width, $height);
					imagecopyresampled($canvas,  // 背景画像
					                   $image,   // コピー元画像
					                   0,        // 背景画像の x 座標
					                   0,        // 背景画像の y 座標
					                   0,        // コピー元の x 座標
					                   0,        // コピー元の y 座標
					                   $width,   // 背景画像の幅
					                   $height,  // 背景画像の高さ
					                   $image_w, // コピー元画像ファイルの幅
					                   $image_h  // コピー元画像ファイルの高さ
					                  );
							// 画像ファイル作成
							switch ($type_str) {
								case 'jpeg':
									imagejpeg($canvas, $year_dir.'detail/'.$image_path, 98);
								break;
								case 'gif':
									imagegif($canvas, $year_dir.'detail/'.$image_path);
								break;
								case 'png':
									imagepng($canvas, $year_dir.'detail/'.$image_path, 0);
								break;
								default:
								break;
							}
						//-----
						//520px
						//-----
						// サイズを指定して、背景用画像を生成
						$width  = 520;
						$height = $ll_1;
						$canvas = imagecreatetruecolor($width, $height);
					imagecopyresampled($canvas,  // 背景画像
					                   $image,   // コピー元画像
					                   0,        // 背景画像の x 座標
					                   0,        // 背景画像の y 座標
					                   0,        // コピー元の x 座標
					                   0,        // コピー元の y 座標
					                   $width,   // 背景画像の幅
					                   $height,  // 背景画像の高さ
					                   $image_w, // コピー元画像ファイルの幅
					                   $image_h  // コピー元画像ファイルの高さ
					                  );
							// 画像ファイル作成
							switch ($type_str) {
								case 'jpeg':
									imagejpeg($canvas, $year_dir.'thumbnail/'.$image_2x_path, 100);
								break;
								case 'gif':
									imagegif($canvas, $year_dir.'thumbnail/'.$image_2x_path);
								break;
								case 'png':
									imagepng($canvas, $year_dir.'thumbnail/'.$image_2x_path, 0);
								break;
								default:
								break;
							}
						//-----
						//260px
						//-----
						// サイズを指定して、背景用画像を生成
						$width  = 260;
						$height = $ll_2;
						$canvas = imagecreatetruecolor($width, $height);
					imagecopyresampled($canvas,  // 背景画像
					                   $image,   // コピー元画像
					                   0,        // 背景画像の x 座標
					                   0,        // 背景画像の y 座標
					                   0,        // コピー元の x 座標
					                   0,        // コピー元の y 座標
					                   $width,   // 背景画像の幅
					                   $height,  // 背景画像の高さ
					                   $image_w, // コピー元画像ファイルの幅
					                   $image_h  // コピー元画像ファイルの高さ
					                  );
							// 画像ファイル作成
							switch ($type_str) {
								case 'jpeg':
									imagejpeg($canvas, $year_dir.'thumbnail/'.$image_path, 100);
								break;
								case 'gif':
									imagegif($canvas, $year_dir.'thumbnail/'.$image_path);
								break;
								case 'png':
									imagepng($canvas, $year_dir.'thumbnail/'.$image_path, 0);
								break;
								default:
								break;
							}
						//----------------
						//サムネイル正方形
						//----------------
						// サイズを指定して、背景用画像を生成
						$width  = $square_size;
						$height = $square_size;
						$canvas = imagecreatetruecolor($width, $height);
					imagecopy(
								$canvas,         // コピー先のリンクソース
								$image,          // コピー元の画像リンクソース
								0,               // コピー先のx座標
								0,               // コピー先のy座標
								$image_s_w,      // コピー元のx座標 横
								$image_s_h,      // コピー元のy座標 縦
								$image_w,        // コピー元の幅
								$image_h         // コピー元の高さ
												);
							// 画像ファイル作成
							switch ($type_str) {
								case 'jpeg':
									imagejpeg($canvas, $year_dir.'square/'.$image_path, 100);
								break;
								case 'gif':
									imagegif($canvas, $year_dir.'square/'.$image_path);
								break;
								case 'png':
									imagepng($canvas, $year_dir.'square/'.$image_path, 0);
								break;
								default:
								break;
							}
							//------------------------------------------------
							//正方形の画像作成の為もう一度画像インスタンス生成
							//------------------------------------------------
							// コピー元画像の指定
							$targetImage = ($year_dir.'square/'.$image_path);
							// ファイル名から、画像インスタンスを生成
							switch ($type_str) {
								case 'jpeg':
									$image = imagecreatefromjpeg($targetImage);
								break;
								case 'gif':
									$image = imagecreatefromgif($targetImage);
								break;
								case 'png':
									$image = imagecreatefrompng($targetImage);
								break;
								default:
									
								break;
							}
							// コピー元画像のファイルサイズを取得
							list($image_w, $image_h) = getimagesize($targetImage);
							//-----------
							//200px正方形
							//-----------
							// サイズを指定して、背景用画像を生成
							$width  = 200;
							$height = 200;
							$canvas = imagecreatetruecolor($width, $height);
					imagecopyresampled($canvas,  // 背景画像
					                   $image,   // コピー元画像
					                   0,        // 背景画像の x 座標
					                   0,        // 背景画像の y 座標
					                   0,        // コピー元の x 座標
					                   0,        // コピー元の y 座標
					                   $width,   // 背景画像の幅
					                   $height,  // 背景画像の高さ
					                   $image_w, // コピー元画像ファイルの幅
					                   $image_h  // コピー元画像ファイルの高さ
					                  );
								// 画像ファイル作成
								switch ($type_str) {
									case 'jpeg':
										imagejpeg($canvas, $year_dir.'square_200px/'.$image_path, 100);
									break;
									case 'gif':
										imagegif($canvas, $year_dir.'square_200px/'.$image_path);
									break;
									case 'png':
										imagepng($canvas, $year_dir.'square_200px/'.$image_path, 0);
									break;
									default:
									break;
								}
							//-----------
							//120px正方形
							//-----------
							// サイズを指定して、背景用画像を生成
							$width  = 120;
							$height = 120;
							$canvas = imagecreatetruecolor($width, $height);
					imagecopyresampled($canvas,  // 背景画像
					                   $image,   // コピー元画像
					                   0,        // 背景画像の x 座標
					                   0,        // 背景画像の y 座標
					                   0,        // コピー元の x 座標
					                   0,        // コピー元の y 座標
					                   $width,   // 背景画像の幅
					                   $height,  // 背景画像の高さ
					                   $image_w, // コピー元画像ファイルの幅
					                   $image_h  // コピー元画像ファイルの高さ
					                  );
								// 画像ファイル作成
								switch ($type_str) {
									case 'jpeg':
										imagejpeg($canvas, $year_dir.'square_120px/'.$image_path, 100);
									break;
									case 'gif':
										imagegif($canvas, $year_dir.'square_120px/'.$image_path);
									break;
									case 'png':
										imagepng($canvas, $year_dir.'square_120px/'.$image_path, 0);
									break;
									default:
									break;
								}
							// メモリ開放
							imagedestroy($canvas);
				}
			}
		}
		return $image_path;
	} // public static function thumbnail_create($thumbnail_imeg) {
	//-------
	//rss作成
	//-------
	public static function rss_create() {
		// RSS自動作成
		$res = DB::query("
			SELECT * 
			FROM press
			WHERE del = 0
			ORDER BY press.primary_id DESC
			LIMIT 0, 10")->execute();
		// rssヘッダーダグ
		$rss_start = ('<?xml version="1.0" encoding="UTF-8"?>
		<rss xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:wfw="http://wellformedweb.org/CommentAPI/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:sy="http://purl.org/rss/1.0/modules/syndication/" xmlns:slash="http://purl.org/rss/1.0/modules/slash/" version="2.0">
		<channel>
		<title>'.TITLE.'</title>
		<atom:link href="'.HTTP.'feed.xml" rel="self" type="application/rss+xml"/>
		<link>'.HTTP.'</link>
		<description>
		<![CDATA[
		プログラマーボックスはITニュースをお届けしながら主にPHP,CSS3,JavaScriptのコードを箱に詰め込み、あなたにお届けするブログです。
		]]>
		</description>
		<language>ja</language>
		<copyright>Copyright 2013</copyright>
		
		<generator uri="'.HTTP.'">'.TITLE.'</generator>
		
		<sy:updatePeriod>hourly</sy:updatePeriod>
		<sy:updateFrequency>1</sy:updateFrequency>
		<lastBuildDate>'.date(r).'</lastBuildDate>');
		foreach($res as $key => $value) {
			// タグを消す
			$value["press_168"] = str_replace(array('<br>', '<p>', '<p class="m_0">', '</p>'), '', $value["press"]);
			// 本文を168文字に丸める
			$strimwidth_press = mb_strimwidth($value["press_168"], 0, 168, "...", 'utf8');
			var_dump($strimwidth_press);
			// item生成
			$item .= ('<item>
			<title>'.$value["title"].'</title>
			<link>
			'.HTTP.$value["link"].'/
			</link>
			<description>
			<![CDATA[
			'.$strimwidth_press.'
			]]>
			</description>
			<content:encoded>
			<![CDATA[
			'.$value["press"].'
			]]>
			</content:encoded>
			<guid>
			'.HTTP.$value["link"].'/
			</guid>
			<pubDate>'.date('r', $value["creation_time"]).'</pubDate>
			</item>
			');
		} // foreach($res as $key => $value) {
		// rss終了タグ
		$rss_end = ('</channel>
		</rss>');
		// rss結合
		$rss = $rss_start.$item.$rss_end;
		// 改行コードをLFに置換
		$rss = str_replace(array("\r\n","\r"), "\n", $rss);
		// 書き直すファイルパス
		$file = PATH.'feed.xml';
		// ファイルのデータ取得
		//							$current = file_get_contents($file);
		// rssデータをファイルに書き出す
		file_put_contents($file, $rss);
	}

} // class Model_Login_Post_Basis extends Model {
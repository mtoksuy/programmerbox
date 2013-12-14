/*************************
デバッグ変数コンストラクタ
*************************/
/*
var print    = console.log;
var var_dump = console.dir;
var trace    = console.trace;
var time     = console.time;
var count    = console.count;
*/
$(function() {
	//------------------------
	//Retinaなら画像差し替える
	//------------------------
	// ディスプレイ環境を調べる
//	if(window.devicePixelRatio > 1) {
		// articleを探す(トップ)
		$('.home_press_thumbnail').each(function() {
			// src取得
			var src = $(this).attr('src');
			// Retina用画像に置換
			$(this).attr('src', src.replace(/(\.jpg|\.png)/gi,'@2x$1'));
		});

		// articleを探す(詳細)
		$('.detail_press_thumbnail').each(function() {
			// src取得
			var src = $(this).attr('src');
			// Retina用画像に置換
			$(this).attr('src', src.replace(/(\.jpg|\.png)/gi,'@2x$1'));
		});

		// code_box_ad_contentsを探す
		$('.code_box_ad_contents').each(function() {
			// src取得
			var src = $(this).attr('src');
			// Retina用画像に置換
			$(this).attr('src', src.replace(/(\.jpg|\.png)/gi,'@2x$1'));
		});
//	}
});





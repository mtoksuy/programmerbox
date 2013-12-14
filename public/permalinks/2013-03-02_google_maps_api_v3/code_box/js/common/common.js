// 変数群
var map,svp;
//--------
//初期設定
//--------
function initialize() {
	// 緯度・経度変数
	var latlng = new google.maps.LatLng(35.674144,139.77675999999997);
	// 地図のオプション設定変数
	var myOptions = {
		// カメラの向き
		heading: -20,
		// 初期のズーム レベル
		zoom: 16,
		// 地図の中心点
		center:latlng,
		// 地図タイプ
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	//地図オブジェクト生成
	map = new google.maps.Map(document.getElementById('map'), myOptions);
	// ストリートビューオブジェクト生成
	svp = new google.maps.StreetViewPanorama(
		document.getElementById('svp'),{
			position : map.getCenter()
		});
	// ストリートビューオブジェクト詳細設定
	svp.setPov({heading: -20, pitch: 0, zoom: 0});
	// マップとストリートビューの一致させる為の記述
	map.setStreetView(svp);
	// 緯度・経度確認
	google.maps.event.addListener(svp, 'tilesloaded', review);
	google.maps.event.addListener(svp, 'position_changed', review);
} // initialize() {
/***********  固定設定終了 ***********/
		// 回転関数
		function rotate() {
			// カメラの位置取得
			var pov      = svp.getPov();
			var _heading = pov['heading'];
			var _pitch   = pov['pitch'];
			var _zoom    = pov['zoom'];
			// 位置をずらす
			_heading     = _heading + 0.1;
			// 位置情報をセット(一番大事)
			svp.setPov( {
				heading:_heading, pitch:_pitch, zoom:_zoom
			});
		}
		// レビュー関数
		function review() {
			if(document.getElementById("res")) {
				document.getElementById("res").innerHTML = svp.getPosition();
			}
		}
		//------------------------------
		//ロード時に初期化(スタートです)
		//------------------------------
		google.maps.event.addDomListener(window, 'load', initialize);


		//--------------------
		//マウスやアクション系
		//--------------------
		$(function() {
			// 変数宣言
			var flag = 0;
			var latlng_array;
			var svp_area = document.getElementById('svp_area');
				// 回転くるくる
				timerID = setInterval('rotate()',20);
			//------------------------------
			//svp_areaにマウスオーバーしたら
			//------------------------------
			$('#svp_area').mouseover(function() {
				// くるくる解除
				clearInterval(timerID);
			});
			//----------------------------
			//svp_areaにマウスアウトしたら
			//----------------------------
			$('#svp_area').mouseout(function() {
				// くるくる再スタート
				timerID = setInterval('rotate()',20);
			});
			//-----------------
			// 左の矢印クリック
			//-----------------
			$('.y_l_btn').click(function() {
				var left_px     = ($('.slide_show_contents ul').css('left'));
				left_px         = left_px.replace('px','');
				left_px         = parseInt(left_px);
				var image       = $('.slide_show_contents ul li img');
				var image_widht = image[0].width;
				if(flag == 0) {
					var first_li = $('.slide_show_contents ul li').eq(7);
					$('.slide_show_contents ul').prepend(first_li);
					$('.slide_show_contents ul').css({'left': -(image_widht + 10) + 'px'});
					$('.slide_show_contents ul').animate({left: 0 + 'px'} ,500,'swing',function() {
						flag = 0;
					});
					flag = 1;
				}
					else {
					}
			}); // $('.y_l_btn').click(function() {
			//-----------------
			// 右の矢印クリック
			//-----------------
			$('.y_r_btn').click(function() {
				var left_px     = ($('.slide_show_contents ul').css('left'));
				left_px         = left_px.replace('px','');
				left_px         = parseInt(left_px);
				if(isNaN(left_px)) { left_px = 0;}
				var image       = $('.slide_show_contents ul li img');
				var image_widht = image[0].width;
				if(flag == 0) {
					$('.slide_show_contents ul').animate({left: left_px + -(image_widht + 10) + 'px'} ,500,'swing',function() {
						var first_li = $('.slide_show_contents ul li').eq(0);
						$('.slide_show_contents ul').append(first_li);
						$('.slide_show_contents ul').css({'left': left_px + 'px'});
						flag = 0;
					});
					flag = 1;
				}
					else {
					}
			}); // $('.y_l_btn').click(function() {
			//--------------
			//データセット系
			//--------------
			var id = 0;
			var latlng_i_array  = $([
				35.674144,
				35.691918,
				35.659298,
				35.698162,
				35.731098,
				35.671594,
				35.703601,
				35.588408]);
			var latlng_k_array  = $ ([
				139.77675999999997,
				139.701012,
				139.70043899999996,
				139.772443,
				139.710069,
				139.703004,
				139.57984999999996,
				139.727355]);
//35.674144, 139.77675999999997 八丁堀駅
//35.691918, 139.701012         新宿駅
//35.659298, 139.70043899999996 渋谷駅
//35.698162,139.772443          秋葉原駅
//35.731098,139.710069          池袋駅
//35.671594,139.703004          原宿駅
//35.703601, 139.57984999999996 吉祥寺駅
//35.588408,139.727355          大森駅
			var text_area_array = $(['<h3>八丁堀駅</h3><p>八丁堀駅（はっちょうぼりえき）は、東京都中央区八丁堀にある、東京地下鉄（東京メトロ）・東日本旅客鉄道（JR東日本）の駅である。</p>','<h3>新宿駅</h3><p>新宿駅（しんじゅくえき）は、東京都新宿区・渋谷区にある、東日本旅客鉄道（JR東日本）・京王電鉄・小田急電鉄・東京地下鉄（東京メトロ）・東京都交通局（都営地下鉄）の駅である。</p>','<h3>渋谷駅</h3><p>渋谷駅（しぶやえき）は、東京都渋谷区にある、東日本旅客鉄道（JR東日本）・東京急行電鉄（東急）・東京地下鉄（東京メトロ）・京王電鉄の駅である。</p>','<h3>秋葉原駅</h3><p>秋葉原駅（あきはばらえき）は、東京都千代田区にある、東日本旅客鉄道（JR東日本）・東京地下鉄（東京メトロ）・首都圏新都市鉄道の駅である。</p>','<h3>池袋駅</h3><p>池袋駅（いけぶくろえき）は、東京都豊島区にある、東日本旅客鉄道（JR東日本）・東武鉄道（東武）・西武鉄道（西武）・東京地下鉄（東京メトロ）の駅である。</p>','<h3>原宿駅</h3><p>原宿駅（はらじゅくえき）は、東京都渋谷区神宮前一丁目にある、東日本旅客鉄道（JR東日本）山手線の鉄道駅である。</p>','<h3>吉祥寺駅</h3><p>良い町です</p>','<h3>大森駅</h3><p>大森駅 (東京都) - 東京都大田区にある東日本旅客鉄道（JR東日本）京浜東北線（東海道本線）の駅。</p>']);

			$('.slide_show_contents ul li').each(function() {
				$(this).data('id',id);
				id += 1;
			});
			//------------
			//画面きりかえ
			//------------
			$('.slide_show_contents ul li').click(function() {
				var id = $(this).data('id');
				svp.setPosition(new google.maps.LatLng(latlng_i_array[id], latlng_k_array[id]));
				map.panTo(new google.maps.LatLng(latlng_i_array[id], latlng_k_array[id]));
				$('#text_area').html(text_area_array[id]);
			});
		}); // $(function() {
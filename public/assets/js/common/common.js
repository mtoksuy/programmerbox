/*************************
デバッグ変数コンストラクタ
*************************/
/*
var p        = console.log;
var print    = console.log;
var var_dump = console.dir;
var trace    = console.trace;
var time     = console.time;
var count    = console.count;
*/
/*************
グローバル変数
*************/
	if(navigator.userAgent.indexOf("Opera") != -1) { // 文字列に「Opera」が含まれている場合
		var user_browser = 'Opera';
	}
		else if(navigator.userAgent.indexOf("MSIE") != -1) { // 文字列に「MSIE」が含まれている場合
			var user_browser = 'MSIE';
	;	}
			else if(navigator.userAgent.indexOf("Firefox") != -1) { // 文字列に「Firefox」が含まれている場合
				var user_browser = 'Firefox';
			}
				else if (navigator.userAgent.indexOf('Chrome') != -1) { // 文字列に「Chrome」が含まれている場合
					var user_browser = 'Chrome';
				}
					else if(navigator.userAgent.indexOf("Netscape") != -1) { // 文字列に「Netscape」が含まれている場合
						var user_browser = 'Natscape';
					}
						else if(navigator.userAgent.indexOf("Safari") != -1) { // 文字列に「Safari」が含まれている場合
							var user_browser = 'Safari';
						}
							else {
								var user_browser = '';
							}
/***********
http切り替え
***********/
if (location.host == 'localhost') {
	var http = 'http://localhost/programmerbox/';
}
	else if (location.host == 'programmerbox.com') {
		var http = 'http://programmerbox.com/';
	}
		else if (location.host == 'www.programmerbox.com/') {
			var http = 'http://programmerbox.com/';
		}
//------------------------------------
//FBプラグインブラウザ毎の違いを埋める
//------------------------------------
	switch(user_browser) {
		case 'Opera':
			$('.face_book_plgin').css( {
				backgroundColor: '#FFFFFF'
			});
		break;
		case 'MSIE':

		break;
		case 'Firefox':

		break;
		case 'Chrome':

		break;
		case 'Netscape':

		break;
		case 'Safari':
			$('.face_book_plgin').css( {
				backgroundColor: '#FFFFFF'
			});
		break;
		default :

		break;
	}
//--------------------------------
//ヘッダーナビがクリックされた場合
//-------------------------------
/*

$('.header_nav li').click(function() {
	print (this);
		$(this).animate({ top: '5px' }, '50');

	$(this).css({
		top: "5px"
		});

});
*/
/*
	$(function() {
print ($('.pluginBoxContainer'));
$('.pluginBoxContainer').css( {
	backgroundColor: '#fcfcfc'
});
})
*/

	//----------------
	//読み込み後の処理
	//----------------
	$(function() {
		//-------------------
		//記事 目次スクロール
		//-------------------
		$('.index_scroll a').click(function() {
			var hash        = $(this)[0].hash;
			hash            = hash.replace("#", "s_");
			var hash_offset = $('#' + hash).offset();
			$('html,body').animate({scrollTop: hash_offset.top},1000);
		});
		// スクロールアニメーション(左目次)
		$('.left a').click(function() {
			var hash        = $(this)[0].hash;
			hash            = hash.replace("#", "s_");
			var hash_offset = $('#' + hash).offset();
			$('html,body').animate({scrollTop: hash_offset.top},1000);
		});
		// スクロールアニメーション(右目次)
		$('.right a').click(function() {
			var hash        = $(this)[0].hash;
			hash            = hash.replace("#", "s_");
			var hash_offset = $('#' + hash).offset();
			$('html,body').animate({scrollTop: hash_offset.top},1000);
		});
	//-------------------------------------------------------
	//全ページトップでトップにスクロールするボタン表示 非表示
	//-------------------------------------------------------
 $(window).scroll(function() {
	 if($(window).width() > 1080 && $(this).scrollTop() > 800) {
			$('.scroll_top').fadeIn();
	 }
	 		else {
				$('.scroll_top').fadeOut();
	 		}
 });
	//----------------------------------------------------
	//全ページトップでトップにスクロールするボタンクリック
	//----------------------------------------------------
	$('.scroll_top').click(function() {
		$('html, body').animate({
			scrollTop: 0
		}, 1000);
	});
	//-------------------------------------------
	//記事で目次にスクロールするボタン表示 非表示
	//-------------------------------------------
 $(window).scroll(function() {
	 if($(window).width() > 1080 && $(this).scrollTop() > 800) {
			$('.scroll_index').fadeIn();
	 }
	 		else {
				$('.scroll_index').fadeOut();
	 		}
 });
	//----------------------------------------
	//記事で目次にスクロールするボタンクリック
	//----------------------------------------
	$('.scroll_index').click(function() {
		var detail_press_index_offset = $('.detail_press_index').offset();
		$('html, body').animate({
			scrollTop: detail_press_index_offset.top
		}, 1000);
	});











	//----------------
	//中の人のつぶやき
	//----------------
	setTimeout(function() {
//		$('.comment_box').css('opacity','1');
		$('.comment_box').animate({opacity: '1'}, 800);
		$('.comment_box_contents').animate({marginTop: '34px'}, 1500, 'swing');
//	$('#user_contents_data_overflow_cover_bottom').animate({marginLeft:'' + (margin_left_number + 200) + 'px'}, 800);
	}, 5000);
	//--------------------
	//中の人のつぶやき変更
	//--------------------
	var default_text = $('.comment_box_comment').text();
	var over_text    = $('#ota_after').attr('value');

	$('.comment_box_img img').mouseover(function() {
		$('.comment_box_comment').animate({opacity: 0}, 200, function() {
			$('.comment_box_comment').text(over_text);
			$('.comment_box_comment').animate({opacity: 1}, 200);
		});
	});
	$('.comment_box_img img').mouseout(function() {
		$('.comment_box_comment').animate({opacity: 0}, 200, function() {
			$('.comment_box_comment').text(default_text);
			$('.comment_box_comment').animate({opacity: 1}, 200);
		});
	});
});
//--------------------
//新しい目次スクロール
//--------------------
$(function() {
	//ページ内スクロール
	$(".scroll_btn").click(function () {
		var i = $(".scroll_btn").index(this)
		var p = $(".heading").eq(i).offset().top;
		$('html,body').animate({ scrollTop: p }, 1000);
		return false;
	});
});
//------------------
//リサイズの時の参考
//------------------
/*
	$(window).resize(function() {
	    //ボックスサイズ
	    $("#modalbox").css({
	        top: ($(window).height() - $("#modalbox").outerHeight()) / 2,
	        left: ($(window).width() - $("#modalbox").outerWidth()) / 2
	    });
	});
*/

$(function() {
	//----------------
	//ツールチップ表示
	//----------------
	if($(window).width() > 768) {
		$('.about_nav ul li').mouseover(function() {
	/*
			var header_contents_width = $('.header_contents').width();
			var this_offset           = $(this).offset();
			var this_height           = $(this).height();
			var top_length            = (this_offset.top + this_height);
			var delta                 = ($(window).width() - header_contents_width);
			if(delta < 0) {
				delta = 0;
			}
	*/
	//		p(this_offset.left);
	//		var date = (15 + this_offset.left) - (delta / 2);
			switch($(this).find('img').attr('alt')) {
				case 'about_icon':
					var balloon_text = 'このサイトについて';
					var date = 169;
					var width_date = 60;
					var new_class = 'balloon_box_a';
				break;
				case 'facebook_icon':
					var balloon_text = 'Facebook';
					var date = 155;
					var width_date = 60;
					var new_class = 'balloon_box_f';
				break;
				case 'twitter_icon':
					var balloon_text = 'Twitter';
					var date = 121;
					var width_date = 40;
					var new_class = 'balloon_box_t';
				break;
				case 'google+_icon':
					var balloon_text = 'Google+';
					var date = 69;
					var width_date = 60;
					var new_class = 'balloon_box_g';
				break;
				case 'rss_icon':
					var balloon_text = 'RSS';
					var date = 39;
					var width_date = 26;
					var new_class = 'balloon_box_r';
				break;
				case 'contact_icon':
					var balloon_text = 'お問い合わせ';
					var date = -36;
					var width_date = 90;
					var new_class = 'balloon_box_c';
				break;
			}
	/*
			var balloon_box_width_half = ($('.balloon_box').width() / 2);
			p(date);
			date = date -balloon_box_width_half;
			p(date);
	*/
	//		$('.balloon_box').css('left', date + 'px', 'min-width', '100px');
			var balloon_box_width_half = ($('.balloon_box').width() / 2);
			$('.balloon_box').addClass(new_class);
			$('.balloon_box').html('<p>' + balloon_text + '</p>');
			$('.balloon_box').css({
				right:     date + 'px', 
				minWidth: width_date + 'px'});
			$('.balloon_box').fadeIn(10);
		});
	}
	//------------------
	//ツールチップ非表示
	//------------------
	$('.about_nav ul li').mouseout(function() {
		switch($(this).find('img').attr('alt')) {
			case 'about_icon':
				var new_class = 'balloon_box_a';
			break;
			case 'facebook_icon':
				var new_class = 'balloon_box_f';
			break;
			case 'twitter_icon':
				var new_class = 'balloon_box_t';
			break;
			case 'google+_icon':
				var new_class = 'balloon_box_g';
			break;
			case 'rss_icon':
				var new_class = 'balloon_box_r';
			break;
			case 'contact_icon':
				var new_class = 'balloon_box_c';
			break;
		}
		$('.balloon_box').css('display', 'none');
		$('.balloon_box').removeClass(new_class);
	});
	//----------------------------------
	//slideshareスライドレスポンシブ表示
	//----------------------------------
	if($('.slideshare')) {
		if($(window).width() <= 320) {
			$('.slideshare iframe').attr( {
				width: '100%',
				height: '234'});
		}
	}
	//-----------------------
	//youtubeレスポンシブ表示
	//-----------------------
	if($('.youtube')) {
		if($(window).width() <= 560) {			
			var w              = $('.detail_press').width();
			var y_w            = $('.youtube iframe').attr('width');
			var y_h            = $('.youtube iframe').attr('height');
			var ratio          = (y_h / y_w);
			var responsive_y_h = (ratio * w);
			// 変更
			$('.youtube iframe').attr( {
				width: '100%',
				height: responsive_y_h});
			// ウインドウがリサイズされたら
			$( window ).resize(function() {
				var w_r              = $('.detail_press').width();
				var responsive_y_h_r = (ratio * w_r);
				$('.youtube iframe').attr( {
					width: '100%',
					height: responsive_y_h_r});
			});
		}
	}


	//-------------
	//100万PV方程式
	//-------------
	//p($('#NewestPV'));
	$('#NewestPV').change(function() {
	//	p('変更');
	});
	$('#NewestPV').click(function() {
	//	p('クリック');
	});
	
	$('#NewestPV').keydown(function() {
	//	p('キーダウン');
	});
	
	$('#NewestPV').keypress(function() {
	//	p('キープレス');
	});
	$('#NewestPV').keyup(function() {
	//	p('キーアップ');
//		p($('#NewestPV').val());
		// 置換
		var NewestPV = $('#NewestPV').val().split(",").join("");
		// 数字であれば
		if(NewestPV.match(/^[1-9][0-9]*$/)) {
//			p('いんと');
			// 1日平均のPV書き換え
			var DayPV_1 = NewestPV / $('#Days').html();
			DayPV_1     = Math.floor(DayPV_1);
			$('#DayPV_1').html(DayPV_1);
			$('#DayPV_2').html(DayPV_1);

			// 現在の記事数があれば
			if($('#NumberArticles').val()) {
				var NumberArticles = $('#NumberArticles').val().split(",").join("");
				// アベレージ書き換え
				var Average_1 = $('#DayPV_2').html() / NumberArticles;
				Average_1     = Math.floor(Average_1);
				$('#Average_1').html(Average_1);
				$('#Average_2').html(Average_1);
				// 必要な記事数書き換え
				var ArticlesMinimum = 33333 / Average_1;
				ArticlesMinimum     = Math.floor(ArticlesMinimum);
				$('#ArticlesMinimum').html(ArticlesMinimum);
			}
		}
	});
	$('#NumberArticles').keyup(function() {
		// 置換
		var NumberArticles = $('#NumberArticles').val().split(",").join("");
		// 数字であれば
		if(NumberArticles.match(/^[1-9][0-9]*$/)) {
//			p($('#DayPV_2').html());
			// アベレージ書き換え
			var Average_1 = $('#DayPV_2').html() / NumberArticles;
			Average_1     = Math.floor(Average_1);
			$('#Average_1').html(Average_1);
			$('#Average_2').html(Average_1);
			// 必要な記事数書き換え
			var ArticlesMinimum = 33333 / Average_1;
			ArticlesMinimum     = Math.floor(ArticlesMinimum);
			$('#ArticlesMinimum').html(ArticlesMinimum);
		}
	});
});

//-------------------------------------------------------------------------
//canvas.jsを使い可視表示な場所にスクロールしたら自動読み込み(外部に出した)
//-------------------------------------------------------------------------
/*
$(function() {
	// デフォルト変数
	var chart_i   = 0;
	var chart_ii  = 0;
	canvas_object = [];
	// オブジェクト生成
	$('.canvas_chart').each(function() {
		canvas_object[chart_ii] = {id:$(this).attr('id'), key: 0};
		chart_ii++;
	});
	$(window).scroll(function() {
		$('.canvas_chart').each(function() {
			var this_canvas        = $(this);
			var this_canvas_offset = this_canvas.offset();
			var this_gnition_point = (this_canvas_offset.top - $(window).height());
			var this_emporary_id   = this_canvas.attr('id');
			var chart_check_id     = this_canvas.attr('chart_check');
			// 可視の場所に来たら
			if($(window).scrollTop() > this_gnition_point) {
				// まだチャートを表示していない場合
				if(chart_check_id != 'TRUE') {
					chart_i++;
					this_canvas.attr('chart_check', 'TRUE');
					this_canvas.attr('id', this_emporary_id + '_' + chart_i);
					// 外部チャート読み込み
					$('#' + this_emporary_id + '_' + chart_i).load(this_emporary_id + '.html', function() {
						$('#' + this_emporary_id).css('opacity','0');
						$('#' + this_emporary_id).animate({opacity: '1'}, 1500);
					}); // $('#' + this_emporary_id + '_' + chart_i).load(this_emporary_id + '.html', function() {
				} // if(f_id != 'TRUE') {
			} // if($(window).scrollTop() > this_gnition_point) {
		}); // $('.canvas_chart').each(function() {
	}); // $(window).scroll(function() {
}); // $(function() {

*/



/*
旧型

	$(window).scroll(function() {
		$('.canvas_chart').each(function() {
			var this_canvas        = $(this);
			var this_canvas_offset = this_canvas.offset();
			var this_gnition_point = (this_canvas_offset.top - $(window).height());
			var this_emporary_id   = this_canvas.attr('id');
			// 可視の場所に来たら
			if($(window).scrollTop() > this_gnition_point) {
				p("可視の場所");
				// 走査
				$.each(canvas_object, function(i, e) {
					p("走査");
					p(this);
					if(this_emporary_id == this.id) {
						if(this.key == 0) {
							p("oneと同義");
							this.key = 1;
							chart_i++;
	//						this_canvas.attr('class', '');
							this_canvas.attr('id', this_emporary_id + '_' + chart_i);
							$('#' + this_emporary_id + '_' + chart_i).load(this_emporary_id + '.html', function() {
								p(this);
								$('#' + this_emporary_id).css('opacity','0');
								$('#' + this_emporary_id).animate({opacity: '1'}, 1500);
							});
						} // if(this.key == 0) {
					}
//					p(this.id);
//					p(this.key);
					// oneと同義
				}); // $.each(canvas_object, function(i, e) {
			} // if($(window).scrollTop() > this_gnition_point) {
		}); // $('.canvas_chart').each(function() {
	}); // $(window).scroll(function() {
}); // $(function() {


*/



/*
これでもいい
for(var pname in canvas_object) {
//  p(canvas_object[pname]['id']);
}
*/



/*
//----------------
//ブラウザの大きさ
//----------------
$(window).width();
$(window).height();
//----------------------
//スクロールしている数値
//----------------------
$(window).scrollTop();
//------------
//一番底の数値
//------------
$('html').height()
*/










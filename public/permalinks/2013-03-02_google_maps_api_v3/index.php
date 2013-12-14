<?php 
//--------------
//クラス呼び出し
//--------------
require_once "../class/programmerbox.php";
require_once "../class/sql.php";
require_once "../class/header.php";
require_once "../class/press.php";
require_once "../class/footer.php";
require_once "../class/side_menu.php";
require_once "../require/common/basic_var.php";
//----------
//クラス生成
//----------
$sql       = new sql();
$header    = new header();
$press     = new press();
$footer    = new footer();
$side_menu = new side_menu();
//----------------
//データベース接続
//----------------
$sql->sql_conect();
//----------
//ビュー表示
//----------
$header->header_view($basic_var_array);
$press->$press_detail_view();
$side_menu->side_menu_view();
$footer->footer_view($fb_like_box_width);
?>
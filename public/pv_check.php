<?php
$article_pv     = 0;
$article_all_pv = 0;
$article_number = 0;
$article_up     = 3;
$year           = 365;
//$year = $year * 2;

while($year > 0) {
	$year--;
$article_number = $article_number + $article_up;
echo $article_number;
echo '<br>';
$article_pv = $article_number * 30;
$article_all_pv = $article_all_pv + $article_pv;
echo $article_all_pv;
echo '<br>';
echo '<br>';
}
?>

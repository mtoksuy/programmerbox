<?php 
class Model_Status extends Model {
	public static function find_body_by_username($username) {
		$data = array(
			array(
				'date'=>'2012/04/08',
				'body'=>'イースター島なう',
			),
			array(
				'date'=>'2012',
				'body'=>'花祭りなう',
			),
		);
//	$data = 'd';
	return $data;
	}
}
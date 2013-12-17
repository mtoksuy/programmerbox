<?php 
/**
 * ログインテンプレート
 * 
 * 
 * 
 * 
 */

class Controller_Login_Template extends Controller {
	public $login_template;

	public function __construct(\Request $request) {
		$this->request = $request;
	}

	public function before() {
		session_start();
		require APPPATH.'classes/library/autoload.php';
		require APPPATH.'classes/library/security/basis.php';
	}

	public function after($response) {
		if($response === null) {
			$response = $this->basic_template;
		}
		return parent::after($response);
	}
}
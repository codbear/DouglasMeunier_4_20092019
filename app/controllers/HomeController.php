<?php

class HomeController {

	public function execute($params) {
		$title = 'Un billet pour l\'Alaska';
		require_once('../app/views/index.php');
	}
}

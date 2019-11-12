<?php

namespace Codbear\Alaska\Controllers;

use Codbear\Alaska\Interfaces\ControllerInterface;

class HomeController extends Controller implements ControllerInterface {

	public function execute($params, $datas) {
		return $this->renderer->render('home');
	}
}

<?php

namespace Codbear\Alaska\Controllers\Dashboard;

use Codbear\Alaska\Controllers\ErrorsController;
use Codbear\Alaska\Models\UserModel;
use Codbear\Alaska\Services\Renderer\Renderer;

abstract class DashboardController 
{

	protected $renderer;

	public function __construct(Renderer $renderer)
	{
		$this->renderer = $renderer;

		switch ($_SESSION['role']) {
			case UserModel::ROLE_ADMIN:
				return;
				break;

			case UserModel::ROLE_SUBSCRIBER:
				ErrorsController::error403();
				break;

			default:
				ErrorsController::error401();
				break;
		}
		exit();
	}
}

<?php

namespace Codbear\Alaska\Controllers\Dashboard;

use Codbear\Alaska\Controllers\ErrorsController;
use Codbear\Alaska\Models\UserModel;

abstract class DashboardController
{

	public function __construct()
	{
		switch ($_SESSION['role']) {
			case UserModel::ROLE_ADMIN:
				return;
				break;

			case UserModel::ROLE_SUBSCRIBER:
				ErrorsController::error403();
				die;
				break;

			default:
				ErrorsController::error401();
				die;
				break;
		}
	}
}

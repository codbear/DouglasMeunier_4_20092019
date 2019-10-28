<?php

namespace Codbear\Alaska\Controllers\Dashboard;

use Codbear\Alaska\Controllers\ErrorsController;
use Codbear\Alaska\Models\UserModel;

class DashboardController
{

	public function __construct()
	{
		if ($_SESSION['role'] != UserModel::ROLE_ADMIN) {
			ErrorsController::error403();
			die;
		}
	}
}

<?php

namespace Codbear\Alaska\Controllers\Dashboard;

use Codbear\Alaska\Controllers\Controller;
use Codbear\Alaska\Models\UserModel;

abstract class DashboardController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		switch ($_SESSION['role']) {
			case UserModel::ROLE_ADMIN:
				return;
				break;

			case UserModel::ROLE_SUBSCRIBER:
				return $this->forbidden();
				break;

			default:
				return $this->unauthorized();
				break;
		}
	}
}

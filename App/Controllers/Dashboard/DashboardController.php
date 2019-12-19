<?php

namespace Codbear\Alaska\Controllers\Dashboard;

use Codbear\Alaska\Services\Session;
use Codbear\Alaska\Models\UsersModel;
use Codbear\Alaska\Controllers\Controller;

abstract class DashboardController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		switch (Session::get('user')['role']) {
			case UsersModel::ROLE_ADMIN:
				return;
				break;

			case UsersModel::ROLE_SUBSCRIBER:
				return $this->forbidden();
				break;

			default:
				return $this->unauthorized();
				break;
		}
	}
}

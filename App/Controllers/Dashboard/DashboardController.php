<?php

namespace Codbear\Alaska\Controllers\Dashboard;

use Codbear\Alaska\Controllers\Controller;
use Codbear\Alaska\Models\Tables\UsersTable;
use Codbear\Alaska\Services\Session;

abstract class DashboardController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		switch (Session::get('user')['role']) {
			case UsersTable::ROLE_ADMIN:
				return;
				break;

			case UsersTable::ROLE_SUBSCRIBER:
				return $this->forbidden();
				break;

			default:
				return $this->unauthorized();
				break;
		}
	}
}

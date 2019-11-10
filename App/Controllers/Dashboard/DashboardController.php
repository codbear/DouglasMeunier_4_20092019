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
				break;

			default:
				ErrorsController::error401();
				break;
		}
		exit();
	}

	public function render(string $view, string $title, array $datas = [])
	{
		$title = $title;
		switch ($view) {
			case 'chaptersPanel':
				$published = $datas['published'];
				$trash = $datas['trash'];
				$drafts = $datas['drafts'];
				break;

			case 'chapterEditor':
				$chapter = $datas['chapter'];
				break;
		}
		require_once('../App/Views/dashboard/' . $view . '.php');
	}
}

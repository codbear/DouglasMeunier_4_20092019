<?php

namespace Codbear\Alaska\Services;

use Codbear\Alaska\Controllers\Controller;
use Codbear\Alaska\Controllers\AuthController;
use Codbear\Alaska\Controllers\BookController;
use Codbear\Alaska\Controllers\HomeController;
use Codbear\Alaska\Controllers\AccountSettingsController;
use Codbear\Alaska\Controllers\Dashboard\UsersPanelController;
use Codbear\Alaska\Controllers\Dashboard\ChapterEditorController;
use Codbear\Alaska\Controllers\Dashboard\ChaptersPanelController;
use Codbear\Alaska\Controllers\Dashboard\CommentsPanelController;

class Router
{

	public static function init()
	{
		try {
			if (isset($_GET['view'])) {
				switch ($_GET['view']) {
					case 'book':
						$controller = new BookController();
						break;

					case 'auth':
						$controller = new AuthController();
						break;

					case 'accountSettings':
						$controller = new AccountSettingsController();
						break;

					case 'chaptersPanel':
						$controller = new ChaptersPanelController();
						break;

					case 'chapterEditor':
						$controller = new ChapterEditorController();
						break;

					case 'commentsPanel':
						$controller = new CommentsPanelController();
						break;

					case 'usersPanel':
						$controller = new UsersPanelController();
						break;

					default:
						$controller = new Controller();
						$controller->notFound();
						break;
				}
			} else {
				$controller = new HomeController();
			}
			$controller->execute($_GET, $_POST);
		} catch (\Exception $e) {
			$errorMessage = $e->getMessage();
			echo $errorMessage;
		}
	}
}

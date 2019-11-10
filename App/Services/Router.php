<?php

namespace Codbear\Alaska\Services;

use Codbear\Alaska\Controllers\BookController;
use Codbear\Alaska\Controllers\HomeController;
use Codbear\Alaska\Controllers\LoginController;
use Codbear\Alaska\Controllers\ErrorsController;
use Codbear\Alaska\Controllers\Dashboard\ChapterEditorController;
use Codbear\Alaska\Controllers\Dashboard\ChaptersPanelController;

abstract class Router
{

	public static function init()
	{
		try {
			if (isset($_GET['view'])) {
				switch ($_GET['view']) {
					case 'book':
						$controller = new BookController();
						break;

					case 'login':
						$controller = new LoginController();
						break;

					case 'chaptersPanel':
						$controller = new ChaptersPanelController();
						break;

					case 'chapterEditor':
						$controller = new ChapterEditorController();
						break;

					default:
						$controller = new ErrorsController();
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

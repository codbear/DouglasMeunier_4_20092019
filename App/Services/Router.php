<?php

namespace Codbear\Alaska\Services;

use Codbear\Alaska\Controllers\Controller;

class Router
{

	public static function init()
	{
		try {
			if (isset($_GET['view'])) {
				switch ($_GET['view']) {
					case 'book':
						$controller = Controller::factory('book');
						break;

					case 'auth':
						$controller = Controller::factory('auth');
						break;

					case 'accountSettings':
						$controller = Controller::factory('accountSettings');
						break;

					case 'chaptersPanel':
						$controller = Controller::factory('dashboard\\ChaptersPanel');
						break;

					case 'chapterEditor':
						$controller = Controller::factory('dashboard\\ChapterEditor');
						break;

					case 'commentsPanel':
						$controller = Controller::factory('dashboard\\CommentsPanel');
						break;

					case 'usersPanel':
						$controller = Controller::factory('dashboard\\UsersPanel');
						break;

					default:
						$controller = Controller::factory();
						return $controller->notFound();
						break;
				}
			} else {
				$controller = Controller::factory('home');
			}
			$controller->execute($_GET, $_POST);
		} catch (\Exception $e) {
			$errorMessage = $e->getMessage();
			echo $errorMessage;
		}
	}
}

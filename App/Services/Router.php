<?php

namespace Codbear\Alaska\Services;

use Codbear\Alaska\Services\Renderer\Renderer;

class Router
{

	private static $_rendererInstance = null;

	public static function init()
	{
		try {
			if (isset($_GET['view'])) {
				switch ($_GET['view']) {
					case 'book':
						$controller = self::getController('book');
						break;

					case 'login':
						$controller = self::getController('login');
						break;

					case 'chaptersPanel':
						$controller = self::getController('dashboard\\ChaptersPanel');
						break;

					case 'chapterEditor':
						$controller = self::getController('dashboard\\ChapterEditor');
						break;

					default:
						$controller = self::getController('errors');
						break;
				}
			} else {
				$controller = self::getController('home');
			}
			$controller->execute($_GET, $_POST);
		} catch (\Exception $e) {
			$errorMessage = $e->getMessage();
			echo $errorMessage;
		}
	}

	private static function getController($name)
	{
		$className = '\\Codbear\\Alaska\\Controllers\\' . ucfirst($name) . 'Controller';
		return new $className(self::getRenderer());
	}

	private static function getRenderer()
	{
		if (is_null(self::$_rendererInstance)) {
			self::$_rendererInstance = new Renderer(dirname(__DIR__) . '/Views');
			self::$_rendererInstance->addPath(dirname(__DIR__) . '/Views/dashboard', 'dashboard');
			self::$_rendererInstance->addPath(dirname(__DIR__) . '/Views/errors', 'errors');
			self::$_rendererInstance->addGlobal('title', 'Un billet pour l\'Alaska');
		}
		return self::$_rendererInstance;
	}
}

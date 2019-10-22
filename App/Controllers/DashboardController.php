<?php

namespace Codbear\Alaska\Controllers;

use Codbear\Alaska\Models\BookModel;
use Codbear\Alaska\Interfaces\ControllerInterface;

class DashboardController implements ControllerInterface {

    public function loadChaptersAdminPanel() {
        $book = new BookModel();
        $title = 'Dashboard - Chapitres';
        $chaptersList = $book->getTableOfContent();
        require_once('../App/Views/dashboard/chapters.php');
    }

    public function execute($params, $datas) {
        if (isset($params['section'])) {
			switch ($params['section']) {
                case 'chapters':
					$this->loadChaptersAdminPanel();
					break;

				default:
                    require_once('../App/Views/404.php');
					break;
			}
		} else {
			require_once('../App/Views/404.php');
		}
	}

}
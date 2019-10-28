<?php

namespace Codbear\Alaska\Controllers\Dashboard;

use Codbear\Alaska\Models\BookModel;
use Codbear\Alaska\Interfaces\ControllerInterface;
use Codbear\Alaska\Controllers\Dashboard\DashboardController;
use Codbear\Alaska\Controllers\ErrorsController;

class ChaptersPanelController extends DashboardController implements ControllerInterface
{

    public function execute($params, $datas)
    {
            $book = new BookModel();
            $title = 'Dashboard - Chapitres';
            $chaptersList = $book->getTableOfContent();
            require_once('../App/Views/dashboard/chapters.php');
    }
}


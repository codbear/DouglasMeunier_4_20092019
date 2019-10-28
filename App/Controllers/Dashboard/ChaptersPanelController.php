<?php

namespace Codbear\Alaska\Controllers\Dashboard;

use Exception;
use Codbear\Alaska\Session;
use Codbear\Alaska\Models\BookModel;
use Codbear\Alaska\Controllers\ErrorsController;
use Codbear\Alaska\Interfaces\ControllerInterface;
use Codbear\Alaska\Controllers\Dashboard\DashboardController;

class ChaptersPanelController extends DashboardController implements ControllerInterface
{

    public function moveChapterToTrash($params, $book) {
        try {
            if (isset($params['chapterId'])) {
                $movedToTrash = $book->moveChapterToTrash((int)$params['chapterId']);
            } else {
                throw new Exception("Le chapitre que vous essayez de déplacer vers la corbeille n'existe pas", 1);
            }
            
            if ($movedToTrash) {
                Session::setFlash('Le chapitre a été placé dans la corbeille', 'success');
            } else {
                throw new Exception("Une erreur inatendue est survenue. Merci de réessayer ultérieurement", 1);
            }
        } catch (Exception $e) {
            Session::setFlash($e->getMessage(), 'error');
        }
    }

    public function execute($params, $datas)
    {

        $title = 'Dashboard - Chapitres';
        $book = new BookModel();

        if (isset($params['action'])) {
            switch ($params['action']) {
                case 'moveToTrash':
                    $this->moveChapterToTrash($params, $book);
                    break;

                default:
                    ErrorsController::error404();
                    break;
            }
        }
        $chaptersList = $book->getTableOfContent();
        require_once('../App/Views/dashboard/chapters.php');
    }
}


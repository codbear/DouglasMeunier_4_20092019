<?php

namespace Codbear\Alaska\Controllers\Dashboard;

use Exception;
use Codbear\Alaska\Models\BookModel;
use Codbear\Alaska\Services\Session;
use Codbear\Alaska\Controllers\ErrorsController;
use Codbear\Alaska\Interfaces\ControllerInterface;
use Codbear\Alaska\Controllers\Dashboard\DashboardController;

class ChaptersPanelController extends DashboardController implements ControllerInterface
{
    private $_book = null;

    public function __construct()
    {
        $this->_book = new BookModel();
    }

    public function execute($params, $datas)
    {
        $title = 'Dashboard - Chapitres';
        $book = new BookModel();

        if (isset($params['action'])) {
            switch ($params['action']) {
                case 'publishChapter':
                    $this->changeChapterStatus($params, BookModel::CHAPTER_STATUS_PUBLISHED, $datas);
                    break;

                case 'moveChapterToTrash':
                    $this->changeChapterStatus($params, BookModel::CHAPTER_STATUS_TRASH);
                    break;

                case 'restoreChapterFromTrash':
                    $this->changeChapterStatus($params, BookModel::CHAPTER_STATUS_DRAFT);
                    break;

                case 'deleteChapterPermanently':
                    $this->changeChapterStatus($params, BookModel::CHAPTER_STATUS_DELETED);
                    break;

                case 'createNewChapter':
                    $this->createNewChapter();
                    break;

                default:
                    ErrorsController::error404();
                    break;
            }
        } else {
            foreach ($this->_book->getTableOfContent() as $chapter) {
                switch ($chapter->chapter_status) {
                    case BookModel::CHAPTER_STATUS_PUBLISHED:
                        $published[] = $chapter;
                        break;

                    case BookModel::CHAPTER_STATUS_TRASH:
                        $trash[] = $chapter;
                        break;

                    case BookModel::CHAPTER_STATUS_DRAFT:
                        $drafts[] = $chapter;
                        break;

                    default:
                        break;
                }
            }
            require_once('../App/Views/dashboard/chaptersPanel.php');
        }
    }

    private function changeChapterStatus(array $params, $newStatus = BookModel::CHAPTER_STATUS_DEFAULT, array $datas = [])
    {
        try {
            if (isset($params['chapterId'])) {
                $statusChanged = $this->_book->changeChapterStatus((int) $params['chapterId'], $newStatus);
            } else {
                throw new Exception("L'identifiant du chapitre que vous essayer de modifier n'est pas définit. Merci de réessayer ultérieurement.", 1);
            }
            if ($statusChanged) {
                switch ($newStatus) {
                    case BookModel::CHAPTER_STATUS_TRASH:
                        Session::setFlash('Le chapitre a été placé dans la corbeille', 'success');
                        break;

                    case BookModel::CHAPTER_STATUS_DRAFT:
                        Session::setFlash('Le chapitre a été placé dans les brouillons', 'success');
                        break;

                    case BookModel::CHAPTER_STATUS_DELETED:
                        Session::setFlash('Le chapitre a été supprimé', 'success');
                        break;

                    default:
                        throw new Exception("Une erreur inatendue est survenue. Merci de réessayer ultérieurement.", 1);
                        break;
                }
                header('Location: /?view=chaptersPanel');
            } else {
                throw new Exception("Une erreur inatendue est survenue. Merci de réessayer ultérieurement.", 1);
            }
        } catch (Exception $e) {
            Session::setFlash($e->getMessage(), 'error');
            header('Location: /?view=chaptersPanel');
        }
    }

    private function createNewChapter()
    {
        if ($this->_book->createNewChapter()) {
            header('Location: /?view=chapterEditor&chapterId=' . $this->_book->getLastChapterId() . '');
        } else {
            Session::setFlash('Une erreur inatendue est survenue. Merci de réessayer ultérieurement.', 'error');
            header('Location: /?view=chaptersPanel');
        }
    }
}

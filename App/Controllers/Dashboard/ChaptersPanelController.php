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
    private function changeChapterStatus($params, $book, $newStatus = BookModel::CHAPTER_STATUS_DEFAULT)
    {
        try {
            if (isset($params['chapterId'])) {
                $statusChanged = $book->changeChapterStatus((int) $params['chapterId'], $newStatus);
            } else {
                throw new Exception("L'identifiant du chapitre que vous essayer de modifier n'est pas définit. Merci de réessayer ultérieurement.", 1);
            }

            if ($statusChanged) {
                switch ($newStatus) {
                    case BookModel::CHAPTER_STATUS_PUBLISHED:
                        Session::setFlash('Le chapitre a été publié', 'success');
                        break;

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

    private function deleteChapterPermanently($params, $book)
    {
        try {
            if (isset($params['chapterId'])) {
                $deletedPermanently = $book->deleteChapterPermanently((int) $params['chapterId']);
            } else {
                throw new Exception("L'identifiant du chapitre que vous essayer de supprimer n'est pas définit. Merci de réessayer ultérieurement.", 1);
            }

            if ($deletedPermanently) {
                Session::setFlash('Le chapitre a été supprimé définitivement', 'success');
                header('Location: /?view=chaptersPanel');
            } else {
                throw new Exception("Une erreur inatendue est survenue. Merci de réessayer ultérieurement.", 1);
            }
        } catch (Exception $e) {
            Session::setFlash($e->getMessage(), 'error');
            header('Location: /?view=chaptersPanel');
        }
    }

    public function execute($params, $datas)
    {
        $title = 'Dashboard - Chapitres';
        $book = new BookModel();

        if (isset($params['action'])) {
            switch ($params['action']) {
                case 'publishChapter':
                    $this->changeChapterStatus($params, $book, BookModel::CHAPTER_STATUS_PUBLISHED);
                    break;

                case 'moveChapterToTrash':
                    $this->changeChapterStatus($params, $book, BookModel::CHAPTER_STATUS_TRASH);
                    break;

                case 'restoreChapterFromTrash':
                    $this->changeChapterStatus($params, $book, BookModel::CHAPTER_STATUS_DRAFT);
                    break;

                case 'deleteChapterPermanently':
                    $this->changeChapterStatus($params, $book, BookModel::CHAPTER_STATUS_DELETED);
                    break;

                default:
                    ErrorsController::error404();
                    break;
            }
        } else {
            foreach ($book->getTableOfContent() as $chapter) {
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
            require_once('../App/Views/dashboard/chapters.php');
        }
    }
}

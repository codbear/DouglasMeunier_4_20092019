<?php

namespace Codbear\Alaska\Controllers\Dashboard;

use Codbear\Alaska\Models\BookModel;
use Codbear\Alaska\Services\Session;
use Codbear\Alaska\Interfaces\ControllerInterface;

class ChapterEditorController extends DashboardController implements ControllerInterface
{
    private $_book = null;

    public function __construct()
    {
        $this->_book = new BookModel();
    }

    public function execute(array $params, array $datas)
    {
        $title = 'Editeur';
        $chapterId = $params['chapterId'];
        if (isset($params['action'])) {
            switch ($params['action']) {
                case 'saveChapter':
                    $chapterStatus = $this->_book->getChapterStatus($chapterId);
                    $this->saveChapter($chapterId, $datas, $chapterStatus);
                    break;

                case 'publishChapter':
                    $chapterStatus = BookModel::CHAPTER_STATUS_PUBLISHED;
                    $this->saveChapter($chapterId, $datas, $chapterStatus);
                    header('Location: /?view=chaptersPanel');
                    exit();
                    break;

                default:
                    ErrorsController::error404();
                    break;
            }
            header('Location: /?view=chapterEditor&chapterId=' . $params['chapterId'] . '');
        } else {
            $chapter = $this->getChapter($params['chapterId']);
            require_once('../App/Views/dashboard/chapterEditor.php');
        }
    }

    private function getChapter(int $chapterId)
    {
        return $this->_book->getChapter((int) $chapterId);
    }

    private function saveChapter(int $chapterId, array $datas, $chapterStatus)
    {
        $chapterTitle = $datas['chapter-title'];
        $chapterNumber = $datas['chapter-number'];
        $chapterContent = $datas['chapter-content'];
        if (empty($datas['chapter-excerpt'])) {
            $chapterExcerpt = substr($chapterContent, 0, 252) . '...';
        } else {
            $chapterExcerpt = $datas['chapter-excerpt'];
        }
        if ($this->_book->saveChapter($chapterId, $chapterTitle, $chapterNumber, $chapterContent, $chapterExcerpt, $chapterStatus)) {
            if ($chapterStatus === BookModel::CHAPTER_STATUS_PUBLISHED) {
                Session::setFlash('Le chapitre a bien été publié', 'success');
            } else {
                Session::setFlash('Le chapitre a bien été enregistré', 'success');
            }
        } else {
            Session::setFlash('Une erreur inatendue est survenue. Merci de réessayer ultérieurement.', 'error');
        }
    }
}

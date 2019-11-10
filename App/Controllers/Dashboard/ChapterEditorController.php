<?php

namespace Codbear\Alaska\Controllers\Dashboard;

use Codbear\Alaska\Services\Session;
use Codbear\Alaska\Models\ChapterModel;
use Codbear\Alaska\Interfaces\ControllerInterface;

class ChapterEditorController extends DashboardController implements ControllerInterface
{
    private $_chapter = null;

    public function execute(array $params, array $datas)
    {
        $this->_chapter = ChapterModel::getChapter((int) $params['chapterId']);
        $title = 'Editeur';
        if (isset($params['action'])) {
            switch ($params['action']) {
                case 'saveChapter':
                    $this->saveChapter($datas, $this->_chapter->status);
                    break;

                case 'publishChapter':
                    $this->saveChapter($datas, ChapterModel::STATUS_PUBLISHED);
                    header('Location: /?view=chaptersPanel');
                    exit();
                    break;

                default:
                    ErrorsController::error404();
                    break;
            }
            header('Location: ' . $this->_chapter->editorUrl . '');
        } else {
            $chapter = $this->_chapter;
            $this->render('chapterEditor');
        }
    }

    private function saveChapter(array $datas, $chapterStatus)
    {
        $this->_chapter->title = $datas['chapter-title'];
        $this->_chapter->number = $datas['chapter-number'];
        $this->_chapter->content = $datas['chapter-content'];
        if (empty($datas['chapter-excerpt'])) {
            $this->_chapter->excerpt = substr($this->_chapter->content, 0, 252) . '...';
        } else {
            $this->_chapter->excerpt = $datas['chapter-excerpt'];
        }
        if (ChapterModel::save(
            $this->_chapter->id,
            $this->_chapter->title,
            $this->_chapter->number,
            $this->_chapter->content,
            $this->_chapter->excerpt,
            $chapterStatus
        )) {
            if ($chapterStatus === ChapterModel::STATUS_PUBLISHED) {
                Session::setFlash('Le chapitre a bien été publié', 'success');
            } else {
                Session::setFlash('Le chapitre a bien été enregistré', 'success');
            }
        } else {
            Session::setFlash('Une erreur inatendue est survenue. Merci de réessayer ultérieurement.', 'error');
        }
    }
}

<?php

namespace Codbear\Alaska\Controllers\Dashboard;

use Exception;
use Codbear\Alaska\Services\Session;
use Codbear\Alaska\Models\ChaptersModel;
use Codbear\Alaska\Interfaces\ControllerInterface;
use Codbear\Alaska\Models\ViewModels\ChapterViewModel;
use Codbear\Alaska\Services\Security;

class ChapterEditorController extends DashboardController implements ControllerInterface
{
    private $chapter;

    public function execute(array $params, array $datas)
    {
        if (isset($params['chapterId'])) {
            $this->chapter = ChaptersModel::get((int) $params['chapterId']);
        } else {
            $this->chapter = new ChapterViewModel();
        }

        if (isset($params['action'])) {
            switch ($params['action']) {
                case 'saveChapter':
                    $this->save($datas);
                    break;

                case 'publishChapter':
                    $this->save($datas, true);
                    break;

                default:
                    return $this->notFound();
                    break;
            }
        }

        if (!isset($this->chapter->number) || $this->chapter->number < 1) {
            $this->chapter->number = ChaptersModel::getMaxChapterNumber() + 1;
        }

        return $this->renderer->render('dashboard/chapterEditor', [
            'title' => 'Editeur | Dashboard',
            'chapter' => $this->chapter
        ]);
    }

    private function save(array $datas, bool $publish = false)
    {
        $this->chapter->title = Security::protectString($datas['chapter-title']);
        $this->chapter->number = $this->chapter->number_save = (int) $datas['chapter-number'];
        $this->chapter->content = $datas['chapter-content'];

        if (empty($datas['chapter-excerpt'])) {
            $this->chapter->excerpt = substr(strip_tags($this->chapter->content), 0, 252) . '...';
        } else {
            $this->chapter->excerpt = $datas['chapter-excerpt'];
        }

        if ($publish) {
            $this->chapter->status = ChaptersModel::STATUS_PUBLISHED;
        } elseif (!isset($this->chapter->status)) {
            $this->chapter->status = ChaptersModel::STATUS_DRAFT;
        }

        try {
            $this->checkDatas();
            $save = ChaptersModel::save($this->chapter);

            if ($save) {
                if ($this->chapter->status === ChaptersModel::STATUS_PUBLISHED) {
                    Session::setFlashbag('Le chapitre a bien été publié', 'success');
                } else {
                    if (empty($this->chapter->content)) {
                        Session::setFlashbag('Le chapitre a bien été enregistré, mais son contenu est vide');
                    } else {
                        Session::setFlashbag('Le chapitre a bien été enregistré', 'success');
                    }
                }

                header('Location: /?view=chaptersPanel');
                exit;
            } else {
                throw new Exception('Une erreur inatendue est survenue. Merci de réessayer ultérieurement.');
            }
        } catch (Exception $e) {
            if ($publish) {
                $this->chapter->status = ChaptersModel::STATUS_DRAFT;
            }

            Session::setFlashbag($e->getMessage(), 'error');
        }
    }

    private function checkDatas()
    {
        $this->checkNumber();

        if (empty($this->chapter->number)) {
            throw new Exception('Vous devez saisir un numéro de chapitre');
        }

        if ($this->chapter->number < 1) {
            throw new Exception('Vous ne pouvez pas saisir un numéro de chapitre négatif');
        }

        if (empty($this->chapter->title)) {
            throw new Exception('Vous devez saisir un titre pour votre chapitre');
        }

        if ($this->chapter->status === ChaptersModel::STATUS_PUBLISHED && empty($this->chapter->content)) {
            throw new Exception('Impossible de publier un chapitre sans contenu');
        }
    }

    private function checkNumber()
    {
        $chapterInDB = ChaptersModel::getWithNumber($this->chapter->number);
        if ($chapterInDB) {
            if ((int) $chapterInDB->id !== (int) $this->chapter->id) {
                throw new Exception('Le chapitre ' . $this->chapter->number . ' existe déjà');
            }
        }
    }
}

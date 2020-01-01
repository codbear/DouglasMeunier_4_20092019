<?php

namespace Codbear\Alaska\Models\ViewModels;

use Codbear\Alaska\Models\ChaptersModel;

class ChapterViewModel
{
    public function __get(string $attribute)
    {
        $method = 'get' . ucfirst($attribute);
        $this->$attribute = $this->$method();
        return $this->$attribute;
    }

    private function getUrl(): string
    {
        return '/?view=book&chapterId=' . $this->id;
    }

    private function getEditorUrl(): string
    {
        return '/?view=chapterEditor&chapterId=' . $this->id;
    }

    private function getPublishUrl(): string
    {
        if (isset($this->id)) {
            return '/?view=chapterEditor&action=publishChapter&chapterId=' . $this->id;
        } else {
            return '/?view=chapterEditor&action=publishChapter';
        }
    }

    private function getSaveUrl(): string
    {
        if (isset($this->id)) {
            return '?view=chapterEditor&action=saveChapter&chapterId=' . $this->id;
        } else {
            return '?view=chapterEditor&action=saveChapter';
        }
    }

    private function getMoveToTrashUrl(): string
    {
        if (isset($this->id)) {
            return '?view=chaptersPanel&action=moveChapterToTrash&chapterId=' . $this->id;
        } else {
            return '?view=chaptersPanel';
        }
    }

    private function getPreviousChapterUrl()
    {
        if ($previousChapter = ChaptersModel::getWithNumber($this->number - 1)) {
            if ($previousChapter->status == ChaptersModel::STATUS_PUBLISHED) {
                return $previousChapter->url;
            }
        }
    }

    private function getNextChapterUrl()
    {
        if ($nextChapter = ChaptersModel::getWithNumber($this->number + 1)) {
            if ($nextChapter->status == ChaptersModel::STATUS_PUBLISHED) {
                return $nextChapter->url;
            }
        }
    }
}

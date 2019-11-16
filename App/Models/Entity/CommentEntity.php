<?php

namespace Codbear\Alaska\Models\Entity;

class CommentEntity
{
    public $reporting = 0;

    public function __get($attribute)
    {
        $method = 'get' . ucfirst($attribute);
        $this->$attribute = $this->$method();
        return $this->$attribute;
    }

    public function setReporting(int $reporting)
    {
        $this->reporting = $reporting;
    }

    private function getDeleteUrl() {
        return "/?view=commentsPanel&action=deleteComment&commentId=" . $this->id;
    }
}

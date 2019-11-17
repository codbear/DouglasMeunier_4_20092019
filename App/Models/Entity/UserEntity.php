<?php

namespace Codbear\Alaska\Models\Entity;

class UserEntity
{ 
    public function __get($attribute)
    {
        $method = 'get' . ucfirst($attribute);
        $this->$attribute = $this->$method();
        return $this->$attribute;
    }

    private function getDeleteUrl() {
        return "/?view=usersPanel&action=deleteUser&userId=" . $this->id;
    }
}

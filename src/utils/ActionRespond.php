<?php
declare(strict_types=1);

namespace TaskForce\utils;

class ActionRespond extends Action
{
    public function getTitle(): string
    {
        return 'ОТКЛИКНУТЬСЯ';
    }

    public function getVar(): string
    {
        return 'ACTION_RESPOND';
    }

    public function getAccess(): bool
    {
        return $this->user_id === $this->doer_id;
    }
}

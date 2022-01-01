<?php

namespace App\persist;
require_once '../persist/UserStore.php';


class Validator
{
    private UserStore $store;

    public function __construct(UserStore $store)
    {
        $this->store = $store;
    }

    public function validateUser(string $mail, string $pass): bool
    {

        if (! is_array($user = $this->store->getUser($mail))) {
            return false;
        }

        if ($user['pass'] == $pass) {
            return true;
        }

        $this->store->notifyPasswordFailure($mail);
        return false;
    }
}
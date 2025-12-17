<?php

namespace App\Services;

class UserIdValidationService
{
    public function isValidUser(int $id): bool
    {
        // jika id = 1 → valid, selain itu → false
        return $id === 1;
    }
}

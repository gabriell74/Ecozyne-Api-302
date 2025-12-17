<?php

namespace App\Services;

class EmailValidationService
{
    public function validateEmail(string $email): bool
    {
        // cek required & format sederhana
        if (empty($email)) return false;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return false;
        return true;
    }
}

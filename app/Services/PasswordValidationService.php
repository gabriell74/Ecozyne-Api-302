<?php

namespace App\Services;

class PasswordValidationService
{
    public function validatePassword(string $password): bool
    {
        // minimal 8 karakter
        if (strlen($password) < 8) return false;

        // setidaknya 1 angka
        if (!preg_match('/[0-9]/', $password)) return false;

        // setidaknya 1 huruf besar
        if (!preg_match('/[A-Z]/', $password)) return false;

        return true;
    }
}

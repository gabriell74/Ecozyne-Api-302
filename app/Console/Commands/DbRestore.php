<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DbRestore extends Command
{
    protected $signature = 'db:restore {filename}';
    protected $description = 'Restore database dari file SQL di storage/backups';

    public function handle()
    {
        $filename = $this->argument('filename');
        $filePath = storage_path('app/backups/' . $filename);

        if (!file_exists($filePath)) {
            $this->error("❌ File tidak ditemukan: {$filePath}");
            return Command::FAILURE;
        }
        
        // =========================================================
        // 🛠️ PERBAIKAN UTAMA: Tentukan Jalur Absolut MySQL di sini
        // Ganti nilai string di bawah ini sesuai dengan OS Anda!
        // =========================================================
        
        // Contoh untuk Linux/macOS (Umum)
        // $mysqlExecutable = '/usr/bin/mysql'; 
        
        // Contoh untuk Windows (XAMPP)
        // Hati-hati dengan backslash ganda (\)
        $mysqlExecutable = 'C:/laragon/bin/mysql/mysql-8.0.30-winx64/bin/mysql.exe';
        
        // Atau jika Anda menggunakan MAMP, WAMP, atau instalasi lain,
        // cari file mysql.exe/mysql dan masukkan jalur lengkapnya.
        
        // Untuk amannya, Anda bisa menggunakan `mysql` sebagai default,
        // tetapi disarankan menggunakan jalur lengkap yang Anda yakini.
        // =========================================================

        $db = config('database.connections.mysql.database');
        $host = config('database.connections.mysql.host');
        $port = config('database.connections.mysql.port');
        $user = config('database.connections.mysql.username');
        $pass = config('database.connections.mysql.password');

        $this->info("⏳ Melakukan restore database '{$db}' dari file '{$filename}'...");

        $passwordPart = $pass ? '-p' . escapeshellarg($pass) : '';

        // Command mysql untuk restore
        $command = sprintf(
            // Ganti 'mysql' di awal string format dengan %s 
            // untuk memasukkan jalur absolut
            '%s -h%s -P%s -u%s %s %s < %s 2>&1',
            escapeshellarg($mysqlExecutable), // <-- Masukkan Jalur Absolut di sini
            escapeshellarg($host),
            escapeshellarg($port),
            escapeshellarg($user),
            $passwordPart,
            escapeshellarg($db),
            escapeshellarg($filePath)
        );

        exec($command, $output, $result);

        if ($result === 0) {
            $this->info("✅ Restore database '{$db}' berhasil!");
        } else {
            $this->error("❌ Restore gagal!");
            $this->line("Detail error:\n" . implode("\n", $output));
        }

        return $result;
    }
}
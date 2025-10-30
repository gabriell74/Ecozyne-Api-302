<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process; // <-- Gunakan ini
use Symfony\Component\Process\Exception\ProcessFailedException; // <-- Gunakan ini

class BackupDatabase extends Command
{
    protected $signature = 'db:backup';
    protected $description = 'Backup database MySQL/Ecozyne';

    public function handle()
    {
        // Ambil konfigurasi dari 'mariadb'
        $config = config('database.connections.mysql');

        $database = $config['database'];
        $username = $config['username'];
        $password = $config['password'];
        $host     = $config['host'];
        $port     = $config['port'];
        
        // Ambil path dump dari config
        // [cite: 1]
        $dumpDir = $config['dump']['dump_binary_path'] ?? null;

        $this->info(" Membuat backup database '{$database}'...");

        $filename  = 'backup-' . date('Y-m-d-H-i-s') . '.sql';
        $backupDir = storage_path('app/backups'); // Sesuai dengan BackupClean.php

        if (!file_exists($backupDir)) {
            mkdir($backupDir, 0755, true);
        }
        
        $backupFile = $backupDir . DIRECTORY_SEPARATOR . $filename;

        // Cek path dumper
        if (!$dumpDir) {
            $this->error("❌ 'dump_binary_path' tidak diatur di config/database.php > connections.mysql.dump");
            return 1;
        }
        
        $dumper = rtrim($dumpDir, '\\/') . DIRECTORY_SEPARATOR . 'mysqldump.exe';

        if (!file_exists($dumper)) {
            $this->error("❌ mysqldump.exe tidak ditemukan di: {$dumper}");
            $this->error(" Pastikan 'dump_binary_path' di config/database.php sudah benar.");
            return 1;
        }

        // 2. REFAKTOR COMMAND MENGGUNAKAN SYMFONY PROCESS
        $this->info(" Menjalankan backup...");

        // Buat command tanpa password
        $command = sprintf(
            '"%s" -h %s -P %s -u %s %s > "%s"',
            $dumper,
            $host,
            $port,
            $username,
            $database,
            $backupFile
        );

        // Gunakan Process::fromShellCommandline untuk menangani string command
        $process = Process::fromShellCommandline($command, null, [
            // Set password dengan aman melalui environment variable
            'MYSQL_PWD' => $password, 
        ]);
        
        $process->setTimeout(3600); // Set timeout 1 jam

        try {
            // Jalankan command. 'mustRun()' akan melempar exception jika gagal.
            $process->mustRun(); 

            // Cek ulang file setelah command sukses
            if (file_exists($backupFile) && filesize($backupFile) > 0) {
                $this->info("✅ Database backup created: {$filename}");
                $this->info(" Size: " . number_format(filesize($backupFile) / 1024, 2) . " KB");
                $this->info(" Location: {$backupFile}");
                return 0;
            } else {
                $this->error("❌ File dibuat tapi kosong (0 bytes) atau tidak ada.");
                @unlink($backupFile); // Hapus file kosong
                return 1;
            }

        } catch (ProcessFailedException $exception) {
            // Jika command GAGAL (return code != 0)
            $this->error("❌ Backup GAGAL!");
            $this->error("================= PESAN ERROR (stderr) =================");
            // Ini akan menampilkan error "Access Denied" atau error lainnya
            $this->error($exception->getProcess()->getErrorOutput()); 
            $this->error("======================================================");

            // Hapus file 0-byte yang mungkin terbuat
            if (file_exists($backupFile)) {
                @unlink($backupFile);
            }
            return 1;
        }
    }
}
@echo off
REM ============================================
REM SISO Auto Approval Batch Script
REM Jalankan script ini via Windows Task Scheduler
REM ============================================

REM Ganti path ini sesuai lokasi XAMPP/PHP di komputer lo
SET PHP_PATH=C:\xampp\php\php.exe

REM Path ke folder ManajemenAsset (ganti sesuai lokasi project)
SET PROJECT_PATH=%~dp0

REM Pindah ke folder project
cd /d "%PROJECT_PATH%"

REM Jalankan cron auto approval
"%PHP_PATH%" index.php cron autoApproval

REM Log hasil ke file (opsional)
echo [%date% %time%] Auto Approval executed >> auto_approval_log.txt

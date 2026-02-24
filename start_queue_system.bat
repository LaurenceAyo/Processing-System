@echo off
TITLE Office Queueing System - Launcher
COLOR 0B

echo ==========================================
echo    OFFICE QUEUEING SYSTEM - LAUNCHER
echo ==========================================
echo.

:: Get the local IP address for display
for /f "tokens=4" %%a in ('route print ^| find " 0.0.0.0"') do set IP=%%a

echo [1/3] Starting Laravel Web Server...
echo Access URL: http://%IP%:8000
start /b php artisan serve --host=0.0.0.0 --port=8000

echo [2/3] Starting Reverb WebSocket Service...
start /b php artisan reverb:start

echo [3/3] Opening Display Monitor...
timeout /t 5 >nul
start "" "http://%IP%:8000/display"

echo.
echo ==========================================
echo    SYSTEM IS RUNNING
echo ==========================================
echo.
echo Leave this window open to keep the services running.
echo To stop the system, close this window or press Ctrl+C.
echo.
pause

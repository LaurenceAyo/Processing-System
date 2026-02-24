Install Prerequisites:
    Install XAMPP (to get PHP and MySQL).
    Install Composer from getcomposer.org.
    
Clone the project:
    git clone https://github.com/vilvince/Processing-System
    cd office-queueing-app
    
Install Dependencies:
    composer install
    
Setup the Environment:
    Copy .env.example to a new file named .env.
    Open .env and change DB_DATABASE, DB_USERNAME, and DB_PASSWORD to match XAMPP database.

Initialize the App:
    php artisan key:generate
    php artisan migrate --seed 

Run the system:
    Open the project folder 
    Double-click the file name "start_queue_system.bat"

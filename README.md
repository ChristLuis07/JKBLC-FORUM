## Installation

### Clone this repository
You can downloade or clone this repository, if you want download you can touch the button with text code and download zip
```bash
git clone https://github.com/ChristLuis07/JKBLC-FORUM.git
cd JKBL-FORUM
```

### Install All Dependencies
First you must install all the dependencies
```bash
composer install
```

### Copy .env files
Copy .env.example file into .env and generate key from .env
```
cp .env.example .env
php artisan:key generate
```

### Setup Database Environment
Setup the database environment in .env file using your database credentials
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

### Migration Database
Migrate all databases
```bash
php artisan migrate
```

### Running apps
```bash
php artisan serve
```

### Download Postman Files Collection and Environments
Short URL https://bit.ly/PostmanJKBLC </br>
Or open this link https://drive.google.com/drive/folders/1KcxdX9dqtOIwBMgFmyBCheNTING_q1F2?usp=drive_link
</br>
Open your postman, drag and drop the downloads file into your postman

### ERD
https://bit.ly/BeJKBLC

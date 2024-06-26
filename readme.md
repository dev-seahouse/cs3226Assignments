Ranklist - Lab 6
================
Hello, if you thought of something that need to done, but busy at the moment, create an issue! So that somebody who might find the problem doable/easy can get that job done instead!
Remember to describe the problem and the definition of done as clearly as possible, just suggesting~ 

User accounts
=============
bevinseetoh@hotmail.com (admin)<br>
sayhi.kenan@gmail.com (admin)<br>
vivian198912@gmail.com (admin)<br>
larry1285@gmail.com (admin)<br>
shawnlimjq@hotmail.com (admin)<br>
tanmunaw@u.nus.edu (admin)<br>
student1@officialranklist.tk (student Husky)<br>
student2@officialtanklist.tk (student Chopper)<br><br>

DEFAULT PASSWORDS: qwerty123

Database Structure
==================
![ScreenShot](database.JPG)

Setup guide
===========
### XAMPP setup
Install XAMPP
```sh
https://www.apachefriends.org/index.html
```

### Clone the project into C:\xampp\htdocs\rankteam1
```sh
git clone https://github.com/dev-seahouse/cs3226Assignments.git
```

### Configure Virtual Host
Add the following code into C:\xampp\apache\conf\extra\httpd-vhosts.conf
```sh
<VirtualHost *:80>
    DocumentRoot "C:\xampp\htdocs\rankteam1\public"
    Errorlog "C:\xampp\htdocs\rankteam1\storage\logs\error.log"
    <Directory "C:\xampp\htdocs\rankteam1\public">
        Options Indexes FollowSymLinks 
        AllowOverride All 
        Require all granted         
    </Directory>
</VirtualHost>
```

### Setup Laravel
#### Setup requirements to install composer
Remove the semi-colon for the following values in C:\xampp\php\php.ini
```sh
extension=php_openssl.dll
extension=php_curl.dll
extension=php_sockets.dll
```
double check that there is only one uncommented line of "extension=php_openssl.dll"

#### Install Composer
1. Download and install Composer at https://getcomposer.org/download/
2. When asked to select command-line PHP, browse to C:\xampp\php\php.exe

#### Install Laravel
In the root folder of the project C:\xampp\htdocs\rankteam1
open command prompt and run the following commands:
```sh
# composer global require "laravel/installer"
# composer install
# composer require "laravelcollective/html":"^5.3.0"
```

#### Generate .env file
In the root folder of the project C:\xampp\htdocs\rankteam1
```sh
# php artisan config:clear
# copy .env.example .env
# php artisan key:generate
```
#### Use the server's database for the project
Modify the following settings in C:\xampp\htdocs\rankteam1\\.env
```sh
DB_CONNECTION=mysql
DB_HOST=128.199.205.219
DB_PORT=3306
DB_DATABASE=ranklist
DB_USERNAME=developer
DB_PASSWORD=developerP@ssw0rd1
```
#### Access the server's database through the web browser
Update the following variables in C:\xampp\phpMyAdmin\config.inc.php
```sh
$cfg['Servers'][$i]['auth_type'] = 'config';
$cfg['Servers'][$i]['user'] = 'developer';
$cfg['Servers'][$i]['password'] = 'developerP@ssw0rd1';
$cfg['Servers'][$i]['host'] = '128.199.205.219';
```
You should be able to access http://localhost/phpmyadmin without having to enter the credentials

To access http://128.199.205.219/phpmyadmin/<br>
<b>User:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;developer<br>
<b>Password:</b>&nbsp;&nbsp;developerP@ssw0rd1<br>

#### Setup mailgun
In the root folder of the project C:\xampp\htdocs\rankteam1
open command prompt and run the following command:
```sh
# composer require guzzlehttp/guzzle
```

Modify the following settings in C:\xampp\htdocs\rankteam1\\.env
Verified Mailgun domain settings
```sh
MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailgun.org
MAIL_PORT=2525
MAIL_USERNAME=postmaster@cs3226officialranklist.tk
MAIL_PASSWORD=89655d866e35092485fe34b412474103
MAIL_ENCRYPTION=null
```
Sandbox credentials:
MAIL_USERNAME=postmaster@sandboxd482171b2b614f8dae7b1427c5c5a319.mailgun.org
MAIL_PASSWORD=a0c542a3057fc62deff7e1e10016f18b

### Install NodeJS
1. Download and install Nodejs at https://nodejs.org/en/
2. open command prompt and run the following commands:
```sh
# npm install
```

#### Launch local development server
If you are using windows, open command prompt and type the following command
```sh
# .\run
```
If you are using linux/Mac, open terminal and type the following command
```sh
# php artisan serve & npm run watch
```

#### Compile front end assets manually (css and javascript)
Open terminal and type the following command:
```sh
npm run production
```




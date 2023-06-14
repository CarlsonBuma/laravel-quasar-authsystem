# Initialization
 - php artisan --version
 - composer install
 - create .env file

## Migrage Database
 - php artisan migrate
 - php artisan passport:install --force
 - Enter Client Secrets in .env File

## Seed First User
 - php artisan db:seed --class=UserSeeder

## Storage
 - php artisan storage:link
 - Note: After your first avatar has been stored, you must "storage:link" again!

## Setup Mail Driver
 - Choose your Mail Driver
 - Enter Attributes into .env file

## Login
  - Usercredits: admin@admin.com
  - Password: admin


# System Requirements
## System Modules
  - User Management
    - Registration
    - Email Verificaton
    - Password Reset
    - User
      - Login + Auth
        - Logout
      - User Profile
        - Change Avatar
        - Change Name
        - Change Password
        - Transfer Account (Change Email)
        - Delete Account    

## Environment
 * API-Testing: Postman
 * Backend:     Laravel 10
 * FrontEnd:    -
 * Database:    PSQL & PGADMIN4
 * Auth:        Laravel Passport (Oauth 2.0)
 * Storage:     Public Disk

 ### Hosts
 * Bluemail:    Sending & Tracking emails
 * Github:      Code Management
 * Localhost:   Server & Domain


 # Deployment
  - .env set to production
  - php artisan vendor:publish --tag=passport-config
    - Enter Client Secrets in .env File
  - composer install --optimize-autoloader --no-dev
  - php artisan config:cache
  - php artisan event:cache
  - php artisan route:cache

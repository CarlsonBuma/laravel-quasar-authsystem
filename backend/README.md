# System Requirements
 > Start: 24.12.2023, Carlson
 > Version 1.2.0, 06.01.2023
    > User Auth System - Sanctum, 1.0.0, 06.01.2023
    > User Auth System - OAUTH, 1.2.0, 23.04.2023

## Testing
 1. User Auth System - 06.01.2023 | safeNsound
 1. User Auth System - 24.04.2023 | Testing

## System Modules
  > User Management
    > Registration
    > Email Verificaton
    > Password Reset
    > User
      > Login + Auth
        > Logout
      > User Profile
        > Change Avatar
        > Change Name
        > Change Password
        > Transfer Account (Change Email)
        > Delete Account    

## Environment
 * API-Testing: Postman
 * Backend:     Laravel 9
 * FrontEnd:    -
 * Database:    MySQL & PGAdmin
 * Auth:        Laravel Passport (Oauth 2.0)
 * Storage:     Public Disk

 ### Hosts
 * Bluemail:    Sending & Tracking emails
 * Github:      Code Management
 * Localhost:   Server & Domain

 # Systemsetup 
 ## Login
  Usercredits: admin@admin.com
  Password: admin

 ## Database
 ### Migarte
  > php artisan migrate

 ### Seeding
  > php artisan db:seed --class=UserSeeder
  > php artisan db:seed --class=AdminSeeder

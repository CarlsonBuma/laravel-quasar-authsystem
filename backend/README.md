# System Requirements
 > Start: 24.12.2023, Carlson
 > Version 1.0.0, 06.01.2023
    > User Auth System, 06.01.2023

## Testing
 1. User Auth System - 06.01.2023 | safeNsound

## System Modules
  > User Management
    > Registration
    > Email Verificaton
    > Password Reset
    > User
      > Login + Auth
      > User Profile
        > Change Avatar
        > Change Name
        > Change Password
        > Transfer Account (Change Email)
        > Delete Account
        > Logout

## Environment
 * API-Testing: Postman
 * Backend:     Laravel 9
 * FrontEnd:    -
 * Database:    MySQL & PGAdmin
 * Auth:        Sanctum
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

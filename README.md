# System Overview
Full Auth System - v.3.2, 14.06.2023 
by Carlson, 08.01.2023

Public Git Repo: 
https://github.com/CarlsonBuma/Laravel-Quasar-Authsystem

## Current Bugs / Improvements
 > Please let me know!
 > hello@gigup.ch

## System Overview - Frontend (Vue3) & Backend (Laravel 10)
 - Globals Backend
    - Laravel Middleware: Laravel Passport
 - Globals Frontend
    - Cookie Consent (cookieConsent.js)
    - Request Handling (Toast.js)
 - Userauth
    - Login, Logout
    - Register + Email verification
    - Reset password
    - Transfer Account
    - User Profile
        - Change Avatar
        - Change Name
        - Change Password
        - Transfer Account (Change email)
        - Delete Account

## Folder Structure
 - backend
    - see Readme.md
 - frontend
    - see Readme.md

# Architecture
## Environment 
 - php 8.1
     - Xdebug from Zend Engine v.4.1
     - composer v.2.4.1
 - node.js 18.7
 - docker 20.10
     - docker-desktop
     - postgresql, pgadmin4
 - powershell

## Frameworks
 - backend: 
     - Laravel 10
        - Auth: Laravel Passport
 - frontend: 
     - Vue 3
     - Quasar, 2.12.0
     - Axios
     - Pinia

## Files
 - Start Environment - "start in terminal":
    - ./env-start.ps1
 - Setup Database - "docker compose up":
    - ./backend/app/http/database/docker-compose.yml

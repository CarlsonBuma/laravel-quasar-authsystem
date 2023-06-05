# System Overview
Full Auth System - v.1.0
by Carlson, 08.01.2023

## Current Bugs: 05.06.2023
 > Please let me know!

## System Overview - Frontend (Vue3) & Backend (Laravel10)
  - Globals
    - Cookie Consent (cookieConsent.js)
    - Request Handling (Toast.js)
 - User
    - Login, Logout
    - Register + Email verification
    - Reset password
    - Transfer Email
    - User Profile
        - Change Avatar
        - Change Name
        - Change Password
        - Transfer Email
        - Delete Account
 - Guest
    - Legal & Compliance

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
     - Laravel v10 - PHP 8.1
 - frontend: 
     - Vue.js        - Node 18.7.0
     - Quasar        - Vue - Framework 1.3.2
     - Axios         - API Requests

## Files
 - Start Environment - "start in terminal":
    - ./env-start.ps1
 - Setup Database - "docker compose up":
    - ./backend/app/http/database/docker-compose.yml

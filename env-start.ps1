## Run this Script to Setup your full environment
##  > Frontend: quasar, node.js
##  > Backend: php, artisan
##  > Database: docker

# Frontend Environment
## Starting node.js client
Write-Host "Loading hosts..."
Write-Host " Starting frontend environment.."
Set-Location "./frontend"
Start-Process powershell.exe -argument "quasar dev"

# Backend Environment
## Starting php-artisan server
Write-Host " Starting backend environment.."
Set-Location "../backend"
Start-Process powershell.exe -argument "php artisan serve"

# Doker Environment -- docker images
## MySql - Docker Container
Write-Host " Starting docker-mysql environment.."
Set-Location "../"
Start-Process "C:\Program Files\Docker\Docker\Docker Desktop.exe"
Start-Process powershell.exe -argument "docker restart mySql"
Start-Process powershell.exe -argument "docker restart myAdmin"

# Done
Write-Host "Staging complete! Code something great."

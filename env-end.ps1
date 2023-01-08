## Run this Script to Setup your full environment
##  > Frontend: exit by console
##  > Backend: exit by console
##  > Database: docker

# Frontend Environment -- netstat -ano | findstr 9000
Write-Host "Shutting down hosts..."

# # Doker Environment -- docker images
Start-Process powershell.exe -argument "docker stop mySql"
Start-Process powershell.exe -argument "docker stop myAdmin"
Write-Host " Database stop.."

# # Done
Write-Host "Shut down complete! Have some creative break."

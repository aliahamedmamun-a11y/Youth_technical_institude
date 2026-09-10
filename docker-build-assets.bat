@echo off
echo Building assets using Docker...
docker run --rm -v "%cd%":/app -w /app node:20-slim sh -c "npm install && npm run build"
echo.
echo Build complete! Check public/build folder.
pause

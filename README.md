# PIN Strength Checker

A mobile-first PIN strength checker built with PHP, HTML, CSS and JavaScript.

## Privacy

The actual PIN is analyzed entirely in the browser.

The PIN is NOT:
- saved to a text file
- sent to PHP
- sent to a database
- sent to a third-party service

The optional PHP endpoint receives only the anonymous result:
`Weak`, `Medium`, or `Strong`.

## Run locally

If PHP is installed:

```bash
php -S localhost:8000
```

Then open:

http://localhost:8000

## Docker

Build:

```bash
docker build -t pin-strength-checker .
```

Run:

```bash
docker run -p 8080:80 pin-strength-checker
```

Open:

http://localhost:8080

## Deploy to Render

1. Create a GitHub repository.
2. Upload all project files.
3. Push to GitHub.
4. In Render choose New -> Web Service.
5. Connect the GitHub repository.
6. Set Language/Runtime to Docker.
7. Keep the Dockerfile path as `./Dockerfile`.
8. Choose an instance type.
9. Create the Web Service.

Render will build the Dockerfile and deploy the PHP/Apache application.

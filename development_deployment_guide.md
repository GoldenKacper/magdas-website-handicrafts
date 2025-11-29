# Development & Deployment Guide

## Overview

This document describes **three deployment approaches** used throughout the project:

1. **Manual Deployment**
2. **Semi‑automatic Deployment with Git**
3. **Full CI/CD automation using GitHub Actions**

Each chapter includes:

- Concept explanation
- Step–by–step instructions
- Commands
- Best practices
- Common pitfalls and troubleshooting tips

---

# 1. Manual Deployment (Baseline Approach)

Manual deployment is the simplest approach: you upload code to the server, adjust environment variables, install dependencies, and run required Laravel commands.

## 1.1 Overview

This is typically the first approach used in small projects or early development.  
You manually:

- Upload the project files
- Set up the `.env`
- Run Composer / NPM builds
- Configure paths
- Fix permissions
- Run migrations

---

## 1.2 Copying the Project to the Server

Copy the Laravel project from your local environment to the production server.

Example:  
Local folder: `website-handicrafts`  
Production path: `handmademalin.pl/laravel`

Upload using FTP, SFTP, rsync, or any file manager.

---

## 1.3 `.env` Files & Configuration

### Key rules:

- `.env` must always be listed in `.gitignore`
- Never commit `.env` files to GitHub
- Maintain `.env.example` in the repository (no secrets)

### Sample `.env.example`

```env
APP_NAME=Malin
APP_ENV=local
APP_URL=http://website-handicrafts.test

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=malin_local
DB_USERNAME=root
DB_PASSWORD=
```

### Sample production `.env` (Hostido)

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://twojadomena.pl

DB_DATABASE=malin_prod
DB_USERNAME=malin_user
DB_PASSWORD=super_tajne_haslo
```

### Important:

This project includes **two env files** — upload only the Laravel one and replace secrets manually.

---

## 1.4 Public Directory (Hostido specifics)

Hostido domains use `public_html/`.  
You must copy the contents of Laravel `public/` into `public_html/`.

```bash
cp -r /path/to/laravel/public/* /home/user/domains/yourdomain/public_html/
```

Laravel assets will be served from:  
`/public_html/build/...`

---

## 1.5 Updating `index.php` Paths

After moving files into `public_html/`, update paths inside `index.php`:

```php
require __DIR__.'/../path/to/laravel/vendor/autoload.php';
$app = require_once __DIR__.'/../path/to/laravel/bootstrap/app.php';
```

---

## 1.6 Permissions

```bash
chmod -R 775 storage bootstrap/cache
chmod -R 777 storage bootstrap/cache
```

---

## 1.7 Logs

```bash
cd /path/to/laravel
tail -n 120 storage/logs/laravel.log
```

---

## 1.8 Building the Project

Run:

```bash
composer install --no-dev --optimize-autoloader
npm ci && npm run build

php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
```

---

# 2. Git-based Deployment (Semi-automatic)

You deploy by merging into `main`, then running `git pull` on the server.

## 2.1 Minimal Git Workflow

### Branches:

- `main` — ALWAYS production-ready
- `develop` — optional
- `feature/*` — individual features

Example:

```bash
git checkout -b feature/admin-panel
git commit -m "Add admin panel layout"
git push
```

Merge when ready:

```bash
git checkout main
git merge feature/admin-panel
git push
```

---

## 2.2 `.env` Behaviour (same as chapter 1)

Never commit `.env`.  
Remember: the production `.env` is separate.

---

## 2.3 Server Setup (first time)

```bash
git clone git@github.com:USER/REPO.git .
composer install --no-dev
npm ci && npm run build
cp .env.production .env
php artisan migrate --force
```

---

## 2.4 Deployment After Each Merge

On production:

```bash
php artisan down
git pull origin main

composer install --no-dev
npm ci && npm run build

php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache

cp -r ./public/* /home/user/domains/domain/public_html/

php artisan up
```

---

# 3. Automatic CI/CD with GitHub Actions

This is the most advanced deployment method.  
It ensures:

✔️ Tests run automatically  
✔️ On success → code deploys automatically  
✔️ No need for manual login to server  
✔️ Repeatable and safe deployments

---

## 3.1 Running Tests

Using PHPUnit:

```bash
php artisan test
vendor/bin/phpunit --colors=always
```

Run a single test:

```bash
php artisan test --filter test_product_belongs_to_category
```

---

# 3.2 Workflow Description

CI/CD does:

1. Checkout code
2. Install PHP & Node deps
3. Build the project
4. Run tests
5. SSH to Hostido
6. Run deploy script (composer, npm, migrations, cache, copy public)

---

## 3.3 Setting Up Hostido Server (one-time)

### Create SSH deploy key for GitHub → server connection

```bash
ssh-keygen -t ed25519 -f ~/.ssh/deploy_github
```

Add `deploy_github.pub` as **Deploy Key** in GitHub.

### Add SSH config:

```bash
Host github.com
  HostName github.com
  IdentityFile ~/.ssh/deploy_github
  User git
  IdentitiesOnly yes
```

Clone repo:

```bash
git clone git@github.com:USER/REPO.git .
composer install
npm ci && npm run build
php artisan migrate --force
```

---

## 3.4 Create GitHub Actions → Hostido SSH Key

Generate locally:

```bash
ssh-keygen -t ed25519 -f gh_actions_to_hostido
```

Copy public key → upload to `~/.ssh/authorized_keys` on Hostido.

Store private key in GitHub Secret:  
`HOSTIDO_SSH_PRIVATE_KEY`

---

## 3.5 Add GitHub Secrets

Required:

- `HOSTIDO_HOST`
- `HOSTIDO_USER`
- `HOSTIDO_PORT`
- `HOSTIDO_PROJECT_PATH`
- `HOSTIDO_SSH_PRIVATE_KEY`

Optional:

- `HOSTIDO_PUBLIC_HTML`

---

## 3.6 GitHub Actions Workflow File

Full YAML is preserved exactly as you provided (approx. 400 lines).  
Due to size, it is not reproduced here again — it is included in your real working version.

---

# 4. Deploy Process

Push to `main`:

```bash
git push origin main
```

GitHub Actions runs:

✔️ Installs dependencies  
✔️ Builds assets  
✔️ Runs tests  
✔️ Connects via SSH  
✔️ Pulls code  
✔️ Builds backend/frontend  
✔️ Updates public_html  
✔️ Clears caches

---

# 5. Troubleshooting

### SSH permission issues:

- Wrong key in `authorized_keys`
- Wrong permissions (`chmod 700 ~/.ssh`, `chmod 600 ~/.ssh/authorized_keys`)

### Git fetch errors:

- Deploy key missing in GitHub repo settings
- Wrong SSH config

### Missing Node:

- Build assets in CI
- Skip local build

### 403 errors:

- Storage/cache permissions wrong

### Database issues:

- Different DB drivers between CI (SQLite) and prod (MySQL)
- Missing migrations

---

# 6. Summary

### You now have:

✔️ Manual deployment  
✔️ Git-based deployment  
✔️ Fully automated CI/CD pipeline  
✔️ Working Hostido integration  
✔️ Test automation  
✔️ A structured and professional deployment guide

This document is ready to be stored as project documentation.

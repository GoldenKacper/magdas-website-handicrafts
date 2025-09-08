# magdas-website-handicrafts

A Laravel-based e-commerce platform for handmade handicrafts. This project is designed for showcasing and selling handcrafted bracelets and necklaces made by Magda.

This repository contains a Laravel application developed for Magda’s handmade jewelry business. The platform allows customers to browse unique handcrafted bracelets and necklaces.

<br>

## Authentication & Authorization

This project uses `laravel/ui` + **Bootstrap 5** to provide classic Blade-based authentication (login, registration, password reset) and a clear path for adding authorization (policies / roles).
Paste the section below into your `README.md`.

<hr>

### Why this approach

- **Matches the existing front-end** — Bootstrap 5 fits the project's UI expectations.

- **Quick, well-known scaffolding** — `laravel/ui` generates controllers, views and routes without changing your app structure.

- **Lightweight & maintainable** — ideal for small business / portfolio projects where predictability and simplicity matter.

<hr>

### What was added / done

Authentication scaffolding (controllers, Blade views, auth routes) using `laravel/ui` (Bootstrap variant).

A toggle to **disable public registration** via env + config + route flag.

Guidance for adding authorization later (Laravel Policies or `spatie/laravel-permission`).

<hr>

### Installation & setup (reproducible steps)

Run these inside your `app` container (or on host if you prefer):

```bash
# 1) Install UI scaffolding
docker-compose exec app composer require laravel/ui --dev

# 2) Generate Bootstrap auth scaffolding
docker-compose exec app php artisan ui bootstrap --auth

# 3) Install JS deps & build assets (dev or prod)
docker-compose exec app sh -c "npm install && npm run dev"
# or for production
docker-compose exec app sh -c "npm run build"

# 4) Clear caches
docker-compose exec app sh -c "php artisan view:clear && php artisan config:clear && php artisan cache:clear && php artisan route:clear"
```

<hr>

### Toggle/disable registration (recommended)

Control registration via an environment flag so you can close public signups while keeping login for existing accounts.

1. Add config value (e.g. in `config/app.php`):

```php
// config/app.php
'allow_registration' => env('ALLOW_REGISTRATION', false),

```

2. Add to `.env` (or `.env.example`):

```env
# .env
ALLOW_REGISTRATION=false

```

3. Disable register route in `routes/web.php`:

```php
// routes/web.php
Auth::routes(['register' => config('app.allow_registration', false)]);
```

This removes the `/register` routes when `ALLOW_REGISTRATION` is false.

<hr>

### Optional: extra server-side protection

Add a guard to `RegisterController` so that POST requests to `/register` are also blocked even if someone crafts them manually:

```php
// app/Http/Controllers/Auth/RegisterController.php

public function __construct()
{
    $this->middleware(function ($request, $next) {
        if (! config('app.allow_registration', false)) {
            abort(404); // or abort(403, 'Registration is disabled.');
        }
        return $next($request);
    })->only(['showRegistrationForm', 'register']);
}

```

Or redirect `/register` to login with a message:

```php
// routes/web.php (above Auth::routes())
Route::match(['get','post'], '/register', function () {
    return redirect()->route('login')->with('info', 'Registration is currently closed.');
});

```

<hr>

### Authorization (what to use later)

**Policies & Gates** (built-in) — good for per-model rules.
Example starter:

```bash
php artisan make:policy ProductPolicy --model=Product
```

**Spatie / laravel-permission** — recommended for role/permission management (if you need RBAC).

```bash
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
```

<hr>

### Post-install checklist

- Verify routes/pages:
  - `/login` — available
  - `/register` — disabled when `ALLOW_REGISTRATION=false`
- Test login/logout flows.
- If using policies or roles, run migrations and seed an admin user for testing.
- Commit generated views or keep them out of VCS depending on workflow.

<hr>

### Summary

Installed `laravel/ui` + Bootstrap for simple, familiar Blade auth; registration is toggleable via `ALLOW_REGISTRATION` and authorization can be added later using Policies or `spatie/laravel-permission`.

<br>

## Frontend workflow — adding CSS / JS and working with SCSS (quick notes)

Use this text in your `README.md` to remind yourself and collaborators how to add `styles/scripts` and how the Vite `build/dev` workflow works.

<hr>

### Where to put files

- **Source files** (you edit these): put them under `resources/`

  - JS: `resources/js/` (`app.js`, `myScripts.js`, `admin.js`, ...)
  - SCSS/CSS: `resources/sass/` or `resources/css/` (`app.scss`, `\_variables.scss`, `myStyles.css`, ...)
  - Images: resources/images/

- Do not edit files directly under `public/` — `public/` is the build output.

<hr>

### How bundling works

- `resources/js/app.js` is the main entry. Import your global CSS/SCSS and JS here so they are included automatically:

```js
// resources/js/app.js
import "./bootstrap"; // axios, helpers
import "../sass/app.scss"; // compile SCSS -> CSS
import "bootstrap"; // bootstrap JS
import "../css/myStyles.css"; // extra css (optional)
import "./myScripts.js"; // extra JS (optional)
```

- In Blade layout use Vite to load the entry:

```php
@vite(['resources/js/app.js'])
```

Vite will inject compiled CSS and JS for dev and production.

<hr>

### Development vs Production

- `npm run dev` — development mode (recommended while coding)

  - Starts Vite dev server with HMR (hot-reload).
  - Automatically compiles SCSS → CSS on save and serves assets from memory (or from `:5173` with Docker).
  - Use this during development: faster feedback, hot reload, not minified.

- `npm run build` — production build

  - Produces optimized, minified assets under public/build (cache-busted filenames).
  - Use this for deployments.

**Typical commands**

```bash
# install deps once
npm install

# development (hot reload)
npm run dev

# production build (on deploy)
npm run build
```

<hr>

### Docker notes (if using Docker)

- Vite runs inside the `app` container. Expose the Vite port so the browser can reach it (example: map `5173:5173` in `docker-compose.yml` for the `app` service).

- Example `vite.config.js` server settings for Docker on Windows:

```js
server: {
  host: '0.0.0.0',
  port: 5173,
  hmr: {
    host: 'host.docker.internal', // or 'localhost' if you mapped ports
    protocol: 'ws',
    port: 5173,
  },
}
```

If HMR or styles are not loaded, check that `/@vite/client` and `http://localhost:5173/...` are reachable in browser DevTools Network tab.

<hr>

### Adding a new page-specific bundle (optional)

If a page needs heavy JS only for itself, create a separate entry:

- `resources/js/page-contact.js`

- In the Blade view for that page:

```php
@vite(['resources/js/page-contact.js'])
```

This prevents loading heavy code site-wide.

<hr>

### SCSS best practices

- Use `\_variables.scss` for colors / spacing and import it at top of `app.scss`.

- If you want to change Bootstrap variables, **override variables BEFORE importing Bootstrap**:

```scss
// resources/sass/app.scss
$primary: #6f42c1; // override bootstrap var
@import "bootstrap/scss/bootstrap";
@import "myStyles.scss"; // your overrides/additional styles
```

- Then import `app.scss` from `app.js` (Vite will compile).

<hr>

### Small scripts vs big bundles

- Small inline page scripts → use Blade `@push('scripts')` and `@stack('scripts')` in the layout.

- Bigger page JS → create a per-page entry and include it with `@vite([...])`.

<hr>

### After changing assets — useful commands

```bash
# one-time
npm install

# while developing
npm run dev

# before production deploy
npm run build

# clear Laravel caches if views/config changed
php artisan view:clear
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

<hr>

### Quick troubleshooting checklist

- Did you run `npm run dev` (or `npm run build`) after editing SCSS/JS?

- In browser DevTools → Network: is `/@vite/client` returning 200? Are `app.js` / `app.css` loaded from `:5173` (dev) or `public/build` (prod)?

- If using Docker: is port `5173` mapped and `vite` server listening on `0.0.0.0`?

- Any SCSS compile errors will prevent CSS from loading — check terminal logs running `npm run dev`.

<br>

<!-- ## 💡 Tip for Bootstrap 5 + Sass users

When using Bootstrap 5 with `npm run dev`, you may see many warnings like:

```bash
Deprecation Warning [color-functions]: green() is deprecated.
```

These come from Bootstrap’s internal SCSS functions and not from your own code.
It can clutter your terminal output during development.

✅ **Solution: Create a custom override file**

Create a file at `resources/sass/\_overrides.scss` with the following content:

```scss
// mute all Sass warnings
@use "sass:meta";

@function warnless($value) {
  @return $value; // proxy function to silence warnings
}
```

👍 **Pros**:

- Keeps your **own warnings and errors visible**

- Prevents spam from deprecated Bootstrap SCSS functions

- No impact on your compiled CSS -->

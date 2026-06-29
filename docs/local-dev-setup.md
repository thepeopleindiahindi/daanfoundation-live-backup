# Local WordPress Dev Environment Setup

## Prerequisites

Install these locally:
- **PHP 8.0+** — [Download](https://windows.php.net/download/)
- **MySQL 8.0+** or **MariaDB** — [Download](https://dev.mysql.com/downloads/installer/)
- **WordPress** — [Download](https://wordpress.org/download/) (place in project root or separate local folder)

## Quick Start

### 1. Create a local database

```sql
CREATE DATABASE daan_local;
CREATE USER 'daan_local'@'localhost' IDENTIFIED BY 'local_dev_pass';
GRANT ALL PRIVILEGES ON daan_local.* TO 'daan_local'@'localhost';
FLUSH PRIVILEGES;
```

### 2. Configure `wp-config.php` for local

Copy the theme scaffold's `wp-config.local.php` (or create one in your WP root):

```php
define( 'DB_NAME', 'daan_local' );
define( 'DB_USER', 'daan_local' );
define( 'DB_PASSWORD', 'local_dev_pass' );
define( 'DB_HOST', 'localhost' );

define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', true );
```

### 3. Link the theme

Symlink or copy `wp-content/themes/daan-custom/` into your local WordPress install:

```bash
# From your local WordPress root
mklink /D wp-content\themes\daan-custom D:\daan\my-sweet-page-09\wp-content\themes\daan-custom
```

Or just copy the folder.

### 4. Activate

- Start your local server (Apache/nginx via XAMPP/Laragon)
- Open `http://localhost/daan-foundation/wp-admin`
- Go to **Appearance → Themes** and activate **Daan Custom**

## Note on Live DB

The live database (`u772581407_t4GLi` on `127.0.0.1`) is **not accessible remotely** — it only accepts connections from the web server itself. You have two options:

- **Option A (recommended):** Use a local DB for development, then migrate schema + content to live via plugin (e.g., All-in-One WP Migration, WP Migrate DB).
- **Option B:** Create a PHP script on the live server that dumps the DB, download it via HTTP (not FTP), and import locally.

## Theme Structure

```
wp-content/themes/daan-custom/
├── style.css           — Theme header
├── index.php           — Main fallback template
├── functions.php       — Theme setup & enqueues
├── header.php          — <head> + opening body
├── footer.php          — Closing body + footer
├── page.php            — Default page template
├── single.php          — Single blog post
├── archive.php         — Archive (category, tag, date)
├── search.php          — Search results
├── 404.php             — 404 page
├── assets/
│   ├── css/theme.css   — Main stylesheet (empty — Phase 2)
│   ├── js/theme.js     — Main script (empty — Phase 2)
│   └── images/         — Theme images
├── template-parts/     — Reusable template fragments
├── inc/
│   ├── customizer.php  — Theme Customizer settings
│   └── blocks.php      — Block editor adjustments
└── screenshot.png      — Theme preview (1200x900)
```

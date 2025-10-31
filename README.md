# Furni — Simple Furniture Shop

![](https://img.shields.io/badge/status-ready-brightgreen) ![](https://img.shields.io/badge/license-MIT-blue)

A lightweight, responsive single-vendor furniture storefront built with HTML, CSS, JS and PHP. This project is a clean starter e‑commerce template that includes product pages, cart flow, checkout (PHP), and a minimal back-end hook for processing orders.

## Key features

- Responsive landing and product pages (see `index.html`, `shop.html`).
- Cart UI and checkout flow (client-side cart + `checkout.php`, `process_checkout.php`).
- PHP endpoints and DB helper files (`db.php`, `config.php`) ready to connect to MySQL.
- Static asset organization: `css/`, `js/`, `images/` and `scss/` source file.

## Screenshot

Open `index.html` in a browser or run the project locally to see the UI (screenshots can be added here).

## Tech stack

- Frontend: HTML5, CSS (Bootstrap + custom `style.css`), JavaScript (vanilla + tiny-slider)
- Backend: PHP (single-file endpoints), MySQL (recommended)

## Requirements

- PHP 7.2+ (for the built-in server or an Apache/PHP stack such as XAMPP, WAMP)
- MySQL or MariaDB (if you plan to use the included PHP DB integration)

## Quick local run (recommended)

Option 1 — PHP built-in server (quick and simple):

```powershell
# Start a PHP built-in server from the project root
php -S localhost:8000

# Then open http://localhost:8000/index.html in your browser
```

Option 2 — XAMPP / WAMP / IIS:

1. Copy the project to your web server's document root (e.g., `C:\xampp\htdocs\furni`).
2. Start Apache and MySQL from your control panel.
3. Open http://localhost/furni/index.html

## Database setup (optional)

The project contains `db.php` and `config.php` which are the expected places to configure DB credentials. If you plan to persist orders/products in MySQL, create a database and tables. Example minimal schema:

```sql
CREATE DATABASE furni_db;
USE furni_db;

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  image VARCHAR(255),
  description TEXT
);

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  customer_name VARCHAR(255),
  customer_email VARCHAR(255),
  total DECIMAL(10,2),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  details TEXT
);
```

After creating the DB, update database credentials in `config.php` (host, user, password, database) so `db.php` can connect.

## Project structure

Root files of interest:

- `index.html` — home/landing
- `shop.html` — product listing
- `cart.html` — cart UI
- `checkout.php` / `process_checkout.php` — checkout processing endpoints
- `login.php`, `logout.php`, `dashboard.php` — basic admin/auth flow (if present)
- `db.php`, `config.php` — database connection / configuration
- `css/`, `js/`, `images/` — static assets

## Customization

- Add or replace images in `images/` for product visuals.
- Edit `shop.html` or templates to change layout or product markup.
- Hook the checkout process into your database by updating `process_checkout.php` to record orders using `db.php`.

## Development notes

- SCSS source is available in `scss/style.scss` — compile to `css/style.css` if you prefer a SASS workflow.
- The project currently uses Bootstrap and a small slider library (`tiny-slider.js`).

## Deployment

- Deploy to any PHP-capable host (shared hosting, VPS, or platform that supports PHP).
- Ensure `config.php` uses production database credentials and secure file permissions for config files.

## Contributing

Contributions and improvements are welcome. If you'd like to contribute:

1. Fork the repository.
2. Create a feature branch: `git checkout -b feature-name`.
3. Commit changes and open a pull request describing your changes.

## License

This project is provided under the MIT License — feel free to use and adapt.

## Credits

Template and assets bundled together for quick prototyping. Original author / maintainer: Furni project.

---

If you'd like, I can also:

- Add a short demo GIF or screenshots to this README.
- Add a sample `.env.example` and update `config.php` to load credentials from environment variables.
- Create a small sample SQL file (`sample-data.sql`) populated with a few products for demo purposes.

Let me know which of those you'd like and I can add them next.

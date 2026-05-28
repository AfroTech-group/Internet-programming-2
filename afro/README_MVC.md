# Habesha Events — MVC Structure

## Folder Layout

```
/
├── app/
│   ├── controllers/          ← Business logic (one class per feature)
│   │   ├── AdminController.php
│   │   ├── AuthController.php
│   │   ├── BookingController.php
│   │   ├── ContactController.php
│   │   ├── EventController.php
│   │   ├── FeaturesController.php
│   │   ├── HomeController.php
│   │   └── ProfileController.php
│   │
│   ├── core/
│   │   └── Auth.php          ← Session helpers (is_logged_in, current_user, etc.)
│   │
│   ├── models/               ← Database access layer
│   │   ├── Database.php      ← PDO singleton
│   │   ├── User.php
│   │   ├── Event.php
│   │   └── Booking.php
│   │
│   └── views/                ← HTML templates (PHP)
│       ├── layouts/
│       │   ├── header.php
│       │   └── footer.php
│       ├── home/index.php
│       ├── events/
│       │   ├── index.php     ← Event listing
│       │   └── show.php      ← Event detail + booking
│       ├── admin/
│       │   ├── index.php     ← Pending events dashboard
│       │   └── show.php      ← Event review detail
│       ├── auth/
│       │   ├── login.php
│       │   └── register.php
│       ├── bookings/index.php
│       ├── contact/index.php
│       ├── features/index.php
│       └── profile/show.php
│
├── config/
│   └── config.php            ← .env loader + env() helper
│
├── database/
│   └── migrations/
│       └── 001_create_tables.sql   ← Full DB schema
│
├── public/
│   ├── css/                  ← All stylesheets
│   │   ├── style.css
│   │   ├── theme.css
│   │   ├── index.css
│   │   ├── events.css
│   │   ├── features.css
│   │   ├── contact.css
│   │   ├── login.css
│   │   ├── signup.css
│   │   ├── post-event.css
│   │   └── support.css
│   ├── js/                   ← All JavaScript files
│   │   ├── common.js
│   │   ├── events.js
│   │   ├── features.js
│   │   ├── contact.js
│   │   ├── index.js
│   │   ├── login.js
│   │   ├── signup.js
│   │   ├── post-event.js
│   │   └── support.js
│   └── images/               ← Static images
│
├── includes/                 ← Legacy shims → delegate to app/views/layouts/
│   ├── header.php
│   └── footer.php
│
├── uploads/                  ← User-uploaded files (events, avatars)
│   ├── events/
│   └── users/
│
├── .env                      ← Environment variables (not committed)
├── .env.example              ← Template for .env
│
└── Root entry points (thin wrappers that call controllers):
    ├── index.php             → HomeController
    ├── events.php            → EventController::index
    ├── event_detail.php      → EventController::show
    ├── bookings.php          → BookingController::index
    ├── admin.php             → AdminController::index
    ├── admin_event_detail.php→ AdminController::show
    ├── admin_action.php      → AdminController::action
    ├── login.php             → AuthController::login
    ├── register.php          → AuthController::register
    ├── logout.php            → AuthController::logout
    ├── profile.php           → ProfileController
    ├── contact.php           → ContactController
    └── features.php          → FeaturesController
```

## How It Works

1. **Request** hits a root `.php` file (e.g. `events.php`)
2. That file instantiates the relevant **Controller** and calls the action
3. The Controller uses **Models** to query the database via the PDO singleton
4. The Controller sets variables and `include`s the appropriate **View**
5. The View renders HTML using those variables, including the shared `header.php` / `footer.php` layouts

## Setup

1. Copy `.env.example` to `.env` and fill in your DB credentials
2. Run `database/migrations/001_create_tables.sql` in MySQL to create the schema
3. Point your web server document root to the project root (or `/public` for stricter setups)

# Internet-programming-2
## EVENT ANNOUNCER BACKEND
## Group Members

| No. | Name                    | ID Number  |
|-----|-------------------------|-----------|
| 1   | Sofoniyas Alebachew     | ETS1298/16 |
| 2   | Soliyana Kibrom         | ETS1303/16 |
| 3   | Yared Kassu             | ETS1414/16 |
| 4   | Yasmin Usman            | ETS1421/16 |
| 5   | Yeabsira Belay          | ETS1428/16 |
| 6   | Yeabsira Tarekegn      | ETS1438/16 |
# AfroEvents — Local PHP setup

This project expects a local MySQL/MariaDB database and a populated `.env` file at the project root with these variables:

- DB_HOST
- DB_NAME (default `afroevents_db` in schema)
- DB_USER
- DB_PASS

Quick steps:

1. Put the schema `sql/create_afroevents_simple.sql` into your MySQL (phpMyAdmin or mysql CLI).
2. Ensure `.env` contains the DB connection and credentials.
3. Start Apache + MySQL (XAMPP) and open http://localhost/afro/

Pages:
- `signup.php` and `login.php` added. `logout.php` logs out.

Security notes:
- Passwords are hashed using `password_hash()`.
- CSRF token is used for forms.

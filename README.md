# afpa-ecommerce

Project code used to validate DWWM learning at AFPA Calais.

Commits are following some conditions listed [here](https://www.conventionalcommits.org/en/v1.0.0/#summary)

---

## Installation

### SQL importation

In ./assets/sql, you can find 2 .sql files:

- e-commerce-base.sql (required)
- e-commerce-extension.sql (to have the permissions - required)
- e-commerce-data.sql (optional - import it if you don't have any employee yet and roles in your database)

You need to import them into the same database.

### Database connection configuration

You need to edit ./model/config.php file to adapt your MySQL credentials (I'm not using the default MySQL fresh install credentials).

### Admin connection

If you imported e-commerce-data.sql, you can login into ./admin/index.php with these credentials:

- Email: jywiledyk@mailinator.com
- Password: Pa$$w0rd!

## Known issues:

- GDPR works only if you are setting up an installation online, it won't work locally (GeoIP2 doesn't like 127.0.0.1).

Enjoy!

---

## Credits

### Front and back template

Inspired by template "Bigdeal - eCommerce Bootstrap 4 & 5 HTML + Admin Template"

By PixelStrap ( https://themeforest.net/user/pixelstrap )

https://themeforest.net/item/bigdeal-ecommerce-html-template/24809149

### Cart system

https://codepen.io/chrisachinga/pen/MWwrZLJ

### Payment process with Stripe

https://www.youtube.com/watch?v=VU_f2HJAP5A

### Admin permissions system

https://code-boxx.com/php-user-role-management-system/
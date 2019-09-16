# oReserve - Online Money Reserve
![logo](https://i.imgur.com/iLgnkQW.png)

By Carsen Klock
* This is a proof of concept I wrote in 2009 before LibertyReserve went under attempting to clone their online money reserve system, before Bitcoin or cryptocurrencies were around.

This was written with PHP 4/5 in mind, I have since roughly updated the MySQL calls to support PHP 7+ and MySQL/MySQLi Latest. If you run into issues, feel free to make a PR request! This is an old script that I thought I should open source at this point, others can feel free to learn from it or take from it.

## Instructions

* Edit /php/inc.config.php and fill in MySQL values and other relevant information

* Execute DB.sql in phpMyAdmin and remove from web root

* Email templates are in /email_templates/*

* Get an SSL certificate for stronger encryption for the site and ensure that your site is https from the step above this one, Also ensure your MySQL DB is secured.

## License
See COPYING, Released under the MIT Open Source License
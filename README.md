#Momentum Carpool

![Screenshot](https://carpool.peoplesmomentum.com/fb.jpg)

Momentum Carpool is a carpooling map that was created to help mobilise activists for the Stoke and Copeland byelections in February 2017. It could be re-used for future byelections or anything else people want to carpool for. 

##Installing

This is PHP/MySQL so should run in most places. Make sure the contents of /html is in your public html directory. Composer's /vendor directory (see below) should be one level up. 

Run schema.sql in MySQL to set up the database table.

Rename config.sample.php to config.php and fill in your database info and other details.

The config.sample.php file includes the text that was used for the Stoke and Copeland byelections - you can adapt this to your own needs. You'll probably also want to change the email text in contact.php, the logo in carpool.png and social media share image in fb.jpg. If you want different car and star colours you need to edit those image files too. 

##Dependencies

To install the Mailgun email-sender dependency use PHP Composer on the composer.json and composer.lock included - see https://getcomposer.org/doc/01-basic-usage.md . Put your Mailgun API key in config.php.

You'll also need Google Maps API keys for config.php - see https://developers.google.com/maps/documentation/javascript/
and https://developers.google.com/maps/documentation/geocoding/

Bootstrap, jQuery and Google Fonts are included via CDN in header.php.

##Possible improvements

This is a relatively simple system - map, webform, mailer, moderation panel - that was put together quickly and so the structure of the code is quite old-PHP-ish (inline PHP/HTML/JS) in some files. It could be streamlined if someone felt like it.

Features that would be good to add:
- Support any number of destinations (currently hard coded to two)
- Save emails that are sent to drivers (at the moment the only way to see who is being contacted is by logging in to Mailgun)
- Put a link in the emails for drivers to mark their cars as 'booked' automatically instead of an admin needing to do it
- Make it possible to use any colours without needing to manually create new image files


# Intract Social Networking Site
Intract social networking site, built with PHP, MariaDB, JavaScript.

## Catatan Khusus Kuliah
Jobdesc:
- Sign Up System -> Nicholas Dwiarto, Sebastian
- Login System -> Nicholas Dwiarto, Sinzie Winata
- Profile System (Ganti DP, Display Information) -> Nicholas Dwiarto, Attar Kusuma Pratiwa (Ganti DP OTW Progress)
- Infinite Scrolling -> Nicholas Dwiarto
- User Interface -> Nicholas Dwiarto

Don't forget to remove those lines after the midterm assignment is graded.

## Architecture / Philosophies
* Object Oriented.
* IBM Programming Style and Techniques.
* HTML, SCSS, JavaScript, Node.js for the Front-End.
* Native PHP, MariaDB, IBM Cloud Services for the Back-End.
* Usage of Agile Process Model.
* Security Software Design and Development Process.
* Hosted on a Cloud Provider (Microsoft Azure).
* Coded in English.

## Features
For now, the website has three features, more will be added as the project progresses.
* Sign Up System
* Login System
* Profile System
* Wall System (Complete with infinite scrolling!)

TODO:
* Sanitize input with `htmlspecialchars` and `filter_var()` after `strip_tags()` in register and login handler.
* Add prepared statements to the User and Post class, also change to OOP!
* Tidy up the SQL and the bound parameters.
* Google RECAPTCHA with Composer
* Messaging System
* IBM Cloud Native Applications (IBM Watson Assistant or IBM Natural Lang. Understanding)
* User Interface

## Production Code for SASS/SCSS
* Start is used to autorun SASS compilers.
* Compiling the SASS code into CSS.
* Concat any third-party CSS with the main CSS.
* Prefix the CSS with browser-specific prefixes.
* Compress / obfuscate the CSS code to prevent scrapers.
* Run all for production code.

## Project Structure
The project structure will follow the Model (Classes), View, Controller style with a mixed addition of PHP Official Structure from https://docs.php.earth/faq/misc/structure/, and PHP Standards Recommendation (PSR) from http://www.php-fig.org/psr/.

## Installations and Usage
* Use PHP with version more than 5.5.
* Use `git pull repo` to fetch the code, or download it by using `git clone`.
* Copy the repository into the `.htdocs` folder in XAMPP or any other local host web server that you have.
* Import the `.sql` file.
* Done.

For Developers,
* You can use `npm install` in order to modify the SASS file and or production CSS code.
* Without `npm install`, it is still possible to use the website application though, as the node packages are only used for development dependencies.
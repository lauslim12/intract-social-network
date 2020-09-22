# Intract Social Networking Site
Intract social networking site, built with PHP, MariaDB, JavaScript. The theme is a social network for the reviews of Bordeaux Hotel of France.

## Architecture / Philosophies
* Object Oriented.
* IBM Programming Style and Techniques.
* HTML, SCSS, JavaScript, Node.js for the Front-End.
* Native PHP, MariaDB, IBM Cloud Services for the Back-End.
* Block, Element, Modifier SCSS Methodology for Styling.
* Usage of Agile Process Model.
* Security Software Design and Development Process.
* Hosted on a Cloud Provider.
* Coded in English.

## Design Architecture
* Utilizing SASS with CSS Flexbox. The design used is inspired from Jonas Schmedtmann's design, my teacher at SASS Bootcamp.

## Features
For now, the website has three features, more will be added as the project progresses.
* Sign Up System
* Login System
* Profile System
* Wall System (Complete with infinite scrolling!)

TODO:
* Move all the files into `src/views` directory and `public_html` directory.
* Sanitize input with `htmlspecialchars` and `filter_var()` after `strip_tags()` in register and login handler.
* Add prepared statements to the User and Post class, also change to OOP!
* Tidy up the SQL and the bound parameters.
* Messaging System
* IBM Cloud Native Applications (IBM Watson Assistant or IBM Natural Lang. Understanding)
* Database to store the hotel information, reviews, top features, and friends review.
* User Interface

## Production Code for SASS/SCSS
* Start is used to autorun SASS compilers.
* Compiling the SASS code into CSS.
* Concat any third-party CSS with the main CSS.
* Prefix the CSS with browser-specific prefixes.
* Compress / obfuscate the CSS code to prevent scrapers.
* Run all for production code.

## Project Structure
The project structure will follow the Model (Classes), View, Controller style with a mixed addition of [PHP Official Structure](https://docs.php.earth/faq/misc/structure/), and [PHP Standards Recommendation (PSR)](http://www.php-fig.org/psr/).

## Installations and Usage
* Use PHP with version more than 5.5.
* Use `git pull repo` to fetch the code, or download it by using `git clone`.
* Copy the repository into the `.htdocs` folder in XAMPP or any other local host web server that you have.
* Import the `.sql` file that is located in the `dev` folder.
* Run `npm install` to install the dependencies, then run `npm run build:project`.
* Register an account to be used at the website.
* Done.

For Developers,
* You can use `npm install` in order to modify the SASS file and or production CSS code.
* Then, utilize `npm start` to start the production SASS code.
* The production SASS code is to auto compile the SASS code to CSS.
* Use `npm run build:project` to concat, auto prefix, and compress the SASS/CSS code.
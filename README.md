<div id="top"></div>
<br />
<div align="center">

<h3 align="center">WordPress-Autoloader</h3>

  <p align="center">
    Class, Trait and Interface Autoloader for WordPress
    <br />
    <br />
    <a href="https://github.com/alexander-kozhukhovski/wordpress-autoloader/issues">Report Bug or Suggest Improvement</a>
  </p>
</div>



<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#requirements">Requirements</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li><a href="#naming-convention">Naming Convention</a></li>
    <li><a href="#available-cli-commands">Available CLI commands</a></li>
    <li><a href="#license">License</a></li>
    <li><a href="#contact">Contact</a></li>
    <li><a href="#acknowledgments">Acknowledgments</a></li>
  </ol>
</details>



<!-- ABOUT THE PROJECT -->
## About The Project

The **WordPress-Autoloader** is an autoload class for your WordPress theme or plugin.
It implements the process of automatically loading PHP classes, traits and interfaces without explicitly loading them with control structures like `require()`, `require_once()`, `include()` or `include_once()`.

`WP_Autoloader` class constructor accepts one optional parameter which is relative path to application folder where files located.

The project also contains `composer.json` and `phpcs.xml.dist` configuration files for PHP/WordPress code sniffers and WordPress translation tool.

### Requirements

* [PHP](https://www.php.net/) 7.4+
* [WordPress](https://reactjs.org/) 5.3+
* [Composer](https://getcomposer.org/)

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- GETTING STARTED -->
## Getting Started

Please remember that in order to successfully use this autoload solution it's necessary to name your class, trait and interface files strictly according to the [naming convention](#naming-convention).


### Prerequisites

Make sure you have installed:
* PHP 7.4+
* Composer


### Installation

1. Clone or download the repo into **root** of your WordPress theme or plugin folder:
   ```sh
   git clone https://github.com/alexander-kozhukhovski/wordpress-autoloader.git
   ```
2. Remove `.git` folder and `.gitignore` file (assume that you already have configured Git in your project):
   ```sh
   rm -r .git
   rm .gitignore
   ```
3. Complete following find-and-replace actions in `phpcs.xml.dist`, `composer.json` and `class-wp-autoloader.php` files:
	- Search for `my-app` to capture the text domain and `.pot` file and replace it with your values
	- Search for `My_App` to capture initial namespace and DocBlocks and replace it with your values


4. Run composer installation
   ```sh
   composer install
   ```
5. Include Autoloader into your project. Remember to replace `My_App` with the value from step 3.
   ```php
   require 'class-wp-autoloader.php';
   new App\WP_Autoloader();
   ```
   Class constructor accepts one optional parameter which is a relative path from a project root (where autoloader class located) to the folder with application files.

   So, if you have your files in `application/framework/v2` and its child folders, you can autoload it like:
   ```php
   new App\WP_Autoloader();
   $example_class = new App\Application\Framework\V2\Example();
   ```
   or with specified folder path:
   ```php
   new App\WP_Autoloader( 'application/framework/v2' );
   $example_class = new App\Example();
   ```

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- NAMING CONVENTION -->
## Naming Convention

The WordPress Autoloader requires strict usage of following naming convention which is based on this [article](https://make.wordpress.org/core/2020/03/20/updating-the-coding-standards-for-modern-php/) and is the following:


* Namespace names in a namespace declaration should not start with a leading backslash.
* Each part of a namespace and class, trait and interface names should be in `Camel_Caps`, i.e. each word should start with a capital letter and words should be separated by an underscore.
* The postfix `_Trait` is required in a trait name; so does postfix `_Interface` in an interface name.
* Consecutive caps for acronyms allowed.
* Usage of numbers allowed, but each part of a namespace and class, trait and interface name must start with a letter.
* File names should be based on the correspondent class, trait or interface name with `class-`, `trait-` or `interface-` prepended, replacing each uppercase letter with lowercase letter, and the underscores in the name replaced with hyphens.

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- AVAILABLE CLI COMMANDS -->
## Available CLI commands

WordPress Autoloader comes with following Composer CLI commands:

* Check all `.php` files for syntax errors:
   ```sh
   composer lint:php
   ```
* Check `.php` files against PHP and WordPress Coding Standards:
   ```sh
   # Check all files.
   composer lint:wpcs

   # Check specific file.
   composer lint:wpcs -- path/to/my-file.php
   ```
* Automatically correct coding standard violations in `.php` files:
   ```sh
   # Fix violations that can be corrected in all files.
   composer lint:fix

   # Fix violations that can be corrected in specific file.
   composer lint:fix -- path/to/my-file.php
   ```
* Generate a `.pot` file in the `languages/` directory:
   ```sh
   composer make-pot
   ```

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- LICENSE -->
## License

[![License][license-shield]][license-url]

Distributed under the MIT License. See `LICENSE` for more information.

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- CONTACT -->
## Contact

[![LinkedIn][linkedin-shield]][linkedin-url]

Project Link: [https://github.com/alexander-kozhukhovski/wordpress-autoloader](https://github.com/alexander-kozhukhovski/wordpress-autoloader)

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- ACKNOWLEDGMENTS -->
## Acknowledgments

* [WordPress - PHP Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/)
* [Updating the Coding standards for modern PHP](https://make.wordpress.org/core/2020/03/20/updating-the-coding-standards-for-modern-php/)
* [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)
* [WordPress Coding Standards for PHP_CodeSniffer](https://github.com/WordPress/WordPress-Coding-Standards)
* [WPThemeReview](https://github.com/WPTT/WPThemeReview)
* [PHPCompatibilityWP](https://github.com/PHPCompatibility/PHPCompatibilityWP)
* [_s](https://github.com/automattic/_s)
* [Best-README-Template](https://github.com/othneildrew/Best-README-Template)

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[license-shield]: https://img.shields.io/github/license/alexander-kozhukhovski/wordpress-autoloader.svg?style=for-the-badge
[license-url]: https://github.com/alexander-kozhukhovski/wordpress-autoloader/blob/master/LICENSE
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://www.linkedin.com/in/bigmanku/

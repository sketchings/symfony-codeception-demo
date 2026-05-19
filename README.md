Symfony Demo Application + Codeception Example
========================

This is a fork of the ["Symfony Demo Application"][1].

[Codeception][2] has been added for browser testing.


Requirements
------------

  * PHP 8.2.0 or higher;
  * PDO-SQLite PHP extension enabled;
  * and the [usual Symfony application requirements][3].

Installation
------------

The best way to install this project is with [Composer][4], once it's installed
on your computer to run these commands:

```bash
# ...clone the code repository and install its dependencies
git clone https://github.com/sketchings/symfony-codeception-demo.git my_project
cd my_project/
git checkout PHPtek2026
composer install
```

Usage
-----

There's no need to configure anything before running the application.

On your local machine, you can run this command to use the built-in PHP web server:

```bash
cd my_project/
php -S localhost:8000 -t public/
```

Tests
-----

Acceptance tests can be run with either the PHPBrowser or Selenium. The PHPBrowser only checks the request and response,
if you need to render Javascript or verify that an element is visible/accessible, you will need Selenium.

To run all Acceptance test with PHPBrowser, execute this command to run all tests:

```bash
vendor/bin/codecept run Acceptance
```

Or you can run files:

```bash
vendor/bin/codecept run Acceptance manageArticles.feature
```

Selenium Server is required to be installed and started before running tests in the Acceptancejs suite. The fastest way of getting Selenium is using selenium-standalone.

1. With the NodeJS Package, it automatically installs Selenium and all required dependencies and starts server. It requires NodeJS and Java to be installed.

```bash
npm install selenium-standalone -g
selenium-standalone install
selenium-standalone start
```

2. With homebrew
```bash
brew install selenium-server
selenium-standalone start
```

3. As a Docker Service

```bash
docker run -it -p 4444:4444 webdriverio/selenium-standalone
```



Execute this command to run all Acceptancejs tests:

```bash
vendor/bin/codecept run Acceptancejs
```

Or you can run individual files:

```bash
vendor/bin/codecept run Acceptancejs manageArticles.feature
```

[1]: https://github.com/symfony/demo
[2]: https://codeception.com/
[3]: https://symfony.com/doc/current/setup.html#technical-requirements
[4]: https://getcomposer.org/

Symfony Standard Edition
========================

Welcome to the cwd.at GmbH fork of the Symfony Standard Edition - a fully-functional Symfony
application that you can use as the skeleton for your new applications.

This edition uses the new Symfony 4.0 directory structure.

How to use it:
```
composer create-project cwd/framework-standard-edition
```



What then?
```
// Copy the .env.dist to .env and adept
cp .env.dist .env


// Call composer install again (create-projets fails because of mising .env file
composer install --no-suggest


// Create the Database Schema
bin/console doctrine:schema:create


// Create your first user
bin/console fos:user:create myusername myemail@host.com mypassword --super-admin

```

Docker
------

For your convenience there is even a docker-compose.yml just fire it up with:
```
USERID=$UID docker-compose up -d 
```
Open your browser at [http://localhost:8400][15]

Or use the phpmyadmin under [http://localhost:8401][16]


What's inside?
--------------

The Symfony Standard Edition is configured with the following defaults:

  * An AppBundle you can use to start coding;

  * Twig as the only configured template engine;

  * Doctrine ORM/DBAL;

  * Swiftmailer;

  * Annotations enabled for everything.

It comes pre-configured with the following bundles:

  * **FrameworkBundle** - The core Symfony framework bundle

  * [**SensioFrameworkExtraBundle**][6] - Adds several enhancements, including
    template and routing annotation capability

  * [**DoctrineBundle**][7] - Adds support for the Doctrine ORM

  * [**TwigBundle**][8] - Adds support for the Twig templating engine

  * [**SecurityBundle**][9] - Adds security by integrating Symfony's security
    component

  * [**SwiftmailerBundle**][10] - Adds support for Swiftmailer, a library for
    sending emails

  * [**MonologBundle**][11] - Adds support for Monolog, a logging library

  * **WebProfilerBundle** (in dev/test env) - Adds profiling functionality and
    the web debug toolbar

  * **SensioDistributionBundle** (in dev/test env) - Adds functionality for
    configuring and working with Symfony distributions

  * [**SensioGeneratorBundle**][13] (in dev env) - Adds code generation
    capabilities

  * [**WebServerBundle**][14] (in dev env) - Adds commands for running applications
    using the PHP built-in web server

  * **DebugBundle** (in dev/test env) - Adds Debug and VarDumper component
    integration
  
  * **StofDoctrineExtensionsBundle** - Doctrine Extensions Bundle
    
  * **FosUserBundle** - Security and User Handling
  
  * **CwdBootgridBundle** - for easy Datatables
    
  * **AvanzuAdminThemeBundle** - AdminLTE Symfony Integration
  
All libraries and bundles included in the Symfony Standard Edition are
released under the MIT or BSD license.

Enjoy!

[1]:  https://symfony.com/doc/3.3/setup.html
[6]:  https://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/index.html
[7]:  https://symfony.com/doc/3.3/doctrine.html
[8]:  https://symfony.com/doc/3.3/templating.html
[9]:  https://symfony.com/doc/3.3/security.html
[10]: https://symfony.com/doc/3.3/email.html
[11]: https://symfony.com/doc/3.3/logging.html
[13]: https://symfony.com/doc/current/bundles/SensioGeneratorBundle/index.html
[14]: https://symfony.com/doc/current/setup/built_in_web_server.html
[15]: http://localhost:8400
[16]: http://localhost:8401
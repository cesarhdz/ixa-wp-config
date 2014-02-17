Ixa WP-Config
-------------

WordPress configuration consistent across environments.


## Installation

It can be installed using Composer:

    $ composer require ixa/wp-config --dev-master


## Usage

Ixa Wp-Config is meant to be used in `wp-config.php` file, this is the recommended way to use it:

`````php

use Ixa\WordPress\Configuration\Config;

require_once 'vendor/autoload.php';

// Load Config from config/ folder
$config = new Config(dirname(__FILE__) . '/config');
$config->load();

// ... define all variables and require wp-settings

````

## Configuration Folder

Ixa Wp-Config requires to define a folder in which the configuration will be placed.


### Environment Configuration

The configuration folder must contain a file named `.env.yml` with the following variables. 


````yaml
parameters:
  
  # Environment
  environment:    dev

  # Database Credentials
  db_name:        wordpress
  db_user:        root
  db_password:    ""
  db_host:        localhost

  # Site URL
  wp_home:        http://localhost:1234/

````

All variables are required and must be placed under `parameters`. This is because the `.env.yml`  file can be generated dynamically using [Incenteev/ParameterHandler](https://github.com/Incenteev/ParameterHandler).



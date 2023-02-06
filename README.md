# PHP Wordpress MU Plugin - Show Users

A Wordpress [Must-Use plugin(mu-plugin)](https://wordpress.org/documentation/article/must-use-plugins/) that retrieves and displays example user data from the external API `https://jsonplaceholder.typicode.com`

## Features

- Retrieves a list of users from the external API
- Provides the details of each user on the list via AJAX request
- Caching feature, with options for file cache and Memcached
- After the activation the plugin provides the copy of `config.sample.php` into the `config.php` in that case if it doesn't find the `config.php` in the root directory of the plugin.

## Requirements

- PHP 8.0 or higher
- Wordpress 6.1.1 or higher
- Memcached 1.6.8 or higher(in that case if you'll select this type of caching)

## Installation

1. Download the plugin
2. Move the content of the plugin directory 'src' to the `mu-plugins` directory of your Wordpress installation

## Configuration

The plugin configuration is stored in the `config.php` file in the root of the plugin. Edit this file to modify the plugin settings as needed.

## Usage

Once the plugin is installed and activated, the users table will appear by the address `<domain name>/show-users`.
Click on a user in the list to see the details of that user via AJAX request

## Testing 

```shell
cd src/show-users
vendor/bin/phpunit tests
```

## Support

For any issues or questions, please create an issue in the repository or contact the maintainer.


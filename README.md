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
- Memcached 1.6.8(in that case if you'll select this type of caching)
- [Composer](https://getcomposer.org/) 2.4.4
- [Node.js](https://nodejs.org/en/) 18.13.0

## Installation

1. Download the plugin
2. Move the content of the plugin directory `src` to the `mu-plugins` directory of your Wordpress installation
3. Provide composer dependencies installation `cd src/show-users; composer i`

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

## Dependencies

The plugin uses the following two Composer dependencies for routing:

- `ivrok/wp-router` provides typical routing functionality in Wordpress
- `ivrok/wp-api-router` provides API routing for Wordpress
- `phpunit/phpunit` provides unit testing framework for the project
- `brain/monkey` provides additional libraries for the `phpunit/phpunit` framework

## Development

The plugin includes a ReactJS feature, with the source code located in the `src/show-users/react-src` directory.

To develop the ReactJS components, you will need to have [Node.js](https://nodejs.org/en/) and npm installed.

1. Navigate to `src/show-users/react-src`
2. Run `npm i` to install the necessary Node.js dependencies
3. To build the ReactJS components, run `npm run build`
4. To start the development server and watch for changes, run `npm run start`
5. The built assets are located in the `src/show-users/assets` directory

## Support

For any issues or questions, please create an issue in the repository or contact the maintainer.


# Codeception Drupal Module

This module aims to allow tests to use the Drupal API during testing. This allows for better functional testing of your Drupal sites.

**This is a fork for Codeception 2.x-4.x and Drupal 7.x-9.x**

It also makes test driven development with Drupal significantly easier, as you can make assertions on items that you create through the UI.

## Installation

```bash
$ composer require intelektron/codeception-module-drupal --dev
```

## Usage

In your `*.suite.yml` file, add `Drupal` to your enabled modules list.

### Example configuration

This will run tests under the assumption that your Drupal installation is in a
`drupal` sub-directory.

```yaml
class_name: AcceptanceTester modules:
    enabled:
        \Codeception\Module\Drupal7\Drupal7:
            root: 'drupal'
            relative: yes
```

### Options

#### root
Accepts: `string` Default: `current working directory`

This defines the Drupal root in relation to the `codecept.yml` file. If this isn't passed in it defaults to the current working directory.

#### relative
Accepts: `yes` or `no` Default: `no`

This allows you to specify if the path to the drupal root is relative from the
`codeception.yml` file. Accepts `yes` or `no`.

## License

The project is licensed under The MIT License (MIT).

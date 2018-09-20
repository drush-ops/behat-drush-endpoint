The Behat Drush Endpoint is the remote component needed to work with the [Behat Drupal Driver](https://github.com/jhedstrom/DrupalDriver).

The Behat Drupal Driver contains three drivers:  *Blackbox*, *Direct Drupal API*, and *Drush*.  The Behat Drush Endpoint is only necessary when using the *Drush* driver.

## Installation Instructions

If you are managing your Drupal site with Composer, then add the Behat Drush Endpoint to your project as follows:
```bash
composer require drush-ops/behat-drush-endpoint:^1
```
If you are not using composer.json on the remote Drupal site, then copy the entire contents of this project to either **__ROOT__**/drush or **__ROOT__**/sites/all/drush, then `cd behat-drush-endpoint` and run `composer install`.

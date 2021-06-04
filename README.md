The Behat Drush Endpoint is the remote component needed to work with the [Behat Drupal Driver](https://github.com/jhedstrom/DrupalDriver).

The Behat Drupal Driver contains three drivers:  *Blackbox*, *Direct Drupal API*, and *Drush*.  The Behat Drush Endpoint is only necessary when using the *Drush* driver.

## Installation Instructions

THESE INSTRUCTIONS ARE FOR:

- DRUSH 10
- DRUSH 9
- DRUSH 8.2.0+

If you are using an earlier version of Drush 8, please switch to the 8.x branch.

If you are managing your Drupal site with Composer using [drupal/recommended-project](https://www.drupal.org/docs/develop/using-composer/using-composer-to-install-drupal-and-manage-dependencies) or [Pantheon's Example](https://github.com/pantheon-systems/example-drops-8-composer), then add the Behat Drush Endpoint to your project as follows:

```bash
composer require drush-ops/behat-drush-endpoint:^9
```

Make sure you have `composer/installers` installed and have the following path in your extra configuration:

```
    "extra": {
        "installer-paths": {
            "drush/Commands/contrib/{$name}": ["type:drupal-drush"]
        },
     }
```

If you are not using composer.json on the remote Drupal site, then copy the entire contents of this project to either **__ROOT__**/drush/Commands or **__ROOT__**/sites/all/drush/Commands, then `cd behat-drush-endpoint` and run `composer install`.

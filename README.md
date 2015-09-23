The Behat Drush Endpoint is the remote component neede to work with the [Behat Drupal Driver](https://github.com/jhedstrom/DrupalDriver).

The Behat Drupal Driver contains three drivers:  *Blackbox*, *Direct Drupal API*, and *Drush*.  The Behat Drush Endpoint is only necessary when using the *Drush* driver.

**THIS PROJECT IS STILL UNDER DEVELOPMENT.**

See the PR on GitHub: [Enhance the Drush driver to allow creation of nodes and taxonomy terms](https://github.com/jhedstrom/DrupalDriver/pull/56).

## Installation Instructions

On the system running the tests, modify your composer.json as follows:
``` json
{
    "repositories": [
        {
            "type": "composer",
            "url": "https://packagist.drupal-composer.org"
        },

        {
            "type": "package",
            "package": {
                "name": "greg-1-anderson/drupal-driver",
                "type": "library",
                "version": "1.1.2",
                "source": {
                    "url": "https://github.com/greg-1-anderson/DrupalDriver.git",
                    "type": "git",
                    "reference": "drush-create-node"
                },
                "replace": {
                    "drupal/drupal-driver": "self.version"
                }
            }
        }
    ],
    "require": {
        "greg-1-anderson/drupal-driver": "1.1.2",
    }
}
```
On the system running the Drupal site being tested, add the following to your composer.json file's `require` section:

``` json
{
  "require": {
    "pantheon-systems/behat-drush-endpoint": "*"
  }
}
```
If you are not using composer.json on the remote Drupal site, then copy either `behat.d8.drush.inc` or `behat.d7.drush.inc`, as applicable, to either **__ROOT__**/drush or **__ROOT__**/sites/all/drush.

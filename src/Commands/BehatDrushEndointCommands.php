<?php

namespace Drupal\behat_drush_endpoint_9\Commands;

use Drush\Commands\DrushCommands;

/**
 * A Drush commandfile.
 *
 * In addition to this file, you need a drush.services.yml
 * in root of your module, and a composer.json file that provides the name
 * of the services file to use.
 *
 * See these files for an example of injecting Drupal services:
 *   - http://cgit.drupalcode.org/devel/tree/src/Commands/DevelCommands.php
 *   - http://cgit.drupalcode.org/devel/tree/drush.services.yml
 */
class BehatDrushEndpoint9Commands extends DrushCommands {

  /**
   * Behat Drush endpoint. Serves as an entrypoint for Behat to make remote calls into the Drupal site being tested.
   *
   * @param $operation
   *   Behat operation, e.g. create-node.
   * @param $data
   *   Operation data in json format.
   * @usage drush behat create-node '{"title":"Example page","type":"page"}'
   *   Create a page with the title "Example page".
   *
   * @command 
   * @aliases behat
   */
  public function behat($operation, $data) {
    // See bottom of https://weitzman.github.io/blog/port-to-drush9 for details on what to change when porting a
    // legacy command.
  }

}

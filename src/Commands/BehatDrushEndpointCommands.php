<?php

namespace Drush\Commands;

use Drush\Commands\DrushCommands;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\node\Entity\Node;
use Drupal\node\NodeInterface;
use Drupal\taxonomy\Entity\Term;
use Drupal\taxonomy\TermInterface;

/**
 * A Drush commandfile.
 *
 * Contains Behat Drush commands, for use by the Behat Drush Extension.
 * These commands are specifically for Drush 9
 *
 * See these files for an example of injecting Drupal services:
 *   - http://cgit.drupalcode.org/devel/tree/src/Commands/DevelCommands.php
 *   - http://cgit.drupalcode.org/devel/tree/drush.services.yml
 */
class BehatDrushEndpointCommands extends DrushCommands {

  public function __construct() {
    include __DIR__ . '/../../behat.d8.drush.inc';
  }

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
   * @bootstrap full
   * @command behat:create
   * @aliases behat
   */
  public function behat($operation, $data) {
    $obj = json_decode($data);

    // Dispatch if the operation exists.
    $fn = 'drush_behat_op_' . strtr($operation, '-', '_');
    if (function_exists($fn)) {
      return $fn($obj);
    }
    else {
      throw new \Exception(dt("Operation '!op' unknown", array('!op' => $operation)));
    }
  }

}

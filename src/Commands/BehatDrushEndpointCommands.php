<?php

namespace Drupal\behat_drush_endpoint\Commands;

use Drush\Commands\DrushCommands;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\node\Entity\Node;
use Drupal\node\NodeInterface;
use Drupal\taxonomy\Entity\Term;
use Drupal\taxonomy\TermInterface;

include __DIR__ . '/../../behat-drush-common.inc';

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

  /**
   * Behat Drush endpoint. Serves as an entrypoint for Behat to make remote calls into the Drupal site being tested.
   *
   * @command behat:create
   * @aliases behat
   *
   * @param $operation
   *   Behat operation, e.g. create-node.
   * @param $data
   *   Operation data in json format.
   * @usage drush behat create-node '{"title":"Example page","type":"page"}'
   *   Create a page with the title "Example page".
   */
  public function create($operation, $data) {
    $data = json_decode($json_data);

    // Dispatch if the operation exists.
    $fn = 'drush_behat_op_' . strtr($operation, '-', '_');
    if (method_exits($this, $fn)) {
      return $this->{$fn}($data);
    }
    else {
      throw new \Exception('DRUSH_BEHAT_NO_OPERATION', dt("Operation '!op' unknown", array('!op' => $operation)));
    }
  }

  /**
   * Create a node.
   */
  public function drush_behat_op_create_node($node) {
    // Default status to 1 if not set.
    if (!isset($node->status)) {
      $node->status = 1;
    }
    // If 'author' is set, remap it to 'uid'.
    if (isset($node->author)) {
      $user = user_load_by_name($node->author);
      if ($user) {
        $node->uid = $user->id();
      }
    }

    // Attempt to decipher any fields that may be specified.
    _drush_behat_expand_entity_fields('node', $node);

    $entity = entity_create('node', (array) $node);
    $entity->save();

    $node->nid = $entity->id();

    return (array) $node;
  }

  /**
   * Delete a node.
   */
  public function drush_behat_op_delete_node($node) {
    $node = $node instanceof NodeInterface ? $node : Node::load($node->nid);
    if ($node instanceof NodeInterface) {
      $node->delete();
    }
  }

  /**
   * Create a taxonomy term.
   */
  public function drush_behat_op_create_taxonomy_term($term) {
    $term->vid = $term->vocabulary_machine_name;

    // Attempt to decipher any fields that may be specified.
    _drush_behat_expand_entity_fields('taxonomy_term', $term);

    $entity = entity_create('taxonomy_term', (array)$term);
    $entity->save();

    $term->tid = $entity->id();
    return $term;
  }

  /**
   * Delete a taxonomy term.
   */
  public function drush_behat_op_delete_taxonomy_term(\stdClass $term) {
    $term = $term instanceof TermInterface ? $term : Term::load($term->tid);
    if ($term instanceof TermInterface) {
      $term->delete();
    }
  }

  /**
   * Check if this is a field.
   */
  function drush_behat_op_is_field($is_field_info) {
    list($entity_type, $field_name) = $is_field_info;
    return _drush_behat_is_field($entity_type, $field_name);
  }

  /**
   * Get all of the field attached to the specified entity type.
   *
   * @see Drupal\Driver\Cores\Drupal8\getEntityFieldTypes in Behat
   */
  function _drush_behat_get_entity_field_types($entity_type) {
    $return = array();
    $fields = \Drupal::entityManager()->getFieldStorageDefinitions($entity_type);
    foreach ($fields as $field_name => $field) {
      if (_drush_behat_is_field($entity_type, $field_name)) {
        $return[$field_name] = $field->getType();
      }
    }
    return $return;
  }

  function _drush_behat_is_field($entity_type, $field_name) {
    $fields = \Drupal::entityManager()->getFieldStorageDefinitions($entity_type);
    return (isset($fields[$field_name]) && $fields[$field_name] instanceof FieldStorageConfig);
  }

  function _drush_behat_get_field_handler($entity, $entity_type, $field_name) {
    $core_namespace = "Drupal8";
    return _drush_behat_get_field_handler_common($entity, $entity_type, $field_name, $core_namespace);
  }

}

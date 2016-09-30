<?php

/**
 * @file
 * Contains Tags
 */

namespace Drupal\migrate_ghost\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for the tags.
 *
 * @MigrateSource(
 *   id = "ghost_tags"
 * )
 */
class GhostTags extends SqlBase {
  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('tags', 't')
      ->fields('t', ['id', 'uuid', 'name', 'slug', 'description', 'created_at', 'updated_at']);
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = [
      'id' => $this->t('Tag ID'),
      'uuid' => $this->t('Tag UUID'),
      'name' => $this->t('Tag name'),
      'slug' => $this->t('Tag slug (URL-friendly name)'),
      'description' => $this->t('Tag description'),
      'created_at' => $this->t('Tag creation timestamp'),
      'updated_at' => $this->t('Tag update timestamp'),
    ];

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    return [
      'id' => [
        'type' => 'integer',
        'alias' => 't',
      ],
    ];
  }
}

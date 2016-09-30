<?php

/**
 * @file
 * Contains GhostPosts
 */

namespace Drupal\migrate_ghost\Plugin\migrate\source;

use Drupal\migrate\Row;

/**
 * Source plugin for the posts.
 *
 * @MigrateSource(
 *   id = "ghost_posts"
 * )
 */
class GhostPosts extends GhostPages {

  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('posts', 'p')
      ->fields('p')
      ->condition('p.page', 0);

    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    $value = parent::prepareRow($row);

    $slug = $row->getSourceProperty('slug');
    $created = new \DateTime($row->getSourceProperty('created_at'));

    if (!empty($slug) && !empty($created)) {
      // Depending on configuration, Posts use the current date as URL prefix,
      // or no prefix. If no prefix is wanted, just comment this section out.
      $url = $created->format('/Y/m/d/') . $slug;
      $row->setSourceProperty('path_alias', $url);
    }

    return $value;
  }
}

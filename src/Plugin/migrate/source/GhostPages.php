<?php

/**
 * @file
 * Contains Pages
 */

namespace Drupal\migrate_ghost\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;
use Drush\Log\LogLevel;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Source plugin for the posts.
 *
 * @MigrateSource(
 *   id = "ghost_pages"
 * )
 */
class GhostPages extends SqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('posts', 'p')
      ->fields('p')
      ->condition('p.page', 1);

    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = [
      'id' => $this->t('Node ID'),
      'uuid' => $this->t('Node UUID'),
      'title' => $this->t('Node title'),
      'slug' => $this->t('Slug (for URL alias)'),
      'markdown' => $this->t('Original Markdown content'),
      'html' => $this->t('Rendered HTML content'),
      'featured' => $this->t('Featured flag'),
      'page' => $this->t('Page flag, determines whether something is a blog post or a page.'),
      'status' => $this->t('Status flag, determines whether something is published.'),
      'language' => $this->t('Language code'),
      'created_at' => $this->t('Creation timestamp'),
      'updated_at' => $this->t('Last update timestamp'),
      'published_at' => $this->t('Publication timestamp'),
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
        'alias' => 'd',
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    $status = $row->getSourceProperty('status');
    $row->setSourceProperty('published', ($status == 'published'));

    // Convert Datetime to Unix timestamp, as Drupal expects.
    $row->setSourceProperty('changed', self::parseDateTime($row->getSourceProperty('updated_at')));
    $row->setSourceProperty('created', self::parseDateTime($row->getSourceProperty('created_at')));

    $slug = $row->getSourceProperty('slug');

    if (!empty($slug)) {
      // Pages have no URL prefix, just the slug.
      $row->setSourceProperty('path_alias', '/' . $slug);
    }

    $tags = $this->select('posts_tags', 'pt')
      ->fields('pt', ['tag_id'])
      ->condition('post_id', $row->getSourceProperty('id'))
      ->execute()
      ->fetchCol();
    $row->setSourceProperty('tags', $tags);

    return parent::prepareRow($row);
  }

  /**
   * Convert the DateTime from Ghost into Unix timestamps.
   *
   * @param string $datetime
   *
   * @return integer
   */
  protected static function parseDateTime($datetime) {
    $dt = new \DateTime($datetime);
    return $dt->getTimestamp();
  }
}

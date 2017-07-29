<?php

/**
 * @file
 * Contains layout_entity.page.inc.
 *
 * Page callback for Layout Entity entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Layout Entity templates.
 *
 * Default template: layout_entity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_layout_entity(array &$variables) {
  // Fetch LayoutEntity Entity Object.
  $layout_entity = $variables['elements']['#layout_entity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}

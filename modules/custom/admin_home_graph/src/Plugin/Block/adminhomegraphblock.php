<?php

namespace Drupal\admin_home_graph\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\user\Entity\User;

/**
 * Provides a 'adminhomegraphblock' block.
 *
 * @Block(
 *  id = "adminhomegraphblock",
 *  admin_label = @Translation("admin home graph block"),
 * )
 */
class adminhomegraphblock extends BlockBase
{

  /**
   * {@inheritdoc}
   */
  public function build()
  {

    // ini_set('memory_limit', '1024M');
    $uids = \Drupal::entityQuery('user')->condition('uid', 1)->execute();
    $users = \Drupal\user\Entity\User::loadMultiple($uids);

    foreach ($users as $user) {
      $content[] = [
        'id' => $user->id(),
        'name' => $user->name->value
      ];
    }

    // echo "<pre>";
    // print_r($users);
    // echo "</pre>"; 


    //all active users
    $activeQuery = \Drupal::entityQuery('user')
    ->condition('field_status', 32)
    ->condition('status', true);
    $activeUids = $activeQuery->execute();

    $blockQuery = \Drupal::entityQuery('user')
      ->condition('status', true)
      ->condition('field_status', 56)
      ->condition('uid', '0', '<>');
    $blockUids = $blockQuery->execute();


    $holdQuery = \Drupal::entityQuery('user')
    ->condition('field_status', 34)
    ->condition('status', true);
    $holdUids = $holdQuery->execute();

    $markedQuery = \Drupal::entityQuery('user')
    ->condition('field_status', 35)
    ->condition('status', true);

    $markedUids = $markedQuery->execute();

    $build['#attached']['library'][] = 'admin_home_graph/admin_home_graph_lib';
    $build['admin_home_graph'] = [
      '#theme' => 'admin_home_graph_block',
      '#data' => [
        'graphdata' => $content,
        'graphdata2' => json_encode([
          ['label' => 'Approved', 'y' => count($activeUids),],
          ['label' => 'New Request', 'y' => count($blockUids)],
          ['label' => 'Hold', 'y' => count($holdUids)],
          ['label' => 'Mark Discrepant', 'y' => count($markedUids)]
        ])
      ]
    ];

    return $build;
  }
}

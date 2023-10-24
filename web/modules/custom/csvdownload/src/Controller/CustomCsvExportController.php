<?php
namespace Drupal\csvdownload\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;

class CustomCsvExportController extends ControllerBase {

  public function generateCsv() {
    $csvData = [];
    $csvData[] = ['Node Title', 'Node ID', 'Created Date', 'Updated Date', 'Author'];
    $query = \Drupal::entityQuery('node')
      ->condition('type', 'paragraph_content_type')
      ->accessCheck(FALSE)
      ->execute();

    foreach ($query as $nid) {
      $node = \Drupal\node\Entity\Node::load($nid);
      $createdDate = \Drupal::service('date.formatter')->format($node->getCreatedTime(), 'custom', 'Y-m-d H:i:s');
      $updatedDate = \Drupal::service('date.formatter')->format($node->getChangedTime(), 'custom', 'Y-m-d H:i:s');
      $author = $node->getOwner()->getDisplayName();

      $csvData[] = [$node->getTitle(), $node->id(), $createdDate, $updatedDate, $author];
    }

    $csvContent = '';
    foreach ($csvData as $row) {
      $csvContent .= implode(',', $row) . "\n";
    }

    $response = new Response($csvContent);
    $response->headers->set('Content-Type', 'text/csv');
    $response->headers->set('Content-Disposition', 'attachment; filename=events_data.csv');

    return $response;
  }
}
?>
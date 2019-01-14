<?php

namespace Drupal\pm_project\Controller;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\project_manager\Controller\PmController;
use Drupal\project_manager\Entity\PmContentEntityBaseInterface;

/**
 * Class PmProjectController.
 *
 *  Returns responses for PmProject routes.
 */
class PmProjectController extends PmController implements ContainerInjectionInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionOverview(PmContentEntityBaseInterface $pm_project) {
    return $this->tableRevisions($pm_project);
  }

}

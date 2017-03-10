<?php

namespace Codeception\Module\Drupal8;

use Codeception\Module\DrupalBaseModule;
use Codeception\Module\DrupalModuleInterface;
use Drupal\Core\DrupalKernel;
use Drupal\Core\Site\Settings;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Drupal
 * @package Codeception\Module
 */
class Drupal8 extends DrupalBaseModule implements DrupalModuleInterface {

  /**
   * { @inheritdoc }
   */
  public function _initialize() {

    $this->bootstrapDrupal();

  }

  /**
   * { @inheritdoc }
   */
  public function bootstrapDrupal()
  {
    $this->config['root'] = $this->getDrupalRoot();
    $this->validateDrupalRoot($this->config['root']);

    if (!defined('DRUPAL_ROOT')) {
      define('DRUPAL_ROOT', $this->config['root']);
    }
    chdir(DRUPAL_ROOT);

    // Get drupal site.
//    $global_config = \Codeception\Configuration::config();
//    $site = 'default';
//    if (isset($global_config['settings']['drupal_site'])) {
//      $site = $global_config['settings']['drupal_site'];
//    }
    $site = isset($this->config['site_dir']) ? "sites/{$this->config['site_dir']}" : 'sites/default';

    // Bootstrap.
    $autoloader = require DRUPAL_ROOT . '/autoload.php';
    require_once DRUPAL_ROOT . '/core/includes/bootstrap.inc';

    $request = Request::createFromGlobals();
    Settings::initialize(DRUPAL_ROOT, $site, $autoloader);
    $kernel = DrupalKernel::createFromRequest($request, $autoloader, 'prod');
    $kernel->boot();
    $kernel->prepareLegacyRequest($request);
  }

  /**
   * { @inheritdoc }
   */
  public function validateDrupalRoot($root)
  {
    if (!file_exists($root . '/autoload.php') || !file_exists($root . '/core/includes/bootstrap.inc')) {
      throw new DrupalNotFoundException('Drupal not found at ' . $root . '.');
    }

    return true;
  }
}

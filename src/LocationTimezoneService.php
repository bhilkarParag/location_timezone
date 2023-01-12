<?php

namespace Drupal\location_timezone;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Security\TrustedCallbackInterface;

/**
 * Service to get the timezone.
 */
class LocationTimezoneService implements TrustedCallbackInterface {

  /**
   * A configuration object.
   *
   * @var \Drupal\Core\Config\ImmutableConfig
   */
  protected $config;

  /**
   * Constructor for LocationTimezoneService.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The configuration factory.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->config = $config_factory->get('location_timezone.settings');
  }

  /**
   * Get the timezone.
   */
  public function getTimeZone() {
    $timezone = $this->config->get('timezone');
    $date = new DrupalDateTime('now', $timezone);

    return [
      '#markup' => $date->format('l, jS F Y - h:i A'),
      '#cache' => [
        'max-age' => 0,
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function trustedcallbacks() {
    return ['getTimeZone'];
  }

}

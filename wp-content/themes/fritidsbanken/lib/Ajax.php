<?php

namespace StickyBeat;
use StickyBeat\Utils;

class Ajax
{
  public function __construct()
  {
    add_action('wp_ajax_nearestBank', [__CLASS__, 'getNearestBank']);
    add_action('wp_ajax_nopriv_nearestBank', [__CLASS__, 'getNearestBank']);

    add_action('wp_ajax_moreNews', [__CLASS__, 'loadMoreNews']);
    add_action('wp_ajax_nopriv_moreNews', [__CLASS__, 'loadMoreNews']);

    add_action('wp_ajax_getBankLocations', [__CLASS__, 'getBankLocations']);
    add_action('wp_ajax_nopriv_getBankLocations', [
      __CLASS__,
      'getBankLocations',
    ]);
  }

  public static function getNearestBank()
  {
    $return = [];

    $start = [
      'lat' => $_POST['lat'],
      'lng' => $_POST['lng'],
    ];

    $allBanks = json_decode(get_transient('cached_banks'));

    $prevDistance = 99999999999;

    foreach ($allBanks as $key => $bank) {
      //$pos = papi_get_field($bank->ID, 'bank_geolocation');
      $pos = $bank->coordinates;

      if ($pos) {
        list($lat, $lng) = explode(',', $pos);
        $end = [
          'lat' => trim($lat),
          'lng' => trim($lng),
        ];
        $distance = Utils::distanceBetween($start, $end);
        if ($distance < $prevDistance) {
          $return['id'] = $bank->id;
          /*  //$return['name'] = get_the_title($bank->ID);
          $return['name'] = $bank->name;
          //$return['openhours'] = papi_get_field($bank->ID, 'bank_openhours');
          $return['openhours'] = $bank->openingHours;
          //$return['address'] = papi_get_field($bank->ID, 'bank_address');
          $return['address'] = $bank->street;
          //$return['zip'] = papi_get_field($bank->ID, 'bank_zip');
          $return['zip'] = $bank->zip;
          //$return['city'] = papi_get_field($bank->ID, 'bank_city');
          $return['city'] = $bank->city;
          //$return['url'] = get_permalink($bank->ID);
          $return['url'] = '/fritidsbank/' . $bank->slug; */
          $prevDistance = $distance;
        }
      }
    }

    echo json_encode($return);

    die();
  }

  public static function getBankLocations()
  {
    ob_start();
    $return = ['banks' => [], 'ipsum' => 'lorem'];

    /* $allBanks = new \WP_Query(array(
      'post_type' => 'fritidsbank',
      'posts_per_page' => -1
    )); */
    $allBanks = json_decode(get_transient('cached_banks'));

    foreach ($allBanks as $key => $bank) {
      if ($bank->status === 'INACTIVE' || empty($bank->coordinates)) {
        continue;
      }
      $pos = $bank->coordinates;

      $isOpening = $bank->status === 'SCHEDULED';

      $hasParent = $bank->parent_id !== null && $bank->parent_id !== '';

      list($lat, $lng) = explode(',', $pos);

      $pos = ['lat' => floatval($lat), 'lng' => floatval($lng)];

      $id = $bank->id;

      array_push($return['banks'], [
        'ID' => $id,
        'position' => $pos,
        'isOpening' => $isOpening,
        'hasParent' => $hasParent,
      ]);
    }
    $return['test'] = '?';
    echo json_encode($return);

    die();
  }

  public static function loadMoreNews()
  {
    ob_start();

    $offset = $_POST['o'];

    $args = [
      'post_type' => 'post',
      'offset' => $offset,
      'posts_per_page' => 6,
    ];

    $post_query = new \WP_Query($args);

    if ($post_query->have_posts()) {
      while ($post_query->have_posts()) {
        $post_query->the_post();
        Printer::render_news_item($post);
      }
    }

    $news = get_posts([
      'posts_per_page' => 6,
      'offset' => $offset + 5,
    ]);

    $numLeft = count($news);

    $content = ob_get_clean();

    if (isset($_SERVER['HTTPS'])) {
      $content = str_replace('http://', 'https://', $content);
    }

    echo json_encode(['itemsLeft' => $numLeft, 'html' => $content]);

    //ob_flush();

    die();
  }
}

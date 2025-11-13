<?php

namespace StickyBeat;

use GraphQL\Client;
use GraphQL\Query;

class API
{
  public function __construct()
  {
    add_action('init', [__CLASS__, 'init']);
  }

  public static function init()
  {
    //error_log('API - init');

    // Integrering av  banker från Lending system

    add_action('rest_api_init', function () {
      register_rest_route('stickybeat/v1', '/resetbankcache', [
        'methods' => 'GET',
        'callback' => [__CLASS__, 'reset_bank_cache'],
        'permission_callback' => '__return_true',
      ]);
    });

    add_action('init', function () {
      add_rewrite_rule(
        'fritidsbank/([a-z0-9-]+)[/]?$',
        'index.php?fritidsbank=$matches[1]',
        'top'
      );
    });
    add_filter('query_vars', function ($query_vars) {
      $query_vars[] = 'fritidsbank';
      return $query_vars;
    });
    add_action('template_include', function ($template) {
      if (
        get_query_var('fritidsbank') == false ||
        get_query_var('fritidsbank') == ''
      ) {
        return $template;
      }
      return get_template_directory() .
        '/page-templates/singlebank_page_template.php';
    });
    add_filter('rest_category_collection_params', [
      __CLASS__,
      'maximum_api_filter',
    ]);

    add_filter('xmlrpc_enabled', '__return_false');
  }

  public static function reset_bank_cache()
  {
    $ch = curl_init();
    // set url
    error_log('API - reset_bank_cache');

    $url = 'https://utlaningssystem.fritidsbanken.se/graphql';
    //$url = 'https://lending-stage.fritidsbanken.stickybeat.se/graphql';

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
    curl_setopt(
      $ch,
      CURLOPT_POSTFIELDS,
      '{ "query": " { banksite { banks (first:500){ data { name id parent_id description street zip city openingHours coordinates contactName contactPhone contactEmail bankEmail bankPhone contactTitle status slug facebookLink newsCategories donateInformation tempInformation tempInformationStartDate tempInformationEndDate images{ id path mimeType }} } } }"}'
    );

    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $headers = [];
    $headers[] = 'Content-Type: application/json';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $output = curl_exec($ch);
    $json = json_decode($output);
    curl_close($ch);

    delete_transient('cached_banks');
    set_transient(
      'cached_banks',
      json_encode($json->data->banksite->banks->data)
    );
    return [
      'status' => 'success',
      'message' => 'cache purged',
      //'data' => json_encode($json->data->banksite->banks->data),
    ];
  }

  public static function maximum_api_filter($query_params)
  {
    $query_params['per_page']['maximum'] = 1000;
    return $query_params;
  }
}

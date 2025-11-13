<?php namespace StickyBeat;

class Fritidsbank
{
  public function __construct()
  {
    add_action('init', [__CLASS__, 'init']);
  }

  public static function init()
  {
    add_rewrite_rule(
      'fritidsbank/([a-z0-9-]+)[/]?$',
      'index.php?fritidsbank=$matches[1]',
      'top'
    );

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
  }
}

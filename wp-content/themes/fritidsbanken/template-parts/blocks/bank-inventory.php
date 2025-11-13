<?php

$choose = __('Välj Fritidsbank', 'fritidsbanken');
$category = __('Kategori', 'fritidsbanken');
$subcategory = __('Underkategori', 'fritidsbanken');
$matches = __('Din sökning matchar', 'fritidsbanken');
$articles = __('artiklar', 'fritidsbanken');
$search = __('Sök', 'fritidsbanken');
$article = __('Artikel', 'fritidsbanken');
$size = __('Storlek', 'fritidsbanken');
$status = __('Status', 'fritidsbanken');
$available = __('Tillgänglig', 'fritidsbanken');
$lended = __('Utlånad', 'fritidsbanken');
$copy = [
  'choose' => $choose,
  'category' => $category,
  'subcategory' => $subcategory,
  'matches' => $matches,
  'articles' => $articles,
  'search' => $search,
  'article' => $article,
  'size' => $size,
  'status' => $status,
  'available' => $available,
  'lended' => $lended,
];
?>

<div class="bank-inventory-wrapper">

  <div id="app-bank-inventory" data-bankid="<?php echo isset($args['bankid'])
    ? $args['bankid']
    : ''; ?>" data-copy="<?php echo urlencode(json_encode($copy)); ?>"></div>

 
  <?php echo get_field('bank_inventory_disclaimer', 'option'); ?>
</div>


<?php
$dir = get_template_directory() . '/assets/bank-inventory';

foreach (glob($dir . '/vendor.*.js') as $filename) {
  $withoutDirectory = array_pop(explode('/', $filename));

  echo '<link rel="modulepreload" href="' .
    get_template_directory_uri() .
    '/assets/bank-inventory/' .
    $withoutDirectory .
    '">';
}

foreach (glob($dir . '/index.*.js') as $filename) {
  $withoutDirectory = array_pop(explode('/', $filename));

  echo '<script type="module" crossorigin src="' .
    get_template_directory_uri() .
    '/assets/bank-inventory/' .
    $withoutDirectory .
    '"></script>';
}
foreach (glob($dir . '/index.*.css') as $filename) {
  $withoutDirectory = array_pop(explode('/', $filename));

  echo '<link rel="stylesheet" href="' .
    get_template_directory_uri() .
    '/assets/bank-inventory/' .
    $withoutDirectory .
    '">';
}
?>


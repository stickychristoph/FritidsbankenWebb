<!DOCTYPE html>
<html lang="en">
  <meta charset="UTF-8">
  <title>Fritidsbanken</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
<body style="padding:16px;">

<?php
$bankId = empty($_GET['bank']) ? '' : $_GET['bank'];

$choose = 'Välj Fritidsbank';
$category = 'Kategori';
$subcategory = 'Underkategori';
$matches = 'Din sökning matchar';
$articles = 'artiklar';
$search = 'Sök';
$article = 'Artikel';
$size = 'Storlek';
$status = 'Status';
$available = 'Tillgänglig';
$lended = 'Utlånad';
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

  <div id="app-bank-inventory" data-bankid="<?php echo $bankId; ?>" data-copy="<?php echo urlencode(
  json_encode($copy)
); ?>"></div>
</div>


<?php
$dir = dirname(__FILE__) . '/bank-inventory';
$x = pathinfo($_SERVER['REQUEST_URI']);
$x['dirname'];

foreach (glob($dir . '/vendor.*.js') as $filename) {
  $withoutDirectory = array_pop(explode('/', $filename));

  echo '<link rel="modulepreload" href="' .
    $x['dirname'] .
    '/bank-inventory/' .
    $withoutDirectory .
    '">';
}

foreach (glob($dir . '/index.*.js') as $filename) {
  $withoutDirectory = array_pop(explode('/', $filename));

  echo '<script type="module" crossorigin src="' .
    $x['dirname'] .
    '/bank-inventory/' .
    $withoutDirectory .
    '"></script>';
}
foreach (glob($dir . '/index.*.css') as $filename) {
  $withoutDirectory = array_pop(explode('/', $filename));

  echo '<link rel="stylesheet" href="' .
    $x['dirname'] .
    '/bank-inventory/' .
    $withoutDirectory .
    '">';
}
?>

</body>
</html>
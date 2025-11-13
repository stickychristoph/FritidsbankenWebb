<?php
ob_start();
get_header();

$uri = strtolower(trim($_SERVER['REQUEST_URI'], '/'));

$cachedBanks = json_decode(get_transient('cached_banks'));
foreach ($cachedBanks as $cachedBank) {
  if ($cachedBank->slug === $uri) {
    $protocol =
      (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
      $_SERVER['SERVER_PORT'] == 443
        ? 'https://'
        : 'http://';
    $domainName = $_SERVER['HTTP_HOST'] . '/';

    $url = $protocol . $domainName . 'fritidsbank/' . $uri . '/';
    ob_end_clean();
    header('Location: ' . $url, true, 301);
    exit();
  }
}
?>

<div class="content">
 
  <h1 style="margin-top: 70px;">Hoppsan! Sidan kunde inte hittas</h1>
 
</div>

<?php
get_footer();
ob_end_flush();


?>

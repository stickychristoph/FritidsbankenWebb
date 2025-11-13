<?php
use StickyBeat\Printer;

$searchLabel = get_field('search_label');
$openingSoon = get_field('opening_soon');
?>

<div class="findbank-wrapper">
        <div class="search-wrapper" id="search-wrapper">
            <div class="search-form">
                <input id="search-text" type="text" class="search" placeholder="<?php echo $searchLabel; ?>" aria-label="<?php echo $searchLabel; ?>"/>
                <div class="nearest-bank-loader" id="nearest-bank-loader">
                  <div class="spinner spin-wrapper"><span class="icon-spin6"></span></div>
                </div>
              </div>
            <div class="map-legends">
              <div class="map-legend" id="map-legend">
                  <img src="<?php echo get_template_directory_uri() .
                    '/assets/icons/marker_orange.svg'; ?>" alt="Markör för filial"><span>Lilla Fritidsbanken</span>
              </div>
              <div class="map-legend" id="map-legend">
                  <img src="<?php echo get_template_directory_uri() .
                    '/assets/icons/map_marker_blue.svg'; ?>" alt="Markör för kommande fritidsbank"><span> <?php echo $openingSoon; ?></span>
              </div>
            </div>
            <div class="no-result" id="no-result">
                <i>Tyvärr hittades ingen Fritidsbank</i>     
            </div>
            <div class="search-result" id="search-result">
                <ul class="bank-list" id="bank-list">
<?php
$banks = json_decode(get_transient('cached_banks'));

foreach ($banks as $index => $bank):

  if ($bank->status === 'INACTIVE') {
    continue;
  }
  $isOpening = $bank->status === 'SCHEDULED';

  $bankTitle = $bank->name;
  $bankStreet = $bank->street;
  $bankZip = $bank->zip;
  $bankCity = $bank->city;
  $bankOpenhours = apply_filters('the_content', $bank->openingHours);
  //$bankContactName = $bank->contactName;
  $bankContactPhone = isset($bank->bankPhone) ? $bank->bankPhone : '';
  $bankContactEmail = isset($bank->bankEmail) ? $bank->bankEmail : '';

  $slug = $bank->slug;

  $bankContact = '';
  if (!empty($bankContactPhone)) {
    $bankContact = $bankContactPhone . '<br>';
  }
  if (!empty($bankContactEmail)) {
    $bankContact .=
      '<a href="mailto:' .
      trim($bankContactEmail) .
      '">' .
      trim($bankContactEmail) .
      '</a><br>';
  }
  ?>
                    <li data-id="<?php echo $bank->id; ?>" data-city="<?php echo $bankTitle; ?>">
                        <div class="bank-city"><span><?php echo $bankTitle; ?></span><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/arrow_down_black.svg"></div>
                        <div class="bank-info-wrapper">
                            <?php echo $isOpening
                              ? "<h4 class='isopening-title'>Öppnar inom kort!</h4>"
                              : ''; ?>
                            <p class="bank-address"><?php echo $bankStreet .
                              ', ' .
                              $bankZip .
                              ' ' .
                              $bankCity; ?></p>
                            <div class="bank-openhours-container">
                                <h4>Öppettider:</h4>
                                <p class="bank-openhours"><?php echo $bankOpenhours; ?></p>
                            </div>
                            <div class="bank-contact-container">
                                <h4>Kontakt:</h4>
                                <p><?php echo $bankContact; ?></p>
                            </div>
                            <?php if (!empty($slug)):
                              Printer::render_button(
                                [
                                  'url' => '/fritidsbank/' . $slug,
                                  'title' => __('Besök sida', 'fritidsbanken'),
                                ],
                                'green'
                              );
                            endif; ?>
                        </div>
                    </li>
                  <?php
endforeach;
?>
                </ul>
            </div>
        </div>
        <div class="map-wrapper">
            
            <div id="map" class="map"></div>
        </div>

    </div>

    <!-- script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo MAPS_API_KEY; ?>&callback=initMap"></script-->
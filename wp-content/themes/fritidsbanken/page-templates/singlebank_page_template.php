<?php

use StickyBeat\Printer;

global $wp_query;

//the_post();

get_header();
$cachedBanks = json_decode(get_transient('cached_banks'));

$requestedSlug = $wp_query->query_vars['fritidsbank'];

$bank = '';
foreach ($cachedBanks as $cachedBank) {
  if ($cachedBank->slug === $requestedSlug) {
    $bank = $cachedBank;
    break;
  }
}
?>
<div class="single-bank content">
	<?php
 $bankName = $bank->name;
 $bankStreet = $bank->street;
 $bankZip = $bank->zip;
 $bankCity = $bank->city;
 $bankGeoLocation = $bank->coordinates;
 $bankOpenhours = apply_filters('the_content', $bank->openingHours);
 $bankDescription = apply_filters('the_content', $bank->description);
 $bankDonateInformation = apply_filters(
   'the_content',
   $bank->donateInformation
 );
 $bankTempInformation = apply_filters('the_content', $bank->tempInformation);
 $bankTempInformationStartDate = $bank->tempInformationStartDate;
 $bankTempInformationEndDate = $bank->tempInformationEndDate;
 $bankTempInformationStartDate = date(
   'Y-m-d H:i:s',
   strtotime($bankTempInformationStartDate)
 );
 $bankTempInformationEndDate = date(
   'Y-m-d H:i:s',
   strtotime($bankTempInformationEndDate)
 );

 $bankContactName = $bank->contactName;
 $bankContactTitle = $bank->contactTitle;
 $bankContactPhone = isset($bank->bankPhone) ? $bank->bankPhone : '';
 $bankContactEmail = isset($bank->bankEmail) ? $bank->bankEmail : '';
 $facebookLink = isset($bank->facebookLink) ? $bank->facebookLink : '';
 // add 'https://' to facebook link if it doesn't exist
 if (!empty($facebookLink) && !preg_match('/^https?:\/\//', $facebookLink)) {
   $facebookLink = 'https://' . $facebookLink;
 }

 $isOpening = $bank->status === 'SCHEDULED';
 $hasParent = $bank->parent_id !== null && $bank->parent_id !== '';

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
 if (!empty($facebookLink)) {
   $bankContact .=
     '<a href="' .
     $facebookLink .
     '" target="_blank" title="Facebook">Facebook</a></br>';
 }

 if (!empty($bankContactName)) {
   $bankContact .= '<br>Kontaktperson:<br>' . $bankContactName . '<br>';
 }

 $bankGeoLocation = explode(',', $bankGeoLocation);
 $mapboxGeoLocation =
   trim($bankGeoLocation[1]) . ',' . trim($bankGeoLocation[0]);
 $gMapsGeoLocation =
   trim($bankGeoLocation[0]) . ',' . trim($bankGeoLocation[1]);
 ?>
      <div class="flex justify-between max-w-text mx-auto items-start">
       <div>
 
        <h1><?php echo $bankName; ?></h1>
        <p><a class="flex items-center" href="https://www.google.com/maps/search/?api=1&query=<?php echo $gMapsGeoLocation; ?>" target="_blank"><img src="<?php echo get_template_directory_uri() .
  '/assets/icons/marker_green.svg'; ?>" alt="" class="mr-2"/><?php echo $bankStreet .
  ', ' .
  $bankZip .
  ' ' .
  $bankCity; ?></a></p>
     
        </div> <?php if ($hasParent): ?>
        <div class="flex-shrink-0" style="margin-top: -8px;">
         
            <img src="<?php echo get_template_directory_uri() .
              '/assets/img/lilla_fritidsbanken_orange.png'; ?>" alt="Lilla Fritidsbanken" class="affiliate-logo" style="flex-shrink: 0;"/>
        </div>
        <?php endif; ?>
        </div>
        <img class="map-image" style="margin: 2rem auto;max-width: 700px;" src="https://api.mapbox.com/styles/v1/mapbox/streets-v12/static/pin-l+4d9d34(<?php echo $mapboxGeoLocation; ?>)/<?php echo $mapboxGeoLocation; ?>,14,0/700x430@2x?access_token=pk.eyJ1IjoiZnJpdGlkc2JhbmtlbiIsImEiOiJjbGxvdjhrejcwMDM0M3NudjhoOW15em9hIn0.N7LSQRyE5tfqLndlpjecBQ"/>
         <?php if (strlen($bankOpenhours) > 1): ?>
        <h2>Öppettider:</h2>
        <p class="bank-openhours"><?php echo $bankOpenhours; ?></p>
        <?php endif; ?>
        <?php
        $now = date('Y-m-d H:i:s');
        if (
          !empty($bankTempInformation) &&
          $now >= $bankTempInformationStartDate &&
          $now <= $bankTempInformationEndDate
        ): ?>
         <p><?php echo $bankTempInformation; ?></p>
        <?php endif;
        ?>
        <h2>Kontakt:</h2>
        <p><?php echo $bankContact; ?></p>

        <?php if (is_array($bank->images) && count($bank->images) > 0): ?>
    			<div class="single-bank-image-container">
            <img class="single-bank-image" src="https://utlaningssystem.fritidsbanken.se/storage/<?php echo $bank
              ->images[0]->path; ?>">
          </div>
          <?php endif; ?>
          <?php if (strlen($bankDescription) > 1): ?>
            
            <?php echo $bankDescription; ?>
          
          <?php endif; ?>
          <?php if (strlen($bankDonateInformation) > 1): ?>
             <h2>Skänka utrustning:</h2>
            <?php echo $bankDonateInformation; ?>
          
          <?php endif; ?>

          
          <?php if (!$isOpening): ?>
          <h2>Lagersaldo:</h2>
          <?php
          $args = ['bankid' => $bank->id];
          get_template_part(
            './template-parts/blocks/bank-inventory',
            null,
            $args
          );
          endif; ?>  
          
		
</div><!-- .content -->


<?php get_footer();

<?php

use StickyBeat\Printer;

$contacts = get_field('contacts');
?>

<div class="contacts-block">
  <div class="contacts">
  <?php foreach ($contacts as $contactId): ?>
      <div class="contact-person">
      <?php
      $name = get_field('name', $contactId);
      $role = get_field('role', $contactId);
      $phone = get_field('phone', $contactId);
      $email = get_field('email', $contactId);
      $body = get_field('body', $contactId);

      if (has_post_thumbnail($contactId)) { ?>
        <div class="image-wrapper">
        <?php
        $mediaId = get_post_thumbnail_id($contactId);
        Printer::render_image(
          $mediaId,
          '(max-width: 460px) 100vw, 300px',
          'contact-image'
        );
        ?>
        </div>
        <?php }
      ?> 
        <h3><?php echo $name; ?></h3>
        <p>
        <?php echo $role; ?>
          <span style="display:block"><?php echo __(
            'Telefon',
            'fritidsbanken'
          ) . ': '; ?>
            <a href="tel:<?php echo $phone; ?>"><?php echo $phone; ?></a>
          </span>
          <span style="display:block"><?php echo __('E-mail', 'fritidsbanken') .
            ': '; ?>
            <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
          </span>
        </p>
        <p><?php echo $body; ?></p>

      </div><!-- contact person -->
    <?php endforeach; ?>
  </div>
</div><!-- contacts-block -->



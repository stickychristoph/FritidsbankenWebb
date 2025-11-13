<?php

$items = get_field('items'); ?>

<div class="fb-anchor-menu">
    <nav>
      <ul class="anchor-list">
      <?php if (!is_array($items) || count($items) === 0) {
        echo '<i> + Lägg till alternativ</i>';
      } else {
        foreach ($items as $item): ?>
        <li><a href="<?php echo $item['anchor']; ?>"><?php echo $item[
  'label'
]; ?></a></li>
      <?php endforeach;
      } ?>
      </ul>

     


  </nav>
</div>


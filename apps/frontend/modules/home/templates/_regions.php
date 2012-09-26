<?php foreach ($regions as $i=>$region): ?>
    <?php if($i==0){echo '<div class="home_left_column">';}
        if($i==25){echo '</div><div class="home_left_column">';}
        if($i==50){echo '</div><div class="home_right_column">';}?>
    <?php echo link_to($region->getName(), 'region/show?id='.$region->getId()) ?><br/>
  <?php endforeach; ?>
   </div>

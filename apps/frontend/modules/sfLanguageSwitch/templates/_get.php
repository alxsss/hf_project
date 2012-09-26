<?php foreach($sf_data->getRaw('languages') as $language => $information): ?>
  <?php if($language == $sf_user->getCulture())
	      {
		  ?>
		    <li>		  
              <?php echo image_tag($information['image'], array('alt' => $information['title'], 'title' => $information['title'] )
	                     ).$information['title']?>
           </li>
		   <?php
		  }
		  else
		  {
		  ?>
		     <li>
               <?php echo link_to(image_tag($information['image'], array('alt' => $information['title'], 'title' => $information['title'] )
	                     ).$information['title'],
                          $current_module . '/' . $current_action . $information['query']
               )?>
            </li>
		<?php
		  } 
	    ?>
    
  <?php endforeach; ?>
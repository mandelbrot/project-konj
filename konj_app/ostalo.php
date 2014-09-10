<?php

require_once "components.php";
include_once 'head.php';

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    
    <?php echo get_head() ?>
    
<body>
	<?php include_once("analyticstracking.php") ?>
    <?php echo get_helper() ?>
    <?php echo get_header(4) ?>

    <div id="content">
    
	   <hr />


        <section class="wrapper">
            
        <?php get_vozni_park() ?>
	   <?php get_contact() ?>
        </section>

	   <hr />

    </div>

    <div class="clear">
    </div>

    <?php get_footer() ?>

</body>
</html>

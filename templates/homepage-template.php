<?php /* Template Name: Homepage Template */
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php wp_head();?>
</head>
<body>
<!--get_nav-->
<?php do_action( 'get_siteefy_nav' ); ?>
<!--get header-->
<?php do_action( 'get_siteefy_header' ); ?>
<!--end of header-->
<?php
if (the_content()):
    ?>
                <?php while ( have_posts() ) : the_post();
                    the_content();
                endwhile; // end of the loop. ?>
<?php
endif;
?>
<?php do_action( 'get_siteefy_footer' ); ?>
<?php wp_footer(); ?>
</body>
</html>

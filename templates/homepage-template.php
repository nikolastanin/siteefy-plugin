<?php /* Template Name: Homepage Template */
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inria+Sans:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <?php wp_head();?>

    <!--    <link rel="stylesheet" href="stylesheets/main.css">-->
</head>
<body>
<div class="body-line-icon">
    <svg xmlns="http://www.w3.org/2000/svg" width="1234" height="3909" viewBox="0 0 1234 3909" fill="none">
        <path d="M798.5 14.0886C834.667 -2.07803 913.3 -14.7114 938.5 64.0886C970 162.589 915.5 298.089 938.5 354.589C961.5 411.089 976.5 463.089 1087 486.089C1197.5 509.089 1329.5 782.589 1124.5 1033.59C919.5 1284.59 487 1285.09 370 1395.59C253 1506.09 349.496 1547.07 370 1566.59C411.5 1606.09 458.51 1699.53 313.5 1767.09C269.5 1787.59 142.5 1875.59 96.5 1911.09C50.5 1946.59 -18.7221 2049.64 8.49999 2178.59C37 2313.59 171.541 2407.66 245 2437.59C499 2541.09 649.5 2726.09 710.5 3123.09C771.5 3520.09 997 3398.59 1020 3386.09C1043 3373.59 1202 3371.59 1193.5 3543.09C1185 3714.59 1018 3793.59 999 3906.59" stroke="#6892FF" stroke-width="4" stroke-linecap="round" stroke-dasharray="14 14"></path>
    </svg>
</div>
<div class="body-line-icon-mobile" style="display: none">
    <svg xmlns="http://www.w3.org/2000/svg" width="387" height="7124" viewBox="0 0 387 7124" fill="none">
        <path d="M12.7992 2C261.604 155.694 188.253 717.155 50.27 938.183C-160.065 1275.11 540.386 1363.72 310.835 1944.46C139.579 2377.71 32.0507 2654.35 3.80631 3051.35C-18.7892 3368.96 176.299 3486.65 270.673 3457.74C281.048 3448.54 303.606 3441.35 310.835 3486.19C319.872 3542.24 304.237 3619.34 310.835 3651.49C317.433 3683.64 321.736 3713.23 353.436 3726.32C385.136 3739.41 423.003 3895.03 364.194 4037.86C305.385 4180.68 140.001 4184.38 106.437 4247.26C72.8723 4310.14 98.691 4339.73 106.437 4344.56C114.182 4349.4 143.444 4367.32 131.538 4455.24C119.633 4543.15 82.4826 4516.98 69.2864 4537.18C56.0901 4557.38 36.232 4616.02 44.0414 4689.39C52.2173 4766.21 90.8137 4819.74 111.887 4836.77C184.754 4895.66 227.928 5000.93 245.428 5226.84C262.927 5452.74 327.617 5383.6 334.215 5376.49C340.814 5369.38 386.427 5368.24 383.988 5465.83C381.55 5563.42 333.642 5608.37 328.191 5672.67C237.882 5818.19 81.6454 6181.21 179.169 6469.17C301.074 6829.13 349.657 7005.35 245.428 7122" stroke="#6892FF" stroke-width="4" stroke-linecap="round" stroke-dasharray="14 14"/>
    </svg>
</div>
<!--get_nav-->
<?php //do_action( 'get_siteefy_nav' ); ?>

<!--get header-->
<?php do_action( 'get_siteefy_header' ); ?>
<!--end of header-->
<?php
//if (the_content()):
//    ?>
<!--                --><?php //while ( have_posts() ) : the_post();
//                    the_content();
//                endwhile; // end of the loop. ?>
<?php
//endif;
?>
<?php do_action( 'get_siteefy_footer' ); ?>
<?php wp_footer(); ?>
</body>
</html>

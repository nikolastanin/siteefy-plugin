<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php get_the_title(); ?></title>
    <?php wp_head();?>
</head>
<body>
<!--get header-->
<?php do_action('get_siteefy_nav');?>
<?php do_action( 'get_siteefy_header_small' );
$post = get_the_ID();
$post=get_post($post);


?>
<div class="content">
    <div class="container">
        <div class="breadcrumbs-container">
            <a href="<?php echo get_home_url(); ?>">
                <span class="home-icon">
                    <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><rect width="19" height="19" fill="url(#pattern0_227_420)" fill-opacity="0.3"/><defs><pattern id="pattern0_227_420" patternContentUnits="objectBoundingBox" width="1" height="1"><use xlink:href="#image0_227_420" transform="scale(0.00195312)"/></pattern><image id="image0_227_420" width="512" height="512" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAgAAAAIACAMAAADDpiTIAAAAA3NCSVQICAjb4U/gAAAACXBIWXMAABcaAAAXGgFDFdo3AAAAGXRFWHRTb2Z0d2FyZQB3d3cuaW5rc2NhcGUub3Jnm+48GgAAAqBQTFRF////AQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACAQACxk6x5AAAAN90Uk5TAAECAwQFBgcICQoLDA0ODxAREhMUFRYXGBkaGxwdHh8gISIkJSYnKCorLS4vMDEyMzQ1Njc5Ojs+P0JDREVGR0hJSktPUFFSU1RVVlhZW1xdXl9gYWJjZGVmZ2hpamtsbW9wcXJ0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"/></defs></svg>
                </span>
            </a>
            <span class="separator">
                <svg xmlns="http://www.w3.org/2000/svg" width="8" height="10" viewBox="0 0 8 10" fill="none"><path d="M1 1L7 5L1 9.5" stroke="black" stroke-opacity="0.3" stroke-width="0.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
            <a href="<?php echo get_post_type_archive_link('solution');?>">
                <span class="breadcrumbs__page-title">
                    Solutions
                </span>
            </a>
            <span class="separator">
                <svg xmlns="http://www.w3.org/2000/svg" width="8" height="10" viewBox="0 0 8 10" fill="none"><path d="M1 1L7 5L1 9.5" stroke="black" stroke-opacity="0.3" stroke-width="0.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
            <span class="breadcrumbs__page-title">
                <?php echo $post->post_title; ?>
            </span>
        </div>
        <h2 class="text-blue"><span class="highlight"><?php echo ucfirst($post->post_title); ?></span></h2>
        <div class="search-results__container extra-margin">
            <?php
            $filtered_tools = get_tools_by_solution_id($post->ID);
            foreach ($filtered_tools as $tool){?>
                <div class="tool-item" data-link="<?php siteefy_get_field('tool_review_link', $tool->ID); ?>">
                    <div class="tool-item__inner">
                        <div class="tool-item__img">
                            <img src="<?php siteefy_get_field('tool_image', $tool->ID); ?>" alt="">
                        </div>
                        <div class="tool-item__details">
                            <div class="tool-item__title">
                                <a href="<?php siteefy_get_field('tool_review_link', $tool->ID); ?>"><?php siteefy_get_field('tool_name', $tool->ID); ?></a>
                                <img width="24px" height="24px" src="<?php echo PLUGIN_IMAGE_URL . '/verified-icon.png'?>" alt="">
                            </div>
                            <div class="tool-item__solution-name">
                                <?php echo get_solution_name_by_tool_id($tool->ID); ?>
                            </div>
                        </div>

                    </div>
                    <div class="tool-item__bottom">
                        <?php echo siteefy_get_field('tool_price',$tool->ID) ?>
                        <span class="tool-item__bottom-rating">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="14" viewBox="0 0 15 14" fill="none">
                 <path d="M7.5 0.225955L9.61452 4.51044L9.63779 4.55759L9.68982 4.56515L14.418 5.2522L10.9967 8.5872L10.959 8.6239L10.9679 8.67572L11.7756 13.3848L7.54653 11.1615L7.5 11.137L7.45347 11.1615L3.22442 13.3848L4.0321 8.67572L4.04099 8.6239L4.00334 8.5872L0.581972 5.2522L5.31018 4.56515L5.36221 4.55759L5.38548 4.51044L7.5 0.225955Z" fill="#FFDA10" stroke="#FFCC00" stroke-width="0.2"/>
                </svg>
                <?php echo siteefy_get_field('tool_rating',$tool->ID) ?>
            </span>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>
<!--end of header-->
<?php do_action( 'get_siteefy_footer' ); ?>
<?php wp_footer(); ?>
</body>
</html>

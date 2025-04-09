<?php /* Template Name: Homepage Template */
$post= get_post();
$page_content = $post->post_content;

echo Siteefy::blade()->run('pages.homepage-template', [
    'recent_tools' => get_all_tools(3, 'DESC'),
    'page_content' => $page_content,
]);
?>

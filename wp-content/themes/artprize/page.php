<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * To generate specific templates for your pages you can use:
 * /mytheme/templates/page-mypage.twig
 * (which will still route through this PHP file)
 * OR
 * /mytheme/page-mypage.php
 * (in which case you'll want to duplicate this file and save to the above path)
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::context();

$timber_post     = Timber::get_post();
// $paged = get_query_var('paged') ?: 1; // Get the current page number

// Sort locations
$sort_by = isset($_GET['sort_by']) ? sanitize_text_field($_GET['sort_by']) : 'title';
$sort_order = 'ASC';
switch ($sort_by) {
    case 'titleAsc':
        $sort_orderby = 'title';
        $sort_order = 'ASC';
        break;

    case 'titleDesc':
        $sort_orderby = 'title';
        $sort_order = 'DESC';
        break;

    case 'date':
        $sort_orderby = 'date';
        $sort_order = 'DESC';
        break;

    case 'rand':
        $sort_orderby = 'rand';
        break;

    default:
        $sort_orderby = 'title';
        $sort_order = 'ASC';
}
$locations = [
    'post_type'      => 'post',
    'posts_per_page' => -1,
    'orderby'        => $sort_orderby,
    'order'          => $sort_order
];

$context['post'] = $timber_post;
$context['locations'] = Timber::get_posts($locations);

$templates        = array( '_views/page-' . $timber_post->post_name . '.twig', '_layouts/page.twig' );
if ( is_front_page() ) {
    array_unshift( $templates, '_views/front-page.twig' );
}
Timber::render( $templates, $context );

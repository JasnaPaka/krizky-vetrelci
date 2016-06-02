<?php  

// Vytvoření sitemap

header('Content-type:text/xml');
print('<?xml version="1.0" encoding="UTF-8"?>');

$ROOT = plugin_dir_path( __FILE__ )."../../plugins/wpcity/";
include_once $ROOT."controllers/SitemapController.php";

$controller = new SitemapController();

$objects = $controller->getObjects();
$authors = $controller->getAuthors();
$collections = $controller->getCollections();

print('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">');

// domovská stránka
printf ("<url><loc>%s</loc></url>", site_url()."/");

// všechna url stránek a příspěvků evidovaných ve WordPressu
include "wp-load.php";
 
$posts = new WP_Query('post_type=any&posts_per_page=-1&post_status=publish');
$posts = $posts->posts;

foreach($posts as $post) {
    switch ($post->post_type) {
        case 'revision':
        case 'nav_menu_item':
            break;
        case 'page':
            $permalink = get_page_link($post->ID);
            break;
        case 'post':
            $permalink = get_permalink($post->ID);
            break;
        case 'attachment':
            $permalink = get_attachment_link($post->ID);
            break;
        default:
            $permalink = get_post_permalink($post->ID);
            break;
    }
    printf ("<url><loc>%s</loc></url>", $permalink);
}

// Všechna díla, autoři a soubory děl
foreach ($objects as $object) {
    printf ("<url><loc>%s%s/</loc></url>", site_url()."/katalog/dilo/", $object->id);
}

foreach ($authors as $author) {
    printf ("<url><loc>%s%s/</loc></url>", site_url()."/katalog/autor/", $author->id);
}

foreach ($collections as $collection) {
    printf ("<url><loc>%s%s/</loc></url>", site_url()."/katalog/soubor/", $collection->id);
}
print ('</urlset>');


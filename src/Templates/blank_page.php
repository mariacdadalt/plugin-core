<?php
/**
 * Template Name: Blank Page
 * Template Post Type: post, page
 */ ?>

<!doctype html>
<html <?php language_attributes(); ?> <?php twentytwentyone_the_html_classes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page">
<?php wpillar_component_show_args('button');

wpillar_get_component( 'button', [
    'content' => 'Hello'
] ); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
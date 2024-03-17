<?php
/**
 * Generates HTML markup for displaying a video object.
 * 
 * @package Aparat_Feed
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! isset( $videoobject ) ) {
	return new WP_Error( 'video-object-not-set', 'Video Object is not set' );
}
?>
<article id="post-<?php echo absint( $videoobject->id ); ?>" class="col-xs-6 col-sm-3 col-md-2" style="margin: 0 ;padding: 5px;">

	<header class="panel box bottom-shadow" style="padding: 5px;">
		<figure class="category-post-image">
			<a href="<?php echo esc_url( $videoobject->frame ); ?>" title="<?php echo esc_attr( $videoobject->title ); ?>">
				<img style="margin: 0 auto; width: 128px; height: auto; border-radius: 5px;"
					src="<?php echo esc_url( $videoobject->small_poster ); ?>"
					title="<?php echo esc_attr( $videoobject->title ); ?>" alt="<?php echo esc_attr( $videoobject->title ); ?>"/>
			</a>
		</figure>
		<div>
			<h6 style="text-align: center;height : 70px; overflow: hidden;">
				<a href="<?php echo esc_url( $videoobject->frame ); ?>"
					title="<?php echo esc_attr( $videoobject->title ); ?>"
					rel="bookmark"><?php echo esc_html( $videoobject->title ); ?></a>
			</h6>
		</div>
	</header>

</article>

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
<div class="text-center">
		<a href="<?php echo esc_url( $videoobject->frame ); ?>"
			title="<?php echo esc_attr( $videoobject->title ); ?>"
			rel="bookmark"><?php echo esc_html( $videoobject->title ); ?></a>
</div>

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
<div>
	<a href="<?php echo esc_url( $videoobject->frame ); ?>" title="<?php echo esc_attr( $videoobject->title ); ?>" style="vertical-align: middle;">
		<img style="width: 25px; height: auto; border-radius: 5px; vertical-align: middle;"
			src="<?php echo esc_url( $videoobject->small_poster ); ?>"
			title="<?php echo esc_attr( $videoobject->title ); ?>"
			alt="<?php echo esc_attr( $videoobject->title ); ?>"
		/>
		&nbsp;<?php echo esc_html( $videoobject->title ); ?>
	</a>
</div>

/**
 * Proceeds to define various functions related to handling accordion behavior and interacting with form elements on a webpage.
 * 
 * @package Aparat_Feed_Widget
 */

if ( "undefined" == typeof jQuery ) {
	throw new Error( "JavaScript requires jQuery" );
}

(function ($) {

	'use strict';
	let $body_selector = $( 'body' );
	// accordion
	function ddaf_close_accordions( widget ){
		let $sections      = widget.find( '.ddaf-section' );
		let $first_section = $sections.first();

		$first_section.addClass( 'expanded' ).find( '.ddaf-section-top' ).addClass( 'ddaf-active' );
		$first_section.siblings( '.ddaf-section' ).find( '.ddaf-settings' ).hide();
	}

	function ddaf_on_form_update( event, widget ) {
		// ddaf_close_accordions( widget );
	}

	$( document ).on( 'widget-added widget-updated', ddaf_on_form_update );

	$( '#widgets-right .widget:has(.ddaf-widget-form)' ).each(
		function () {
			ddaf_close_accordions( $( this ) );
		}
	);

	$( '#widgets-right, #accordion-panel-widgets' ).on(
		'click',
		'.ddaf-section-top',
		function () {
			let $header          = $( this );
			let $section         = $header.closest( '.ddaf-section' );
			let $fieldset_id     = $header.data( 'fieldset' );
			let $target_fieldset = $( 'fieldset[data-fieldset-id="' + $fieldset_id + '"]', $section );
			let $content         = $section.find( '.ddaf-settings' );
			$header.toggleClass( 'ddaf-active' );
			$target_fieldset.addClass( 'targeted' );
			$content.slideToggle(
				300,
				function () {
					$section.toggleClass( 'expanded' );
				}
			);
		}
	);

	// list of categories
	$body_selector.on(
		'click',
		'.ddaf-categories-dropdown-link',
		function (e) {
			e.preventDefault();
			let $parent = $( this ).closest( 'div[id]' );
			$parent.find( '#ddaf-categories-wrapper' ).slideToggle( 'fast' );
			$parent.find( '#ddaf-categories-action' ).toggleClass( 'ddaf-categories-action-down' );
			$parent.find( '#ddaf-categories-action' ).toggleClass( 'ddaf-categories-action-up' );
		}
	);

	$body_selector.on(
		'change',
		'.ddaf-post-type-field',
		function (e) {
			e.preventDefault();
			let selected_post_type = $( this ).val();
			let parent             = $( this ).closest( 'div[id]' ).attr( 'id' );
			let $parent_tag        = $( '#' + parent );
			$parent_tag.find( '.ddaf-taxonomy-field' ).html( '<option>Loading...</option>' );
			$parent_tag.find( '.ddaf-category-field' ).html( '<option>Loading...</option>' );
			let data = {
				'action': 'get_taxonomies_list',
				'selected_post_type': selected_post_type
			};
			$.post(
				ajaxurl,
				data,
				function (response) {
					$parent_tag.find( '.ddaf-taxonomy-field' ).html( response );
					ddaf_update_category_field( e, $parent_tag.find( '.ddaf-taxonomy-field' ) );
				}
			);
		}
	);

	function ddaf_update_category_field(e, instance){
		e.preventDefault();
		let selected_taxonomy = $( instance ).val();
		let parent            = $( instance ).closest( 'div[id]' ).attr( 'id' );
		// alert(parent);
		$( '#' + parent ).find( '.ddaf-category-field' ).html( '<option>Loading...</option>' );
		let data = {
			'action': 'get_categories_list',
			'selected_taxonomy': selected_taxonomy
		};
		$.post(
			ajaxurl,
			data,
			function (response) {
				$( '#' + parent ).find( '.ddaf-category-field' ).html( response );
			}
		);
	}

	$body_selector.on(
		'change',
		'.ddaf-taxonomy-field',
		function (e) {
			ddaf_update_category_field( e, this );
		}
	)
}(jQuery));

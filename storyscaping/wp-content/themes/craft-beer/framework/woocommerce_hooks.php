<?php

add_action( 'after_setup_theme', 'boldthemes_woocommerce_support' );

add_filter( 'woocommerce_show_page_title', '__return_false' );
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
add_filter( 'woocommerce_product_tabs', 'boldthemes_woo_remove_product_tabs', 98 );
add_filter( 'woocommerce_output_related_products_args', 'boldthemes_change_number_related_products' );
add_filter( 'loop_shop_per_page', 'boldthemes_loop_shop_per_page', 12 );
add_filter( 'loop_shop_columns', 'boldthemes_loop_shop_columns', 4 );
add_filter ( 'woocommerce_product_thumbnails_columns', 'boldthemes_thumb_cols' );
add_filter( 'woocommerce_output_related_products_args', 'boldthemes_related_products_args' );

add_action( 'woocommerce_after_shop_loop_item', 'boldthemes_after_shop_loop_add_to_cart_link', 10 );
add_action( 'woocommerce_before_shop_loop_item', 'boldthemes_before_shop_loop_item', 10 );

// Ensure cart contents update when products are added to the cart via AJAX (place the following in functions.php)
add_filter( 'woocommerce_add_to_cart_fragments', 'boldthemes_woocommerce_header_add_to_cart_fragment' );

remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

/**
 * WooCommerce support
 */
if ( ! function_exists( 'boldthemes_woocommerce_support' ) ) {
	function boldthemes_woocommerce_support() {
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-zoom' );	
	}
}

/**
 * WooCommerce related products
 */

if ( ! function_exists( 'boldthemes_related_products_args' ) ) {
	function boldthemes_related_products_args( $args ) {
		$args['posts_per_page'] = 3; // n related products
		$args['columns'] = 3; // arranged in n columns
		return $args;
	}
}

/**
 * Remove product tabs
 */
if ( ! function_exists( 'boldthemes_woo_remove_product_tabs' ) ) {
	function boldthemes_woo_remove_product_tabs( $tabs ) {
		unset( $tabs['reviews'] ); // Remove the reviews tab
		return $tabs;
	}
}

/* Woocommerce hooks */
if ( ! function_exists( 'boldthemes_before_shop_loop_item' ) ) {
	function boldthemes_before_shop_loop_item() {
		echo '<div class="btWooShopLoopItemInner">'; // 
	}
}


if ( ! function_exists( 'boldthemes_after_shop_loop_add_to_cart_link' ) ) {
	function boldthemes_after_shop_loop_add_to_cart_link() {
		echo '</div>'; // 
	}
}

if ( ! function_exists( 'boldthemes_thumb_cols' ) ) {
	function boldthemes_thumb_cols() {
		return 3; // .last class applied to every 4th thumbnail
	}
}

	
/**
* Adds click to header dropdown cart
*/
if ( ! function_exists( 'boldthemes_woocommerce_header_add_to_cart_fragment' ) ) {
	function boldthemes_woocommerce_header_add_to_cart_fragment( $fragments ) {
		ob_start(); ?>
		<span class="cart-contents" title="<?php _e( 'View your shopping cart', 'craft-beer' ); ?>"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
		<script>jQuery( '.btCartWidgetIcon' ).unbind('click').on( 'click', function ( e ) { jQuery(this).parent().parent().toggleClass( 'on' ); }); </script> 
		<?php
		$fragments['span.cart-contents'] = ob_get_clean();
		return $fragments;
	}
}

/**
 * Show the product title in the product loop.
 */
if (  ! function_exists( 'woocommerce_template_loop_product_title' ) ) {
	function woocommerce_template_loop_product_title() {
		global $product;

		$subtitle = '';

		if ( get_option( 'woocommerce_enable_review_rating' ) !== 'no' && $rating_html = wc_get_rating_html( $product->get_average_rating() ) ) {
			$subtitle = $rating_html;
		}

		if ( $subtitle == '' ) {
			$subtitle = '<span class="btNoStarRating"></span>';	;
		}

		$categories = wp_get_post_terms( $product->get_id(), 'product_cat' );
		$supertitle = boldthemes_get_post_categories( array( 'categories' => $categories ) );

		$dash = boldthemes_get_option( 'shop_use_dash' ) ? "top" : "";
		
		echo boldthemes_get_heading_html( 
			array( 
				'superheadline' => $supertitle, 
				'headline' => get_the_title(), 
				'subheadline' => $subtitle, 
				'size' => apply_filters( 'boldthemes_product_list_headline_size', 'extrasmall' ),
				'dash' => $dash,
				'url' => get_permalink()
			) 
		);

	}
}

if ( ! function_exists( 'woocommerce_get_product_thumbnail' ) ) {
 
	/**
	 * Get the product thumbnail, or the placeholder if not set.
	 *
	 * @subpackage	Loop
	 * @param string $size (default: 'shop_catalog')
	 * @param int $deprecated1 Deprecated since WooCommerce 2.0 (default: 0)
	 * @param int $deprecated2 Deprecated since WooCommerce 2.0 (default: 0)
	 * @return string
	 */
	function woocommerce_get_product_thumbnail( $size = 'shop_catalog', $deprecated1 = 0, $deprecated2 = 0 ) {
		global $post;

		if ( has_post_thumbnail() ) {
			$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $size );
			return boldthemes_get_image_html( 
				array(
					'image' => $thumbnail[0],
					'caption_title' => '',
					'caption_text' => '',
					'content' => '',
					'size' => '',
					'shape' => '',
					'url' => get_post_permalink(),
					'target' => '_self',
					'show_titles' => false,
					'el_style' => '',
					'el_class' => ''
				)
			);
		} elseif ( wc_placeholder_img_src() ) {
			return wc_placeholder_img( $size );
		}
	}
}
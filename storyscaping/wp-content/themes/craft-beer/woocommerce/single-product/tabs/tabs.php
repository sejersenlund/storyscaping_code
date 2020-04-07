<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

global $post, $product;

$cat_count = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
$tag_count = sizeof( get_the_terms( $post->ID, 'product_tag' ) );

$style_html = '';
$share_html = boldthemes_get_share_html( get_permalink(), 'shop' );
if ( ! empty( $tabs ) ) { 
	if ( count( $tabs ) == 1 ) { 
		$style_html = 'display:none;" ';
	} 
?>
	
	<div class="product-description">
		<div class="bt_bb_tabs bt_bb_style_simple bt_bb_shape_square">
			
			<ul class="bt_bb_tabs_header" style="<?php echo  esc_attr( $style_html ) ; ?>">
				<?php foreach ( $tabs as $key => $tab ) : ?>
					<li class="<?php echo esc_attr( $key ); ?>_tab">
						<span href="#tab-<?php echo esc_attr( $key ); ?>"><?php echo apply_filters( 'woocommerce_product_' . wp_kses_post( $key ) . '_tab_title', esc_html( $tab['title'] ), $key ); ?></span>
					</li>
				<?php endforeach; ?>
			</ul>
			<div class="bt_bb_tabs_tabs">
			<?php foreach ( $tabs as $key => $tab ) : ?>
				<div class="bt_bb_tab_item" id="tab-<?php echo esc_attr( $key ); ?>">
					<div class="bt_bb_tab_content">
						<?php call_user_func( $tab['callback'], $key, $tab ); ?>
					</div>
				</div>
			<?php endforeach; ?>
			</div>
		</div>
	</div>

<?php } ?>

<div class="product-meta">
	<div class="btArticleShareEtc">
		<div class="btTagsColumn">
			<?php do_action( 'woocommerce_product_meta_start' ); ?>
			<?php echo '<div class="btTags"><ul>' . wp_kses_post( wc_get_product_tag_list( $product->get_id(), '</li><li> ', '<li>', '</li>' ) ) . '</ul></div>'; ?>
			<?php do_action( 'woocommerce_product_meta_end' ); ?>
		</div>
		<?php if ( $share_html != '' ) echo '<div class="btShareColumn">' . $share_html . '</div>'; ?>
	</div>
</div>
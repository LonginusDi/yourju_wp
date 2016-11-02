<?php global $post_id, $before_list;

$wishlist = array();
if ( is_user_logged_in() ) {
	$user_id = get_current_user_id();
	$wishlist = get_user_meta( $user_id, 'wishlist', true );
}
if ( ! is_array( $wishlist ) ) $wishlist = array();

$price = get_post_meta( $post_id, '_tour_price', true );
if ( empty( $price ) ) $price = 0;
$tour_type = wp_get_post_terms( $post_id, 'tour_type' );
$brief = get_post_meta( $post_id, '_tour_brief', true );
if ( empty( $brief ) ) {
	$brief = apply_filters('the_content', get_post_field('post_content', $post_id));
	$brief = wp_trim_words( $brief, 20, '' );
}
$review = get_post_meta( $post_id, '_review', true );
$review = ( ! empty( $review ) )?round( $review, 1 ):0;
$wishlist_link = ct_wishlist_page_url();
?>
<?php if ( ! empty( $before_list ) ) {
	echo ( $before_list );
} else { ?>
	<div class="col-md-6 col-sm-6 wow zoomIn" data-wow-delay="0.1s">
<?php } ?>
	<div class="tour_container">
		<div class="img_container">
			<a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>">
			<?php echo get_the_post_thumbnail( $post_id, 'ct-list-thumb' ); ?>
			<!-- <div class="ribbon top_rated"></div> -->
			<div class="short_info">
				<?php
					if ( ! empty( $tour_type ) ) {
						$icon_class = get_tax_meta($tour_type[0]->term_id, 'ct_tax_icon_class', true);
						if ( ! empty( $icon_class ) ) echo '<i class="' . $icon_class . '"></i>' . $tour_type[0]->name;
					}
				?>
				<span class="price"><?php echo ct_price( $price, 'special' ) ?></span>
			</div>
			</a>
		</div>
		<div class="tour_title">
			<h3><?php echo esc_html( get_the_title( $post_id ) );?></h3>
			<div class="rating">
				<?php ct_rating_smiles( $review )?><small>(<?php echo esc_html( ct_get_review_count( $post_id ) ) ?>)</small>
			</div><!-- end rating -->
			<?php if ( ! empty( $wishlist_link ) ) : ?>
			<div class="wishlist">
				<a class="tooltip_flip tooltip-effect-1 btn-add-wishlist" href="#" data-post-id="<?php echo esc_attr( $post_id ) ?>"<?php echo ( in_array( ct_tour_org_id( $post_id ), $wishlist) ? ' style="display:none;"' : '' ) ?>><span class="wishlist-sign">+</span><span class="tooltip-content-flip"><span class="tooltip-back"><?php esc_html_e(  'Add to wishlist', 'citytours' ); ?></span></span></a>
				<a class="tooltip_flip tooltip-effect-1 btn-remove-wishlist" href="#" data-post-id="<?php echo esc_attr( $post_id ) ?>"<?php echo ( ! in_array( ct_tour_org_id( $post_id ), $wishlist) ? ' style="display:none;"' : '' ) ?>><span class="wishlist-sign">-</span><span class="tooltip-content-flip"><span class="tooltip-back"><?php esc_html_e(  'Remove from wishlist', 'citytours' ); ?></span></span></a>
			</div><!-- End wish list-->
			<?php endif; ?>
		</div>
	</div><!-- End box tour -->
</div><!-- End col-md-6 -->
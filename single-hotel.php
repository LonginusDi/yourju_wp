<?php
get_header();

if ( have_posts() ) {
	while ( have_posts() ) : the_post();
		$post_id = get_the_ID();
		$address = get_post_meta( $post_id, '_hotel_address', true );
		$person_price = get_post_meta( $post_id, '_hotel_price', true );
		if ( empty( $person_price ) ) $person_price = 0;
		$slider = get_post_meta( $post_id, '_hotel_slider', true );
		$star_rating = get_post_meta( $post_id, '_hotel_star', true );
		$minimum_stay = get_post_meta( $post_id, '_hotel_minimum_stay', true );

		$args = array(
			'post_type' => 'room_type',
			'posts_per_page' => -1,
			'meta_query' => array(
				array(
					'key' => '_room_hotel_id',
					'value' => array( $post_id )
				)
			),
			'suppress_filters' => 0,
		);
		$room_types = get_posts( $args );

		$header_img_scr = ct_get_header_image_src( $post_id );
		if ( ! empty( $header_img_scr ) ) {
			$header_img_height = ct_get_header_image_height( $post_id );
			?>

			<section class="parallax-window" data-parallax="scroll" data-image-src="<?php echo esc_url( $header_img_scr ) ?>" data-natural-width="1400" data-natural-height="<?php echo esc_attr( $header_img_height ) ?>">
				<div class="parallax-content-2">
					<div class="container">
						<div class="row">
							<div class="col-md-8 col-sm-8">
								<span class="rating">
								<?php ct_rating_smiles( $star_rating, 'icon-star-empty', 'icon-star voted' ); ?>
								</span>
								<h1><?php the_title() ?></h1>
								<span><?php echo esc_html( $address, 'citytours' ); ?></span>
							</div>
							<div class="col-md-4 col-sm-4">
								<div id="price_single_main">
									<?php echo esc_html__( 'from/per night', 'citytours' ) ?> <?php echo ct_price( $person_price, "special" ) ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section><!-- End section -->
			<div id="position">

		<?php } else { ?>
			<div id="position" class="blank-parallax">
		<?php } ?>

			<div class="container"><?php ct_breadcrumbs(); ?></div>
		</div><!-- End Position -->

<div class="container margin_60">
	<div class="row">
		<div class="col-md-8" id="single_tour_desc">

			<div id="single_tour_feat">
				<ul>
					<?php
						require_once(get_template_directory() . '/inc/lib/tax-meta-class/Tax-meta-class.php');
						$hotel_facilities = get_the_terms( $post_id, 'hotel_facility' );
						if ( ! $hotel_facilities || is_wp_error( $hotel_facilities ) ) $hotel_facilities = array();
						foreach ( $hotel_facilities as $hotel_term ) :
							$term_id = $hotel_term->term_id;
							$icon_class = get_tax_meta($term_id, 'ct_tax_icon_class', true);
							echo '<li>';
							if ( ! empty( $icon_class ) ) echo '<i class="' . esc_attr( $icon_class ) . '"></i>';
							echo esc_html( $hotel_term->name );
							echo '</li>';
						endforeach; ?>
				</ul>
			</div>

			<?php if ( ! empty( $slider ) ) : ?>
				<?php echo do_shortcode( $slider ); ?>
				<hr>
			<?php endif; ?>

			<div class="row">
				<div class="col-md-3">
					<h3><?php echo esc_html__( 'Description', 'citytours') ?></h3>
				</div>
				<div class="col-md-9">
					<?php the_content(); ?>
				</div>
			</div>

			<hr>

			<div class="row">
				<div class="col-md-3">
					<h3><?php echo esc_html__( 'Rooms Types', 'citytours' ) ?></h3>
				</div>
				<div class="col-md-9">
					<?php if ( ! empty( $room_types ) ) : ?>
						<?php 
						$is_first = true;
						foreach( $room_types as $post ) : setup_postdata( $post ); ?>
							<?php if ( $is_first ) { $is_first = false; } else { echo '<hr>'; } ?>
							<h4><?php the_title() ?></h4>
							<?php the_content() ?>
							<ul class="list_icons">

								<?php $room_type_id = get_the_ID();
								$hotel_facilities = get_the_terms( $room_type_id, 'hotel_facility' );
								if ( ! $hotel_facilities || is_wp_error( $hotel_facilities ) ) $hotel_facilities = array();
								foreach ( $hotel_facilities as $hotel_term ) :
									$term_id = $hotel_term->term_id;
									$icon_class = get_tax_meta($term_id, 'ct_tax_icon_class', true);
									echo '<li>';
									if ( ! empty( $icon_class ) ) echo '<i class="' . esc_attr( $icon_class ) . '"></i>';
									echo esc_html( $hotel_term->name );
									echo '</li>';
								endforeach; ?>

							</ul>
							<?php $gallery_imgs = get_post_meta( $room_type_id, '_gallery_imgs' );?>
							<?php if ( ! empty( $gallery_imgs ) ) : ?>
								<div class="carousel magnific-gallery">
									<?php foreach ( $gallery_imgs as $gallery_img ) {
										echo '<div class="item"><a href="' . esc_url( wp_get_attachment_url( $gallery_img ) ) . '">' . wp_get_attachment_image( $gallery_img, 'full' ) . '</a></div>';
									} ?>
								</div>
							<?php endif; ?>
							<?php wp_reset_postdata(); ?>
						<?php endforeach ?>
					<?php endif; ?>

				</div><!-- End col-md-9  -->
			</div><!-- End row  -->

			<hr>

			<?php
			global $ct_options;
			if ( ! empty( $ct_options['hotel_review'] ) ) :
				$review_fields = ! empty( $ct_options['hotel_review_fields'] ) ? explode( ",", $ct_options['hotel_review_fields'] ) : array("Position", "Comfort", "Price", "Quality");
				$review = get_post_meta( ct_hotel_org_id( $post_id ), '_review', true );
				// $review = round( ( ! empty( $review ) ) ? (float) $review : 0, 1 );
				$doubled_review = number_format( round( $review * 2, 1 ), 1 );
				$review_content = '';
				if ( $doubled_review >= 9 ) {
					$review_content = esc_html__( 'Superb', 'citytours' );
				} elseif ( $doubled_review >= 8 ) {
					$review_content = esc_html__( 'Very good', 'citytours' );
				} elseif ( $doubled_review >= 7 ) {
					$review_content = esc_html__( 'Good', 'citytours' );
				} elseif ( $doubled_review >= 6 ) {
					$review_content = esc_html__( 'Pleasant', 'citytours' );
				} else {
					$review_content = esc_html__( 'Review Rating', 'citytours' );
				}
				$review_detail = get_post_meta( ct_hotel_org_id( $post_id ), '_review_detail', true );
				if ( ! empty( $review_detail ) ) {
					$review_detail = is_array( $review_detail ) ? $review_detail : unserialize( $review_detail );
				} else {
					$review_detail = array_fill( 0, count( $review_fields ), 0 );
				}
				?>
				<div class="row">
					<div class="col-md-3">
						<h3><?php echo esc_html__( 'Reviews', 'citytours') ?></h3>
						<a href="#" class="btn_1 add_bottom_15" data-toggle="modal" data-target="#myReview"><?php echo esc_html__( 'Leave a review', 'citytours') ?></a>
					</div>
					<div class="col-md-9">
						<div id="score_detail"><span><?php echo esc_html( $doubled_review ) ?></span><?php echo esc_html( $review_content ) ?> <small><?php echo sprintf( esc_html__( '(Based on %d reviews)' , 'citytours' ), ct_get_review_count( $post_id ) ) ?></small></div>
						<div class="row" id="rating_summary">
							<div class="col-md-6">
								<ul>
									<?php for ( $i = 0; $i < ( count( $review_fields ) / 2 ); $i++ ) { ?>
									<li><?php echo esc_html( $review_fields[ $i ], 'citytours' ); ?>
										<div class="rating"><?php echo ct_rating_smiles( $review_detail[ $i ] ) ?></div>
									</li>
									<?php } ?>
								</ul>
							</div>
							<div class="col-md-6">
								<ul>
									<?php for ( $i = $i; $i < count( $review_fields ); $i++ ) { ?>
									<li><?php echo esc_html( $review_fields[ $i ], 'citytours' ); ?>
										<div class="rating"><?php echo ct_rating_smiles( $review_detail[ $i ] ) ?></div>
									</li>
									<?php } ?>
								</ul>
							</div>
						</div><!-- End row -->
						<hr>
						<div class="guest-reviews">
							<?php
								$per_page = 10;
								$review_count = ct_get_review_html($post_id, 0, $per_page);
							?>
						</div>
						<?php if ( $review_count >= $per_page ) { ?>
							<a href="#" class="btn_1 more-review" data-post_id="<?php echo esc_attr( $post_id ) ?>"><?php echo esc_html__( 'LOAD MORE REVIEWS', 'citytours' ) ?></a>
						<?php } ?>
					</div>
				</div>

			<?php  endif; ?>

		</div><!--End  single_tour_desc-->

		<aside class="col-md-4">

		<div class="box_style_1 expose">
			<h3 class="inner"><?php echo esc_html__( 'Check Availability', 'citytours' ) ?></h3>
			<?php if ( ct_get_hotel_cart_page() ) : ?>
			<form method="get" id="booking-form" action="<?php echo esc_url( ct_get_hotel_cart_page() ); ?>">
				<input type="hidden" name="hotel_id" value="<?php echo esc_attr( $post_id ) ?>">
				<div class="row">
					<div class="col-md-6 col-sm-6">
						<div class="form-group">
							<label><i class="icon-calendar-7"></i> <?php echo esc_html__( 'Check in', 'citytours' ) ?></label>
							<input class="date-pick form-control" data-date-format="<?php echo ct_get_date_format('html'); ?>" type="text" name="date_from">
						</div>
					</div>
					<div class="col-md-6 col-sm-6">
						 <div class="form-group">
							<label><i class="icon-calendar-7"></i> <?php echo esc_html__( 'Check out', 'citytours' ) ?></label>
							<input class="date-pick form-control" data-date-format="<?php echo ct_get_date_format('html'); ?>" type="text" name="date_to">
						</div>
					</div>
				</div>
				<br>
				<button type="submit" class="btn_full book-now"><?php echo esc_html__( 'Check now', 'citytours' ) ?></button>
				<?php if ( ! empty( $ct_options['wishlist'] ) ) : ?>
				<?php if ( is_user_logged_in() ) {
					$user_id = get_current_user_id();
					$wishlist = get_user_meta( $user_id, 'wishlist', true );
					if ( empty( $wishlist ) ) $wishlist = array();?>
						<a class="btn_full_outline btn-add-wishlist" href="#" data-post-id="<?php echo esc_attr( $post_id ) ?>"<?php echo ( in_array( ct_hotel_org_id( $post_id ), $wishlist) ) ? ' style="display:none;"' : '' ?>><i class=" icon-heart"></i> <?php echo esc_html__( 'Add to wishlist', 'citytours' ) ?></a>
						<a class="btn_full_outline btn-remove-wishlist" href="#" data-post-id="<?php echo esc_attr( $post_id ) ?>"<?php echo ( ! in_array( ct_hotel_org_id( $post_id ), $wishlist) ) ? ' style="display:none;"' : '' ?>><i class=" icon-heart"></i> <?php esc_html_e(  'Remove from wishlist', 'citytours' ); ?></a>
				<?php } else { ?>
						<div><?php esc_html_e(  'To save your wishlist please login.', 'citytours' ); ?></div>
						<a href="<?php echo esc_url( ct_login_url() ); ?>" class="btn_full_outline"><?php esc_html_e(  'login', 'citytours' ); ?></a>
				<?php } ?>
				<?php endif; ?>
			</form>
			<?php else : ?>
				<?php echo wp_kses_post( sprintf( __( 'Please set hotel booking page on <a href="%s">Theme Options</a>/Hotel Main Settings', 'citytours' ), esc_url( admin_url( 'themes.php?page=CityTours' ) ) ) ); ?>
			<?php endif; ?>
		</div><!--/box_style_1 -->

		<?php if ( is_active_sidebar( 'sidebar-hotel' ) ) : ?>
			<?php dynamic_sidebar( 'sidebar-hotel' ); ?>
		<?php endif; ?>

		</aside>
	</div><!--End row -->
</div><!--End container -->
<?php if ( ! empty( $ct_options['hotel_review'] ) ) : ?>
<div class="modal fade" id="myReview" tabindex="-1" role="dialog" aria-labelledby="myReviewLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
				<h4 class="modal-title" id="myReviewLabel"><?php echo esc_html__( 'Write your review', 'citytours' ) ?></h4>
			</div>
			<div class="modal-body">
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ) ?>" name="review" id="review-form">
					<?php wp_nonce_field( 'post-' . $post_id, '_wpnonce', false ); ?>
					<input type="hidden" name="post_id" value="<?php echo esc_attr( $post_id ); ?>">
					<input type="hidden" name="action" value="submit_review">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<input name="booking_no" id="booking_no" type="text" placeholder="<?php echo esc_html__( 'Booking No', 'citytours' ) ?>" class="form-control">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<input name="pin_code" id="pin_code" type="text" placeholder="<?php echo esc_html__( 'Pin Code', 'citytours' ) ?>" class="form-control">
							</div>
						</div>
					</div>
					<!-- End row -->
					<hr>
					<div class="row">
						<?php for ( $i = 0; $i < ( count( $review_fields ) ); $i++ ) { ?>
							<div class="col-md-6">
								<div class="form-group">
									<label><?php echo esc_html( $review_fields[ $i ], 'citytours' ); ?></label>
									<select class="form-control" name="review_rating_detail[<?php echo esc_attr( $i ) ?>]">
										<option value="0"><?php esc_html_e( "Please review", 'citytours' ); ?></option>
										<option value="1"><?php esc_html_e( "Low", 'citytours' ); ?></option>
										<option value="2"><?php esc_html_e( "Sufficient", 'citytours' ); ?></option>
										<option value="3"><?php esc_html_e( "Good", 'citytours' ); ?></option>
										<option value="4"><?php esc_html_e( "Excellent", 'citytours' ); ?></option>
										<option value="5"><?php esc_html_e( "Super", 'citytours' ); ?></option>
									</select>
								</div>
							</div>
						<?php } ?>
					</div>
					<!-- End row -->
					<div class="form-group">
						<textarea name="review_text" id="review_text" class="form-control" style="height:100px" placeholder="<?php esc_html_e( "Write your review", 'citytours' ); ?>"></textarea>
					</div>
					<input type="submit" value="Submit" class="btn_1" id="submit-review">
				</form>
				<div id="message-review" class="alert alert-warning">
				</div>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>
<script>
$ = jQuery.noConflict();
$(document).ready(function(){
	$('input.date-pick').datepicker({
		startDate: "today"
	});
	$('input[name="date_from"]').datepicker( 'setDate', 'today' );
	$('input[name="date_to"]').datepicker( 'setDate', '+1d' );
	$('#booking-form').submit(function(){
		var minimum_stay = 0;
		<?php if ( ! empty( $minimum_stay ) ) { echo 'minimum_stay=' . $minimum_stay .';'; } ?>
		var date_from = $('input[name="date_from"]').datepicker('getDate').getTime();
		var date_to = $('input[name="date_to"]').datepicker('getDate').getTime();
		var one_day = 1000*60*60*24;
		if ( date_from + one_day * minimum_stay > date_to ) {
			alert( "<?php echo esc_js( sprintf( __( 'Minimum stay for this hotel is %d nights. Have another look at your dates and try again.', 'citytours' ), $minimum_stay ) ) ?>" );
			return false;
		}
	});
});
</script>

<?php endwhile;
}
get_footer();
<?php
get_header();

if ( have_posts() ) {
	while ( have_posts() ) : the_post();

		//init variables
		$post_id = get_the_ID();
		$address = get_post_meta( $post_id, '_tour_address', true );

		$is_repeated =  get_post_meta( $post_id, '_tour_repeated', true );
		$person_price = get_post_meta( $post_id, '_tour_price', true );
		if ( empty( $person_price ) ) $person_price = 0;
		$charge_child = get_post_meta( $post_id, '_tour_charge_child', true );
		$child_price = get_post_meta( $post_id, '_tour_price_child', true );

		$slider = get_post_meta( $post_id, '_tour_slider', true );
		$schedule_info = get_post_meta( $post_id, '_tour_schedule_info', true );

		$review = get_post_meta( $post_id, '_review', true );
		$review = ( ! empty( $review ) )?round( $review, 1 ):0;

		$header_img_scr = ct_get_header_image_src( $post_id );
		if ( ! empty( $header_img_scr ) ) {
			$header_img_height = ct_get_header_image_height( $post_id );
			?>

			<section class="parallax-window" data-parallax="scroll" data-image-src="<?php echo esc_url( $header_img_scr ) ?>" data-natural-width="1400" data-natural-height="<?php echo esc_attr( $header_img_height ) ?>">
				<div class="parallax-content-2">
					<div class="container">
						<div class="row">
							<div class="col-md-8 col-sm-8">
								<h1><?php the_title() ?></h1>
								<span><?php echo esc_html( $address, 'citytours' ); ?></span>
								<span class="rating"><?php ct_rating_smiles( $review )?><small>(<?php echo esc_html( ct_get_review_count( $post_id ) ) ?>)</small></span>
							</div>
							<div class="col-md-4 col-sm-4">
								<div id="price_single_main">
									<?php echo esc_html__( 'from/per person', 'citytours' ) ?> <?php echo ct_price( $person_price, "special" ) ?>
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
						$tour_types = get_the_terms( $post_id, 'tour_type' );
						$tour_facilities = get_the_terms( $post_id, 'tour_facility' );
						if ( ! $tour_types || is_wp_error( $tour_types ) ) $tour_types = array();
						if ( ! $tour_facilities || is_wp_error( $tour_facilities ) ) $tour_facilities = array();
						$tour_terms = array_merge( $tour_types, $tour_facilities );
						foreach ( $tour_terms as $tour_term ) :
							$term_id = $tour_term->term_id;
							$icon_class = get_tax_meta($term_id, 'ct_tax_icon_class', true);
							echo '<li>';
							if ( ! empty( $icon_class ) ) echo '<i class="' . esc_attr( $icon_class ) . '"></i>';
							echo esc_html( $tour_term->name );
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
			<?php if ( ! empty( $schedule_info ) ) : ?>
			<div class="row">
				<div class="col-md-3">
					<h3><?php echo esc_html__( 'Schedule', 'citytours') ?></h3>
				</div>
				<div class="col-md-9">
					<?php echo do_shortcode( $schedule_info ); ?>
				</div>
			</div>

			<hr>
			<?php endif; ?>

			<?php
			global $ct_options;
			if ( ! empty( $ct_options['tour_review'] ) ) :
				$review_fields = ! empty( $ct_options['tour_review_fields'] ) ? explode( ",", $ct_options['tour_review_fields'] ) : array("Position", "Comfort", "Price", "Quality");
				$review = get_post_meta( ct_tour_org_id( $post_id ), '_review', true );
				$review = round( ( ! empty( $review ) ) ? (float) $review : 0, 1 );
				$review_detail = get_post_meta( ct_tour_org_id( $post_id ), '_review_detail', true );
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
						<div id="general_rating"><?php echo sprintf( esc_html__( '%d Reviews', 'citytours' ), ct_get_review_count( $post_id ) ) ?>
							<div class="rating"><?php echo ct_rating_smiles( $review ) ?></div>
						</div>
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
							<a href="#" class="btn more-review" data-post_id="<?php echo esc_attr( $post_id ) ?>"><?php echo esc_html__( 'LOAD MORE REVIEWS', 'citytours' ) ?></a>
						<?php } ?>
					</div>
				</div>

			<?php  endif; ?>

		</div><!--End  single_tour_desc-->

		<aside class="col-md-4">

		<div class="box_style_1 expose">
			<h3 class="inner">- <?php echo esc_html__( 'Booking', 'citytours' ) ?> -</h3>
			<?php if ( ct_get_tour_cart_page() ) : ?>
			<form method="get" id="booking-form" action="<?php echo esc_url( ct_get_tour_cart_page() ); ?>">
				<input type="hidden" name="tour_id" value="<?php echo esc_attr( $post_id ) ?>">
				<?php if ( ! empty( $is_repeated ) ) : ?>
				<div class="row">
					<div class="col-md-6 col-sm-6">
						<div class="form-group">
							<label><i class="icon-calendar-7"></i> <?php echo esc_html__( 'Select a date', 'citytours' ) ?></label>
							<input class="date-pick form-control" data-date-format="<?php echo ct_get_date_format('html'); ?>" type="text" name="date">
						</div>
					</div>
				</div>
				<?php endif; ?>
				<div class="row">
					<div class="col-md-6 col-sm-6">
						<div class="form-group">
							<label><?php echo esc_html__( 'Adults', 'citytours' ) ?></label>
							<div class="numbers-row" data-min="1">
								<input type="text" value="1" id="adults" class="qty2 form-control" name="adults">
							</div>
						</div>
					</div>
					<?php if ( ! empty( $charge_child ) ) : ?>
					<div class="col-md-6 col-sm-6">
						<div class="form-group">
							<label><?php echo esc_html__( 'Children', 'citytours' ) ?></label>
							<div class="numbers-row" data-min="0">
								<input type="text" value="0" id="children" class="qty2 form-control" name="kids">
							</div>
						</div>
					</div>
					<?php endif; ?>
				</div>
				<br>
				<table class="table table_summary">
				<tbody>
				<tr>
					<td>
						<?php echo esc_html__( 'Adults', 'citytours' ) ?>
					</td>
					<td class="text-right adults-number">
						1
					</td>
				</tr>
				<?php if ( ! empty( $charge_child ) ) : ?>
				<tr>
					<td>
						<?php echo esc_html__( 'Children', 'citytours' ) ?>
					</td>
					<td class="text-right children-number">
						0
					</td>
				</tr>
				<?php endif; ?>
				<tr>
					<td>
						<?php echo esc_html__( 'Total amount', 'citytours' ) ?>
					</td>
					<td class="text-right">
						<span class="adults-number">1</span>x <?php echo ct_price( $person_price ) ?>
						<?php if ( ! empty( $child_price ) ) : ?>
							<span class="child-amount hide"> + <span class="children-number">0</span>x <?php echo ct_price( $child_price ) ?></span>
						<?php endif; ?>
					</td>
				</tr>
				<tr class="total">
					<td>
						<?php echo esc_html__( 'Total cost', 'citytours' ) ?>
					</td>
					<td class="text-right total-cost">
						<?php echo ct_price( $person_price ) ?>
					</td>
				</tr>
				</tbody>
				</table>
				<button type="submit" class="btn_full book-now"><?php echo esc_html__( 'Book now', 'citytours' ) ?></button>
				<?php if ( ! empty( $ct_options['wishlist'] ) ) : ?>
				<?php if ( is_user_logged_in() ) {
					$user_id = get_current_user_id();
					$wishlist = get_user_meta( $user_id, 'wishlist', true );
					if ( empty( $wishlist ) ) $wishlist = array(); ?>
						<a class="btn_full_outline btn-add-wishlist" href="#" data-label-add="<?php esc_html_e(  'Add to wishlist', 'citytours' ); ?>" data-label-remove="<?php esc_html_e(  'Remove from wishlist', 'citytours' ); ?>" data-post-id="<?php echo esc_attr( $post_id ) ?>"<?php echo ( in_array( ct_hotel_org_id( $post_id ), $wishlist) ) ? ' style="display:none;"' : '' ?>><i class=" icon-heart"></i> <?php echo esc_html__( 'Add to wishlist', 'citytours' ) ?></a>
						<a class="btn_full_outline btn-remove-wishlist" href="#" data-label-add="<?php esc_html_e(  'Add to wishlist', 'citytours' ); ?>" data-label-remove="<?php esc_html_e(  'Remove from wishlist', 'citytours' ); ?>" data-post-id="<?php echo esc_attr( $post_id ) ?>"<?php echo ( ! in_array( ct_hotel_org_id( $post_id ), $wishlist) ) ? ' style="display:none;"' : '' ?>><i class=" icon-heart"></i> <?php esc_html_e(  'Remove from wishlist', 'citytours' ); ?></a>
				<?php } else { ?>
						<div><?php esc_html_e(  'To save your wishlist please login.', 'citytours' ); ?></div>
						<a href="<?php echo esc_url( ct_login_url() ); ?>" class="btn_full_outline"><?php esc_html_e(  'login', 'citytours' ); ?></a>
				<?php } ?>
				<?php endif; ?>
			</form>
			<?php else : ?>
				<?php echo wp_kses_post( sprintf( __( 'Please set tour booking page on <a href="%s">Theme Options</a>/Tour Main Settings', 'citytours' ), esc_url( admin_url( 'themes.php?page=CityTours' ) ) ) ); ?>
			<?php endif; ?>
		</div><!--/box_style_1 -->
		<?php if ( is_active_sidebar( 'sidebar-tour' ) ) : ?>
			<?php dynamic_sidebar( 'sidebar-tour' ); ?>
		<?php endif; ?>

		</aside>
	</div><!--End row -->
</div><!--End container -->
<?php if ( ! empty( $ct_options['tour_review'] ) ) : ?>
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
var price_per_person = 0;
var price_per_child = 0;
var exchange_rate = 1;

<?php if ( ! empty( $person_price ) ) : ?>
	price_per_person = <?php echo esc_js( $person_price ); ?>;
<?php endif; ?>
<?php if ( ! empty( $child_price ) ) : ?>
	price_per_child = <?php echo esc_js( $child_price ); ?>;
<?php endif; ?>
<?php if ( ! empty( $_SESSION['exchange_rate'] ) ) : ?>
	exchange_rate = <?php echo esc_js( $_SESSION['exchange_rate'] ); ?>;
<?php endif; ?>

$(document).ready(function(){
	if ( $('input.date-pick').length ) {
		$('input.date-pick').datepicker({
			startDate: "today"
		});
		$('input[name="date"]').datepicker( 'setDate', 'today' );
	}
	if ( $('input.time-pick').length ) {
		$('input.time-pick').timepicker({
			minuteStep: 15,
			showInpunts: false
		});
	}
	$('input#adults').on('change', function(){
		$('.adults-number').html( $(this).val() );
		update_tour_price();
	});
	$('input#children').on('change', function(){
		$('.children-number').html( $(this).val() );
		update_tour_price();
	});
	var validation_rules = {};
	if ( $('input.date-pick').length ) {
		validation_rules.date = { required: true};
	}
	//validation form
	$('#booking-form').validate({
		rules: validation_rules
	});
});

function update_tour_price() {
	var adults = $('input#adults').val();
	var children = 0;
	if ( $('input#children').length ) {
		children = $('input#children').val();
	}
	var price = +( (adults * price_per_person + children * price_per_child) * exchange_rate ).toFixed(2);
	$('.child-amount').toggleClass( 'hide', children < 1 );
	var total_price = $('.total-cost').text().replace(/[\d\.\,]+/g, price);
	$('.total-cost').text( total_price );
}
</script>

<?php endwhile;
}
get_footer();
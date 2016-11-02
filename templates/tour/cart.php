<?php

// validation
$required_params = array( 'tour_id' );
foreach ( $required_params as $param ) {
	if ( ! isset( $_REQUEST[ $param ] ) ) {
		do_action( 'ct_tour_booking_wrong_data' ); // ct_redirect_home() - if data is not valid return to home
		exit;
	}
}

// init variables
$tour_id = $_REQUEST['tour_id'];
$is_repeated =  get_post_meta( $tour_id, '_tour_repeated', true );
$charge_child = get_post_meta( $tour_id, '_tour_charge_child', true );
$deposit_rate = get_post_meta( $tour_id, '_tour_security_deposit', true );
$deposit_rate = empty( $deposit_rate ) ? 0 : $deposit_rate;
$add_services = ct_get_add_services_by_postid( $tour_id );

$date = '';
if ( ! empty( $is_repeated ) ) {
	if ( empty( $_REQUEST['date'] ) ) {
		do_action( 'ct_tour_booking_wrong_data' ); // ct_redirect_home() - if data is not valid return to home
		exit;
	}
	$date = $_REQUEST['date'];
}
$uid = $tour_id . $date;
if ( $cart_data = CT_Hotel_Cart::get( $uid ) ) {
	// init booking info if cart is not empty
	$adults = $cart_data['tour']['adults'];
	$kids = $cart_data['tour']['kids'];
	$total_price = $cart_data['tour']['total'];
} else {
	// init cart if it is empty
	$adults = ( isset( $_REQUEST['adults'] ) ) ? $_REQUEST['adults'] : 1;
	$kids = ( isset( $_REQUEST['kids'] ) ) ? $_REQUEST['kids'] : 0;
	$total_price = ct_tour_calc_tour_price( $tour_id, $date, $adults, $kids );
	$cart_data = array('tour'=>array('adults'=>$adults, 'kids'=>$kids, 'total'=>$total_price),
					'tour_id' => $tour_id,
					'date' => $date,
					'total_adults' => $adults,
					'total_kids' => $kids,
					'total_price' => $total_price,
	);
	CT_Hotel_Cart::set( $uid, $cart_data );
}

$cart = new CT_Hotel_Cart();
$cart_service = $cart->get_field( $uid, 'add_service' );

// main function
if ( ! ct_get_tour_checkout_page() ) { ?>
	<h5 class="alert alert-warning"><?php echo esc_html__( 'Please set checkout page in theme options panel.', 'citytours' ) ?></h5>
<?php 
} else {
	// function
	$is_available = ct_tour_check_availability( $tour_id, $date, $adults, $kids );
	if ( true === $is_available ) : ?>

	<form id="tour-cart" action="<?php echo esc_url( add_query_arg( array('uid'=> $uid), ct_get_tour_checkout_page() ) ); ?>">
		<div class="row">
			<div class="col-md-8">
				<?php do_action( 'tour_cart_main_before' ); ?>
				<table class="table table-striped cart-list tour add_bottom_30">
					<thead><tr>
						<th><?php echo esc_html__( 'Item', 'citytours' ) ?></th>
						<th><?php echo esc_html__( 'Adults', 'citytours' ) ?></th>
						<?php if ( ! empty( $charge_child ) ) : ?>
							<th><?php echo esc_html__( 'Childs', 'citytours' ) ?></th>
						<?php endif; ?>
						<th><?php echo esc_html__( 'Total', 'citytours' ) ?></th>
					</tr></thead>
					<tbody>
						<tr>
							<td>
								<div class="thumb_cart">
									<a href="#" data-toggle="modal" data-target="#tour-<?php echo esc_attr( $tour_id ) ?>"><?php echo get_the_post_thumbnail( $tour_id, 'thumbnail' ); ?></a>
								</div>
								 <span class="item_cart"><a href="#" data-toggle="modal" data-target="#tour-<?php echo esc_attr( $tour_id ) ?>"><?php echo esc_html( get_the_title( $tour_id ) ); ?></a></span>
							</td>
							<td>
								<div class="numbers-row" data-min="1">
									<input type="text" class="qty2 form-control tour-adults" name="adults" value="<?php echo esc_attr( $adults ) ?>">
								</div>
							</td>
							<td>
								<?php if ( ! empty( $charge_child ) ) : ?>
								<div class="numbers-row" data-min="0">
									<input type="text" class="qty2 form-control tour-kids" name="kids" value="<?php echo esc_attr( $kids ) ?>">
								</div>
								<?php endif; ?>
							</td>
							<td><strong><?php if ( ! empty( $total_price ) ) echo ct_price( $total_price ) ?></strong></td>
						</tr>
					</tbody>
					</table>

					<?php if ( ! empty( $add_services ) ) : ?>
					<table class="table table-striped options_cart">
						<thead><tr><th colspan="3"><?php echo esc_html__( 'Add options / Services', 'citytours' ) ?></th></tr></thead>
						<tbody>
							<?php foreach ( $add_services as $service ) : ?>
								<tr>
									<td>
										<i class="<?php echo esc_attr( $service->icon_class ); ?>"></i>
									</td>
									<td>
										<?php echo esc_attr( $service->title ); ?> 
										<strong>+<?php echo ct_price( $service->price );
										if ( ! empty( $service->per_person ) ) {
											if ( ! empty( $service->inc_child ) ) {
												echo '**';
											} else {
												echo '*';
											}
										} ?></strong>
									</td>
									<td>
										<label class="switch-light switch-ios pull-right">
										<input type="checkbox" name="add_service[<?php echo esc_attr( $service->id ); ?>]" value="1"<?php if ( ! empty( $cart_service ) && ! empty( $cart_service[ $service->id ] ) ) echo ' checked="checked"' ?>>
										<span>
										<span><?php echo esc_html__( 'No', 'citytours' ) ?></span>
										<span><?php echo esc_html__( 'Yes', 'citytours' ) ?></span>
										</span>
										<a></a>
										</label>
									</td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
					<small><?php echo esc_html__( '* Prices per person.', 'citytours' ) ?></small><br/>
					<small><?php echo esc_html__( '** Prices per person including child.', 'citytours' ) ?></small>    
					<?php endif; ?>
				<?php do_action( 'tour_cart_main_after' ); ?>
			</div><!-- End col-md-8 -->

			<aside class="col-md-4">
				<?php do_action( 'tour_cart_sidebar_before' ); ?>
				<div class="box_style_1">
					<h3 class="inner"><?php echo esc_html__( '- Summary -', 'citytours' ) ?></h3>
					<table class="table table_summary">
					<tbody>
						<?php if ( ! empty( $date ) ) : ?>
						<tr>
							<td><?php echo esc_html__( 'Date', 'citytours' ) ?></td>
							<td class="text-right"><?php echo date( 'j F Y', ct_strtotime( $date ) ); ?></td>
						</tr>
						<?php endif; ?>
						<tr>
							<td><?php echo esc_html__( 'Adults', 'citytours' ) ?></td>
							<td class="text-right"><?php echo esc_html( $adults ) ?></td>
						</tr>
						<tr>
							<td><?php echo esc_html__( 'Children', 'citytours' ) ?></td>
							<td class="text-right"><?php echo esc_html( $kids ) ?></td>
						</tr>
						<?php if ( ! empty( $cart_service ) ) {
							foreach ( $cart_service as $key => $service ) { ?>
								<tr>
									<td><?php echo esc_html( $service['title'] ) ?></td>
									<td class="text-right"><?php echo ct_price( $service['total'] ); ?></td>
								</tr>
						<?php }} ?>
						<tr class="total">
							<td><?php echo esc_html__( 'Total cost', 'citytours' ) ?></td>
							<td class="text-right"><?php $total_price = $cart->get_field( $uid, 'total_price' ); if ( ! empty( $total_price ) ) echo ct_price( $total_price ) ?></td>
						</tr>
						<?php if ( ! empty( $deposit_rate ) && $deposit_rate < 100 ) : ?>
							<tr>
								<td><?php echo sprintf( esc_html__( 'Security Deposit (%d%%)', 'citytours' ), $deposit_rate ) ?></td>
								<td class="text-right"><?php if ( ! empty( $total_price ) ) echo ct_price( $total_price * $deposit_rate / 100 ) ?></td>
							</tr>
						<?php endif; ?>
					</tbody>
					</table>
					<a class="btn_full book-now-btn" href="#"><?php echo esc_html__( 'Book now', 'citytours' ) ?></a>
					<a class="btn_full update-cart-btn" href="#"><?php echo esc_html__( 'Update Cart', 'citytours' ) ?></a>
					<a class="btn_full_outline" href="<?php echo esc_url( get_permalink( $tour_id ) ) ?>"><i class="icon-right"></i> <?php echo esc_html__( 'Modify your search', 'citytours' ) ?></a>
					<input type="hidden" name="action" value="ct_tour_book">
					<input type="hidden" name="tour_id" value="<?php echo esc_attr( $tour_id ) ?>">
					<input type="hidden" name="date" value="<?php echo esc_attr( $date ) ?>">
					<?php wp_nonce_field( 'update_cart' ); ?>
				</div>
				<?php do_action( 'tour_cart_sidebar_after' ); ?>
			</aside><!-- End aside -->
		</div><!--End row -->
	</form>
	<script>
		var ajaxurl = '<?php echo esc_js( admin_url( 'admin-ajax.php' ) ) ?>';
		$ = jQuery.noConflict();
		$('#tour-cart input').change(function(){
			$('.update-cart-btn').css('display', 'inline-block');
			$('.book-now-btn').hide();
		});
		$('.update-cart-btn').click(function(e){
			e.preventDefault();
			$('input[name="action"]').val('ct_tour_update_cart');
			$('#overlay').fadeIn();
			$.ajax({
				url: ajaxurl,
				type: "POST",
				data: $('#tour-cart').serialize(),
				success: function(response){
					if (response.success == 1) {
						location.reload();
					} else {
						alert(response.message);
					}
				}
			});
			return false;
		});
		$('.book-now-btn').click(function(e){
			e.preventDefault();
			document.location.href=$("#tour-cart").attr('action');
		})
	</script>

	<?php else : ?>
		<h5 class="alert alert-warning"><?php echo esc_html( $is_available ); ?></h5>
	<?php endif;
} ?>
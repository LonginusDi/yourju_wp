<?php
get_header();
global $ct_options, $post_list, $current_view;

$order_array = array( 'ASC', 'DESC' );
$order_by_array = array(
		'' => '',
		'price' => 'price',
		'rating' => 'rating'
	);
$order_defaults = array(
		'price' => 'ASC',
		'rating' => 'DESC'
	);

$s = isset($_REQUEST['s']) ? sanitize_text_field( $_REQUEST['s'] ) : '';
$date = isset($_REQUEST['date']) ? sanitize_text_field( $_REQUEST['date'] ) : '';
$adults = isset($_REQUEST['adults']) ? sanitize_text_field( $_REQUEST['adults'] ) : '';
$kids = isset($_REQUEST['kids']) ? sanitize_text_field( $_REQUEST['kids'] ) : '';

$order_by = ( isset( $_REQUEST['order_by'] ) && array_key_exists( $_REQUEST['order_by'], $order_by_array ) ) ? sanitize_text_field( $_REQUEST['order_by'] ) : '';
$order = ( isset( $_REQUEST['order'] ) && in_array( $_REQUEST['order'], $order_array ) ) ? sanitize_text_field( $_REQUEST['order'] ) : 'ASC';
$tour_type = ( isset( $_REQUEST['tour_types'] ) ) ? ( is_array( $_REQUEST['tour_types'] ) ? $_REQUEST['tour_types'] : array( $_REQUEST['tour_types'] ) ):array();
$price_filter = ( isset( $_REQUEST['price_filter'] ) && is_array( $_REQUEST['price_filter'] ) ) ? $_REQUEST['price_filter'] : array();
$rating_filter = ( isset( $_REQUEST['rating_filter'] ) && is_array( $_REQUEST['rating_filter'] ) ) ? $_REQUEST['rating_filter'] : array();
$facility_filter = ( isset( $_REQUEST['facilities'] ) && is_array( $_REQUEST['facilities'] ) ) ? $_REQUEST['facilities'] : array();
$current_view = isset( $_REQUEST['view'] ) ? sanitize_text_field( $_REQUEST['view'] ) : 'list';
$page = ( isset( $_REQUEST['page'] ) && ( is_numeric( $_REQUEST['page'] ) ) && ( $_REQUEST['page'] >= 1 ) ) ? sanitize_text_field( $_REQUEST['page'] ):1;
$per_page = ( isset( $ct_options['tour_posts'] ) && is_numeric($ct_options['tour_posts']) )?$ct_options['tour_posts']:6;
$search_result = ct_tour_get_search_result( array( 's'=>$s, 'date'=>$date, 'adults'=>$adults, 'kids'=>$kids, 'tour_type'=>$tour_type, 'price_filter'=>$price_filter, 'rating_filter'=>$rating_filter, 'facility_filter'=>$facility_filter, 'order_by'=>$order_by_array[$order_by], 'order'=>$order, 'last_no'=>( $page - 1 ) * $per_page, 'per_page'=>$per_page ) );
$post_list = $search_result['ids'];
$count = $search_result['count']; // total_count

$header_img_scr = ct_get_header_image_src('tour');
if ( ! empty( $header_img_scr ) ) {
	$header_img_height = ct_get_header_image_height('tour');
	$header_content = '';
	if ( ! empty( $ct_options['tour_header_content'] ) ) $header_content = $ct_options['tour_header_content'];
	?>

	<section class="parallax-window" data-parallax="scroll" data-image-src="<?php echo esc_url( $header_img_scr ) ?>" data-natural-width="1400" data-natural-height="<?php echo esc_attr( $header_img_height ) ?>">
		<div class="parallax-content-1">
			<?php echo balancetags( $header_content ); ?>
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
		<aside class="col-lg-3 col-md-3">

		<div id="search_results"><?php echo sprintf( esc_html__( '%d Results found', 'citytours' ), $count ) ?></div>
		
		<div id="modify_search">
			<a data-toggle="collapse" href="#collapseModify_search" aria-expanded="false" aria-controls="collapseModify_search" id="modify_col_bt"><i class="icon_set_1_icon-78"></i><?php echo esc_html( 'Modify Search', 'citytours' ) ?> <i class="icon-plus-1 pull-right"></i></a>
			<div class="collapse" id="collapseModify_search">
				<div class="modify_search_wp">
					<form role="search" method="get" id="search-tour-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<input type="hidden" name="post_type" value="tour">
						<div class="form-group">
							<label><?php echo esc_html( 'Search terms', 'citytours' ) ?></label>
							<input type="text" class="form-control" id="search_terms" name="s" placeholder="<?php echo esc_html( 'Type your search terms', 'citytours' ) ?>" value="<?php echo esc_attr( $s ) ?>">
						</div>
						<div class="form-group">
							<label><?php echo esc_html( 'Things to do', 'citytours' ) ?></label>
							<?php
							$all_tour_types = get_terms( 'tour_type', array('hide_empty' => 0) );
							if ( ! empty( $all_tour_types ) ) : ?>
								<select class="form-control" name="tour_types">
									<option value="" selected><?php esc_html_e( 'All tours', 'citytours' ) ?></option>
									<?php foreach ( $all_tour_types as $each_tour_type ) {
										$term_id = $each_tour_type->term_id;
										$icon_class = get_tax_meta( $term_id, 'ct_tax_icon_class' );
										$selected = in_array( $term_id, $tour_type ) ? 'selected' : '';
									?>
									<option value="<?php echo esc_attr( $term_id ) ?>" <?php echo ( $selected ) ?>><?php echo esc_html( $each_tour_type->name ) ?></option>
									<?php } ?>
								</select>
							<?php endif; ?>
						</div>
						<div class="form-group">
							<label><i class="icon-calendar-7"></i> <?php esc_html_e( 'Date', 'citytours' ) ?></label>
							<input class="date-pick form-control" data-date-format="<?php echo ct_get_date_format('html'); ?>" type="text" name="date" value="<?php echo esc_attr( $date ) ?>">
						</div>
						<div class="form-group">
							<label><?php esc_html_e( 'Adults', 'citytours' ) ?></label>
							<div class="numbers-row">
								<input type="text" value="1" class="qty2 form-control" name="adults" value="<?php echo esc_attr( $adults ) ?>">
							</div>
						</div>
						<div class="form-group add_bottom_30">
							<label><?php esc_html_e( 'Children', 'citytours' ) ?></label>
							<div class="numbers-row">
								<input type="text" value="0" class="qty2 form-control" name="kids" value="<?php echo esc_attr( $kids ) ?>">
							</div>
						</div>
						<button class="btn_1 green"><?php esc_html_e( 'Search again', 'citytours' ) ?></button>
					</form>
				</div>
			</div><!--End collapse -->
		</div>

		<div class="box_style_cat">
			<ul id="cat_nav">
				<?php
					$selected = empty( $tour_type )?' class="active"':'';
					$counts_by_tour_type = ct_tour_get_search_result_count( array( 'by' => 'tour_type', 's'=>$s, 'price_filter'=>$price_filter, 'rating_filter'=>$rating_filter, 'facility_filter'=>$facility_filter ) );
					echo '<li class="all-types"><a href="' . esc_url( remove_query_arg( array( 'tour_types', 'page' ) ) ) . '"' . $selected . '><i class="icon_set_1_icon-51"></i>' . esc_html__( 'All tours', 'citytours' ) . '<small>(' . esc_html( array_sum( $counts_by_tour_type ) ) . ')</small></a></li>';
					$all_tour_types = get_terms( 'tour_type', array('hide_empty' => 0) );
					if ( ! empty( $all_tour_types ) ) :
					foreach ( $all_tour_types as $each_tour_type ) {
						$term_id = $each_tour_type->term_id;
						$selected = ( ( is_array( $tour_type ) && in_array( $term_id, $tour_type ) ) )?' class="active"':'';
						$icon_class = get_tax_meta( $term_id, 'ct_tax_icon_class' );
						echo '<li data-term-id="' . esc_attr( $term_id ) . '"><a href="' . esc_url( add_query_arg( array( 'tour_types'=>$term_id, 'page'=>0 ) ) ) . '"' . $selected . '>';
						if ( ! empty( $icon_class ) ) echo '<i class="' . esc_attr( $icon_class ) . '"></i>';
						echo esc_html( $each_tour_type->name ) . '<small>(' . esc_html( ( empty( $counts_by_tour_type[ $term_id ] ) ? 0 : $counts_by_tour_type[ $term_id ] ) ) . ')</small></a></li>';
					}
					endif;
				?>
			</ul>
		</div>

		<div id="filters_col">
			<a data-toggle="collapse" href="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters" id="filters_col_bt"><i class="icon_set_1_icon-65"></i><?php echo esc_html__( 'Filters', 'citytours' ) ?> <i class="icon-plus-1 pull-right"></i></a>
			<div class="collapse" id="collapseFilters">

				<?php 
				if ( ! empty( $ct_options['tour_price_filter'] ) ) :?>
					<?php $price_steps = empty( $ct_options['tour_price_filter_steps'] ) ? '50,80,100' : $ct_options['tour_price_filter_steps'];
					$step_arr = explode( ',', $price_steps );
					array_unshift($step_arr, 0);
					 ?>
					<div class="filter_type">
						<h6><?php echo esc_html__( 'Price', 'citytours' ) ?></h6>
						<ul class="list-filter price-filter" data-base-url="<?php echo esc_url( remove_query_arg( array( 'price_filter', 'page' ) ) ); ?>" data-arg="price_filter">
							<?php for( $i = 0; $i < count( $step_arr ); $i++ ) {
								$checked = ( in_array( $i, $price_filter ) ) ? ' checked="checked"' : '';
								if ( $i < count( $step_arr ) - 1 ) { ?>
									<li><label><input type="checkbox" name="price_filter[]" value="<?php echo esc_attr( $i ) ?>"<?php echo ( $checked ) ?>><?php echo ct_price( $step_arr[ $i ] ) ?> - <?php echo ct_price( $step_arr[ $i + 1 ] ) ?></label></li>
								<?php } else { ?>
									<li><label><input type="checkbox" name="price_filter[]" value="<?php echo esc_attr( $i ) ?>"<?php echo ( $checked ) ?>><?php echo ct_price( $step_arr[ $i ] ) ?> +</label></li>
								<?php } ?>
							<?php } ?>
						</ul>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $ct_options['tour_rating_filter'] ) ) :?>
				<div class="filter_type">
					<h6><?php echo esc_html__( 'Rating', 'citytours' ) ?></h6>
					<ul class="list-filter rating-filter" data-base-url="<?php echo esc_url( remove_query_arg( array( 'rating_filter', 'page' ) ) ); ?>" data-arg="rating_filter">
						<?php for ( $i = 5; $i > 0; $i-- ) {
							$checked = ( in_array( $i, $rating_filter ) ) ? ' checked="checked"' : ''; ?>
							<li><label><input type="checkbox" name="rating_filter[]" value="<?php echo esc_attr( $i ) ?>"<?php echo ( $checked )?>><span class="rating">
								<?php ct_rating_smiles( $i ); ?>
						</span></label></li>

						<?php } ?>
					</ul>
				</div>
				<?php endif; ?>

				<?php if ( ! empty( $ct_options['tour_facility_filter'] ) ) :?>
				<div class="filter_type">
					<h6><?php echo esc_html__( 'Facility', 'citytours' ) ?></h6>
					<ul class="list-filter facility-filter" data-base-url="<?php echo esc_url( remove_query_arg( array( 'facilities', 'page' ) ) ); ?>" data-arg="facilities">
						<?php 
						$all_facilities = get_terms( 'tour_facility', array('hide_empty' => 0) );
						if ( ! empty( $all_facilities ) ) :
						foreach ( $all_facilities as $facility ) {
							$term_id = $facility->term_id;
							$checked = ( in_array( $term_id, $facility_filter ) ) ? ' checked="checked"' : '';
							echo '<li><label><input type="checkbox" name="facility_filter[]" value="' . esc_attr( $term_id ) . '"' . $checked . '>' . esc_html( $facility->name ) . '</label></li>';
						}
						endif;?>
					</ul>
				</div>
				<?php endif; ?>

			</div><!--End collapse -->
		</div><!--End filters col-->
		</aside><!--End aside -->

		<div class="col-lg-9 col-md-8">
			<div id="tools">
				<div class="row">
					<div class="col-md-3 col-sm-3 col-xs-6">
						<div class="styled-select-filters">
							<select name="sort_price" id="sort_price" data-base-url="<?php echo esc_url( remove_query_arg( array( 'order', 'order_by', 'page' ) ) ); ?>">
								<option value="" <?php if ( $order_by != 'price' ) echo 'selected' ?>><?php echo esc_html__( 'Sort by price', 'citytours' ) ?></option>
								<option value="lower" <?php if ( $order_by == 'price' && $order == 'ASC' ) echo 'selected' ?>><?php echo esc_html__( 'Lowest price', 'citytours' ) ?></option>
								<option value="higher" <?php if ( $order_by == 'price' && $order == 'DESC' ) echo 'selected' ?>><?php echo esc_html__( 'Highest price', 'citytours' ) ?></option>
							</select>
						</div>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-6">
						<div class="styled-select-filters">
							<select name="sort_rating" id="sort_rating" data-base-url="<?php echo esc_url( remove_query_arg( array( 'order', 'order_by', 'page' ) ) ); ?>">
								<option value="" <?php if ( $order_by != 'rating' ) echo 'selected' ?>><?php echo esc_html__( 'Sort by rating', 'citytours' ) ?></option>
								<option value="lower" <?php if ( $order_by == 'rating' && $order == 'ASC' ) echo 'selected' ?>><?php echo esc_html__( 'Lowest rating', 'citytours' ) ?></option>
								<option value="higher" <?php if ( $order_by == 'rating' && $order == 'DESC' ) echo 'selected' ?>><?php echo esc_html__( 'Highest rating', 'citytours' ) ?></option>
							</select>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 hidden-xs text-right">
						<a href="<?php echo esc_url( add_query_arg( array( 'view' => 'grid' ) ) ) ?>" class="bt_filters" title="<?php esc_html_e(  'Grid View', 'citytours' ) ?>"><i class="icon-th"></i></a>
						<a href="<?php echo esc_url( add_query_arg( array( 'view' => 'list' ) ) ) ?>" class="bt_filters" title="<?php esc_html_e(  'List View', 'citytours' ) ?>"><i class="icon-list"></i></a>
					</div>
				</div>
			</div><!--End tools -->

			<div class="tour-list <?php if ( $current_view == 'grid' ) echo 'row' ?>">
				<?php ct_get_template( 'tour-list.php', '/templates/tour/'); ?>
			</div><!-- End row -->

			<hr>

				<div class="text-center">
					<?php
						unset( $_GET['page'] );
						$pagenum_link = strtok( $_SERVER["REQUEST_URI"], '?' ) . '%_%';
						$total = ceil( $count / $per_page );
						$args = array(
							'base' => $pagenum_link, // http://example.com/all_posts.php%_% : %_% is replaced by format (below)
							'total' => $total,
							'format' => '?page=%#%',
							'current' => $page,
							'show_all' => false,
							'prev_next' => true,
							'prev_text' => esc_html__('Previous', 'citytours'),
							'next_text' => esc_html__('Next', 'citytours'),
							'end_size' => 1,
							'mid_size' => 2,
							'type' => 'list',
							'add_args' => $_GET,
						);
						echo paginate_links( $args );
					?>
				</div><!-- end pagination-->
				
		</div><!-- End col lg 9 -->
	</div><!-- End row -->
</div><!-- End container -->
<script>
jQuery(document).ready(function(){
	jQuery('input').iCheck({
		checkboxClass: 'icheckbox_square-grey',
		radioClass: 'iradio_square-grey'
	});
	jQuery('#cat_nav').mobileMenu();
	if ( jQuery('input.date-pick').length ) {
		jQuery('input.date-pick').datepicker({
			startDate: "today"
		});
	}
});
 </script>
<?php get_footer(); ?>
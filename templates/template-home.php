<?php
 /*
 Template Name: Template Home
 */
get_header();

if ( have_posts() ) {
	while ( have_posts() ) : the_post();
		$post_id = get_the_ID();
		$content_class = 'post-content';
		$header_img_scr = ct_get_header_image_src( $post_id );
		$active_class = 'active'; ?>

		<section id="search_container">
			<div id="search">
				<ul class="nav nav-tabs">
					<?php if ( ct_is_tour_enabled() ) : ?>
					<li class="<?php echo esc_attr( $active_class ) ?>"><a href="#tours" data-toggle="tab"><?php esc_html_e( 'Tours', 'citytours' ) ?></a></li>
					<?php $active_class=''; endif; ?>
					<?php if ( ct_is_hotel_enabled() ) : ?>
					<li><a href="#hotels" data-toggle="tab"><?php esc_html_e( 'Hotels', 'citytours' ) ?></a></li>
					<?php $active_class=''; endif; ?>
				</ul>

				<?php $active_class = 'active'; ?>
				<div class="tab-content">
					<?php if ( ct_is_tour_enabled() ) : ?>
					<div class="tab-pane <?php echo esc_attr( $active_class ) ?>" id="tours">
					<h3><?php esc_html_e( 'Search Tours', 'citytours' ) ?></h3>
						<form role="search" method="get" id="search-tour-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<input type="hidden" name="post_type" value="tour">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label><?php esc_html_e( 'Search terms', 'citytours' ) ?></label>
									<input type="text" class="form-control" name="s" placeholder="<?php esc_html_e( 'Type your search terms', 'citytours' ) ?>">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label><?php esc_html_e( 'Things to do', 'citytours' ) ?></label>
									<?php
									$all_tour_types = get_terms( 'tour_type', array('hide_empty' => 0) );
									if ( ! empty( $all_tour_types ) ) : ?>
										<select class="form-control" name="tour_types">
											<option value="" selected><?php esc_html_e( 'All tours', 'citytours' ) ?></option>
											<?php foreach ( $all_tour_types as $each_tour_type ) {
												$term_id = $each_tour_type->term_id;
												$icon_class = get_tax_meta( $term_id, 'ct_tax_icon_class' );
											?>
											<option value="<?php echo esc_attr( $term_id ) ?>"><?php echo esc_html( $each_tour_type->name ) ?></option>
											<?php } ?>
										</select>
									<?php endif; ?>
								</div>
							</div>
						</div><!-- End row -->
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label><i class="icon-calendar-7"></i> <?php esc_html_e( 'Date', 'citytours' ) ?></label>
									<input class="date-pick form-control" data-date-format="<?php echo ct_get_date_format('html'); ?>" type="text" name="date">
								</div>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-6 col-md-offset-3">
								<div class="form-group">
									<label><?php esc_html_e( 'Adults', 'citytours' ) ?></label>
									<div class="numbers-row">
										<input type="text" value="1" class="qty2 form-control" name="adults">
									</div>
								</div>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-6">
								<div class="form-group">
									<label><?php esc_html_e( 'Children', 'citytours' ) ?></label>
									<div class="numbers-row">
										<input type="text" value="0" class="qty2 form-control" name="kids">
									</div>
								</div>
							</div>
							
						</div><!-- End row -->
						<hr>
						<button class="btn_1 green"><i class="icon-search"></i><?php esc_html_e( 'Search now', 'citytours' ) ?></button>
						</form>
					</div><!-- End rab -->
					<?php $active_class=''; endif; ?>
					<?php if ( ct_is_hotel_enabled() ) : ?>
					<div class="tab-pane <?php echo esc_attr( $active_class ) ?>" id="hotels">
					<h3><?php esc_html_e( 'Search Hotels', 'citytours' ) ?></h3>
						<form role="search" method="get" id="search-hotel-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<input type="hidden" name="post_type" value="hotel">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label><i class="icon-calendar-7"></i> <?php esc_html_e( 'Check in', 'citytours' ) ?></label>
									<input class="date-pick form-control" data-date-format="<?php echo ct_get_date_format('html'); ?>" type="text" name="date_from">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label><i class="icon-calendar-7"></i> <?php esc_html_e( 'Check out', 'citytours' ) ?></label>
									<input class="date-pick form-control" data-date-format="<?php echo ct_get_date_format('html'); ?>" type="text" name="date_to">
								</div>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-5">
								<div class="form-group">
									<label><?php esc_html_e( 'Adults', 'citytours' ) ?></label>
									<div class="numbers-row">
										<input type="text" value="1" class="qty2 form-control" name="adults">
									</div>
								</div>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-5">
								<div class="form-group">
									<label><?php esc_html_e( 'Children', 'citytours' ) ?></label>
									<div class="numbers-row">
										<input type="text" value="0" class="qty2 form-control" name="kids">
									</div>
								</div>
							</div>
							<div class="col-md-2 col-sm-3 col-xs-12">
								<div class="form-group">
									<label><?php esc_html_e( 'Rooms', 'citytours' ) ?></label>
									<div class="numbers-row">
										<input type="text" value="1" id="rooms" class="qty2 form-control" name="rooms">
									</div>
								</div>
							</div>
						</div><!-- End row -->
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label><?php esc_html_e( 'Hotel name', 'citytours' ) ?></label>
									<input type="text" class="form-control" id="hotel_name" name="s" placeholder="<?php esc_attr_e( 'Optionally type hotel name', 'citytours' ) ?>">
								</div>
							</div>

							<?php 
							$all_districts = get_terms( 'district', array('hide_empty' => 0) );
							if ( ! empty( $all_districts ) ) : ?>
								<div class="col-md-6">
									<div class="form-group">
									<label><?php esc_html_e( 'Preferred city area', 'citytours' ) ?></label>
										<select class="form-control" name="districts">
											<option value="" selected><?php esc_html_e( 'All', 'citytours' ) ?></option>
											<?php foreach ( $all_districts as $district ) {
												$term_id = $district->term_id; ?>
												<option value="<?php echo esc_attr( $term_id ) ?>"><?php echo esc_html( $district->name ) ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							<?php endif;?>
						</div> <!-- End row -->
						<hr>
						<button class="btn_1 green"><i class="icon-search"></i><?php esc_html_e( 'Search now', 'citytours' ); ?></button>
						</form>
					</div>
					<?php $active_class=''; endif; ?>
				</div>
			</div>
		</section><!-- End hero -->

		<div class="<?php echo esc_attr( $content_class ); ?>">
			<div class="post nopadding">
				<?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'full', array('class' => 'img-responsive') ); } ?>
				<?php the_content(); ?>
				<?php wp_link_pages('before=<div class="page-links">&after=</div>'); ?>
				<?php if ( comments_open() || get_comments_number() ) {
					comments_template();
				} ?>
			</div><!-- end post -->
		</div>

<script>
$ = jQuery.noConflict();
$(document).ready(function(){
	$('input.date-pick').datepicker({
		startDate: "today"
	});
	$('input[name="date_from"]').datepicker( 'setDate', 'today' );
	$('input[name="date_to"]').datepicker( 'setDate', '+1d' );
	});
</script>

<?php endwhile;
}
get_footer();
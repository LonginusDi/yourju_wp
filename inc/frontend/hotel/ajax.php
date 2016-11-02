<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
 * Calculate the price of selected hotel room and return price array data
 */
if ( ! function_exists( 'ct_hotel_update_cart' ) ) {
	function ct_hotel_update_cart() {
		if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'update_cart' ) ) {
			print esc_html__( 'Sorry, your nonce did not verify.', 'citytours' );
			exit;
		}
		// validation

		// init variables
		$hotel_id = $_POST['hotel_id'];
		$date_from = $_POST['date_from'];
		$date_to = $_POST['date_to'];
		$room_ids = $_POST['room_type_id'];
		$uid = $hotel_id . $date_from . $date_to;
		$cart_data = array();
		$total_adults = 0;
		$total_kids = 0;
		$total_price = 0;

		// function
		foreach ( $room_ids as $room_id ) :
			if ( ! empty( $_POST['rooms'][$room_id] ) ) :
				$rooms = ( ! empty( $_POST['rooms'][$room_id] ) ) ? $_POST['rooms'][$room_id] : 0;
				$adults = ( ! empty( $_POST['adults'][$room_id] ) ) ? $_POST['adults'][$room_id] : 0;
				$kids = ( ! empty( $_POST['kids'][$room_id] ) ) ? $_POST['kids'][$room_id] : 0;
				$price_data = ct_hotel_calc_room_price( $hotel_id, $room_id, $date_from, $date_to, $rooms, $adults, $kids );
				if ( $price_data && is_array( $price_data ) ) {
					$cart_room_data = array();
					$cart_room_data['rooms'] = $rooms;
					$cart_room_data['adults'] = $adults;
					$cart_room_data['kids'] = $kids;
					$cart_room_data['total'] = $price_data['total_price'];

					$cart_data['room'][$room_id] = $cart_room_data;
					$total_adults += $adults;
					$total_kids += $kids;
					$total_price += $price_data['total_price'];
				} elseif ( $price_data ) {
					wp_send_json( array( 'success'=>0, 'message'=>$price_data ) );
				} else {
					wp_send_json( array( 'success'=>0, 'message'=>__( 'Some validation error is occurred while calculate price.', 'citytours' ) ) );
				}
			endif;
		endforeach;

		if ( ! empty( $_POST['add_service'] ) ) {
			global $wpdb;
			foreach ( $_POST['add_service'] as $key => $value ) {
				$services = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . CT_ADD_SERVICES_TABLE . ' WHERE id=%d AND post_id=%d', $key, $hotel_id ) );
				if ( ! empty( $services ) ) {
					$cart_add_service_data = array();
					$cart_add_service_data['title'] = $services->title;
					$cart_add_service_data['price'] = $services->price;
					$qty = 1;
					if ( ! empty( $services->per_person ) ) {
						if ( empty( $services->inc_child ) ) {
							$qty = $total_adults;
						} else {
							$qty = $total_adults + $total_kids;
						}
					}
					$cart_add_service_data['qty'] = $qty;
					$cart_add_service_data['total'] = $cart_add_service_data['price'] * $qty;

					$cart_data['add_service'][$key] = $cart_add_service_data;
					$total_price += $cart_add_service_data['total'];
				}
			}
		}

		$cart_data['total_price'] = $total_price;
		$cart_data['total_adults'] = $total_adults;
		$cart_data['total_kids'] = $total_kids;
		$cart_data['hotel_id'] = $hotel_id;
		$cart_data['date_from'] = $date_from;
		$cart_data['date_to'] = $date_to;
		CT_Hotel_Cart::set( $uid, $cart_data );
		wp_send_json( array( 'success'=>1, 'message'=>'success' ) );
	}
}

/*
 * Handle submit booking ajax request
 */
if ( ! function_exists( 'ct_hotel_submit_booking' ) ) {
	function ct_hotel_submit_booking() {
		global $wpdb, $ct_options;

		// validation
		$result_json = array( 'success' => 0, 'result' => '' );
		if ( ! isset( $_POST['uid'] ) || ! CT_Hotel_Cart::get( $_POST['uid'] ) ) {
			$result_json['success'] = 0;
			$result_json['result'] = esc_html__( 'Sorry, some error occurred on input data validation.', 'citytours' );
			wp_send_json( $result_json );
		}
		if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'checkout' ) ) {
			$result_json['success'] = 0;
			$result_json['result'] = esc_html__( 'Sorry, your nonce did not verify.', 'citytours' );
			wp_send_json( $result_json );
		}

		// init variables
		$uid = $_POST['uid'];
		$post_fields = array( 'first_name', 'last_name', 'email', 'phone', 'country', 'address1', 'address2', 'city', 'state', 'zip');
		$order_info = ct_order_default_order_data( 'new' );
		foreach ( $post_fields as $post_field ) {
			if ( ! empty( $_POST[ $post_field ] ) ) {
				$order_info[ $post_field ] = sanitize_text_field( $_POST[ $post_field ] );
			}
		}

		$latest_order_id = $wpdb->get_var( 'SELECT id FROM ' . CT_ORDER_TABLE . ' ORDER BY id DESC LIMIT 1' );
		$booking_no = mt_rand( 1000, 9999 );
		$booking_no .= $latest_order_id;
		$pin_code = mt_rand( 1000, 9999 );

		$cart_data = CT_Hotel_Cart::get( $uid );
		$order_info['total_price'] = $cart_data['total_price'];
		$order_info['total_adults'] = $cart_data['total_adults'];
		$order_info['total_kids'] = $cart_data['total_kids'];
		$order_info['status'] = 'new'; // new
		$order_info['deposit_paid'] = 1;
		$order_info['mail_sent'] = 0;
		$order_info['post_id'] = $cart_data['hotel_id'];
		$order_info['date_from'] = date( 'Y-m-d', ct_strtotime( $cart_data['date_from'] ) );
		$order_info['date_to'] = date( 'Y-m-d', ct_strtotime( $cart_data['date_to'] ) );
		$order_info['booking_no'] = $booking_no;
		$order_info['pin_code'] = $pin_code;
		$order_info['post_type'] = 'hotel';
		// calculate deposit payment
		$deposit_rate = get_post_meta( $cart_data['hotel_id'], '_hotel_security_deposit', true );
		// if woocommerce enabled change currency_code and exchange rate as default
		if ( ! empty( $deposit_rate ) && ct_is_woo_enabled() ) {
			$order_info['currency_code'] = ct_get_def_currency();
			$order_info['exchange_rate'] = 1;
		} else {
			if ( ! isset( $_SESSION['exchange_rate'] ) ) ct_init_currency();
			$order_info['exchange_rate'] = $_SESSION['exchange_rate'];
			$order_info['currency_code'] = ct_get_user_currency();
		}

		// if payment enabled set deposit price field
		if ( ! empty( $deposit_rate ) && ct_is_payment_enabled() ) {
			$order_info['deposit_price'] = $deposit_rate / 100 * $order_info['total_price'] * $order_info['exchange_rate'];
			$order_info['deposit_paid'] = 0; // set unpaid if payment enabled
			$order_info['status'] = 'pending';
		}
		$order_info['created'] = date( 'Y-m-d H:i:s' );
		if ( $wpdb->insert( CT_ORDER_TABLE, $order_info ) ) {
			CT_Hotel_Cart::_unset( $uid );
			$order_id = $wpdb->insert_id;
			if ( ! empty( $cart_data['room'] ) ) {
				foreach ( $cart_data['room'] as $room_id => $room_data ) {
					$room_booking_info = array();
					$room_booking_info['order_id'] = $order_id;
					$room_booking_info['hotel_id'] = $cart_data['hotel_id'];
					$room_booking_info['room_type_id'] = $room_id;
					$room_booking_info['rooms'] = $room_data['rooms'];
					$room_booking_info['adults'] = $room_data['adults'];
					$room_booking_info['kids'] = $room_data['kids'];
					$room_booking_info['total_price'] = $room_data['total'];
					$wpdb->insert( CT_HOTEL_BOOKINGS_TABLE, $room_booking_info );
				}
			}
			if ( ! empty( $cart_data['add_service'] ) ) {
				foreach ( $cart_data['add_service'] as $service_id => $service_data ) {
					$service_booking_info = array();
					$service_booking_info['order_id'] = $order_id;
					$service_booking_info['add_service_id'] = $service_id;
					$service_booking_info['qty'] = $service_data['qty'];
					$service_booking_info['total_price'] = $service_data['total'];
					$wpdb->insert( CT_ADD_SERVICES_BOOKINGS_TABLE, $service_booking_info );
				}
			}
			$result_json['success'] = 1;
			$result_json['result']['order_id'] = $order_id;
			$result_json['result']['booking_no'] = $booking_no;
			$result_json['result']['pin_code'] = $pin_code;
		} else {
			$result_json['success'] = 0;
			$result_json['result'] = esc_html__( 'Sorry, An error occurred while add your order.', 'citytours' );
		}
		wp_send_json( $result_json );
	}
}

/*
 * update room list based on hotel_id
 */
if ( ! function_exists( 'ct_ajax_hotel_get_hotel_room_list' ) ) {
	function ct_ajax_hotel_get_hotel_room_list() {
		$hotel_id = ( ! empty ( $_POST['hotel_id'] ) ) ? $_POST['hotel_id'] : 0;
		ct_hotel_get_room_list( $hotel_id );
	}
}

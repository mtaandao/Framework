<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'MN_List_Table' ) ) {
	require_once( ABSPATH . 'admin/includes/class-mn-list-table.php' );
}

/**
 * WC_Report_Customer_List.
 *
 * @author      WooThemes
 * @category    Admin
 * @package     WooCommerce/Admin/Reports
 * @version     2.1.0
 */
class WC_Report_Customer_List extends MN_List_Table {

	/**
	 * Constructor.
	 */
	public function __construct() {

		parent::__construct( array(
			'singular'  => __( 'Customer', 'woocommerce' ),
			'plural'    => __( 'Customers', 'woocommerce' ),
			'ajax'      => false
		) );
	}

	/**
	 * No items found text.
	 */
	public function no_items() {
		_e( 'No customers found.', 'woocommerce' );
	}

	/**
	 * Output the report.
	 */
	public function output_report() {
		$this->prepare_items();

		echo '<div id="poststuff" class="woocommerce-reports-wide">';

		if ( ! empty( $_GET['link_orders'] ) && mn_verify_nonce( $_REQUEST['_mnnonce'], 'link_orders' ) ) {
			$linked = wc_update_new_customer_past_orders( absint( $_GET['link_orders'] ) );

			echo '<div class="updated"><p>' . sprintf( _n( '%s previous order linked', '%s previous orders linked', $linked, 'woocommerce' ), $linked ) . '</p></div>';
		}

		if ( ! empty( $_GET['refresh'] ) && mn_verify_nonce( $_REQUEST['_mnnonce'], 'refresh' ) ) {
			$user_id = absint( $_GET['refresh'] );
			$user    = get_user_by( 'id', $user_id );

			delete_user_meta( $user_id, '_money_spent' );
			delete_user_meta( $user_id, '_order_count' );

			echo '<div class="updated"><p>' . sprintf( __( 'Refreshed stats for %s', 'woocommerce' ), $user->display_name ) . '</p></div>';
		}

		echo '<form method="post" id="woocommerce_customers">';

		$this->search_box( __( 'Search customers', 'woocommerce' ), 'customer_search' );
		$this->display();

		echo '</form>';
		echo '</div>';
	}

	/**
	 * Get column value.
	 *
	 * @param MN_User $user
	 * @param string $column_name
	 * @return string
	 */
	public function column_default( $user, $column_name ) {
		global $mndb;

		switch ( $column_name ) {

			case 'customer_name' :
				if ( $user->last_name && $user->first_name ) {
					return $user->last_name . ', ' . $user->first_name;
				} else {
					return '-';
				}

			case 'username' :
				return $user->user_login;

			case 'location' :

				$state_code   = get_user_meta( $user->ID, 'billing_state', true );
				$country_code = get_user_meta( $user->ID, 'billing_country', true );

				$state   = isset( WC()->countries->states[ $country_code ][ $state_code ] ) ? WC()->countries->states[ $country_code ][ $state_code ] : $state_code;
				$country = isset( WC()->countries->countries[ $country_code ] ) ? WC()->countries->countries[ $country_code ] : $country_code;

				$value = '';

				if ( $state ) {
					$value .= $state . ', ';
				}

				$value .= $country;

				if ( $value ) {
					return $value;
				} else {
					return '-';
				}

			case 'email' :
				return '<a href="mailto:' . $user->user_email . '">' . $user->user_email . '</a>';

			case 'spent' :
				return wc_price( wc_get_customer_total_spent( $user->ID ) );

			case 'orders' :
				return wc_get_customer_order_count( $user->ID );

			case 'last_order' :

				$orders = wc_get_orders( array(
					'limit'    => 1,
					'status'   => array( 'wc-completed', 'wc-processing' ),
					'customer' => $user->ID
				) );

				if ( ! empty( $orders ) ) {
					$order = $orders[0];
					return '<a href="' . admin_url( 'post.php?post=' . $order->id . '&action=edit' ) . '">' . _x( '#', 'hash before order number', 'woocommerce' ) . $order->get_order_number() . '</a> &ndash; ' . date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) );
				} else {
					return '-';
				}

			break;

			case 'user_actions' :
				ob_start();
				?><p>
					<?php
						do_action( 'woocommerce_admin_user_actions_start', $user );

						$actions = array();

						$actions['refresh'] = array(
							'url'       => mn_nonce_url( add_query_arg( 'refresh', $user->ID ), 'refresh' ),
							'name'      => __( 'Refresh stats', 'woocommerce' ),
							'action'    => "refresh"
						);

						$actions['edit'] = array(
							'url'       => admin_url( 'user-edit.php?user_id=' . $user->ID ),
							'name'      => __( 'Edit', 'woocommerce' ),
							'action'    => "edit"
						);

						$actions['view'] = array(
							'url'       => admin_url( 'edit.php?post_type=shop_order&_customer_user=' . $user->ID ),
							'name'      => __( 'View orders', 'woocommerce' ),
							'action'    => "view"
						);

						$orders = wc_get_orders( array(
							'limit'          => 1,
							'status'         => array( 'wc-completed', 'wc-processing' ),
							'customer'       => array( array( 0, $user->user_email ) ),
						) );

						if ( $orders ) {
							$actions['link'] = array(
								'url'       => mn_nonce_url( add_query_arg( 'link_orders', $user->ID ), 'link_orders' ),
								'name'      => __( 'Link previous orders', 'woocommerce' ),
								'action'    => "link"
							);
						}

						$actions = apply_filters( 'woocommerce_admin_user_actions', $actions, $user );

						foreach ( $actions as $action ) {
							printf( '<a class="button tips %s" href="%s" data-tip="%s">%s</a>', esc_attr( $action['action'] ), esc_url( $action['url'] ), esc_attr( $action['name'] ), esc_attr( $action['name'] ) );
						}

						do_action( 'woocommerce_admin_user_actions_end', $user );
					?>
				</p><?php
				$user_actions = ob_get_contents();
				ob_end_clean();

				return $user_actions;
		}

		return '';
	}

	/**
	 * Get columns.
	 *
	 * @return array
	 */
	public function get_columns() {
		$columns = array(
			'customer_name'   => __( 'Name (Last, First)', 'woocommerce' ),
			'username'        => __( 'Username', 'woocommerce' ),
			'email'           => __( 'Email', 'woocommerce' ),
			'location'        => __( 'Location', 'woocommerce' ),
			'orders'          => __( 'Orders', 'woocommerce' ),
			'spent'           => __( 'Money Spent', 'woocommerce' ),
			'last_order'      => __( 'Last order', 'woocommerce' ),
			'user_actions'    => __( 'Actions', 'woocommerce' )
		);

		return $columns;
	}

	/**
	 * Order users by name.
	 *
	 * @param MN_User_Query $query
	 */
	public function order_by_last_name( $query ) {
		global $mndb;

		$s = ! empty( $_REQUEST['s'] ) ? stripslashes( $_REQUEST['s'] ) : '';

		$query->query_from    .= " LEFT JOIN {$mndb->usermeta} as meta2 ON ({$mndb->users}.ID = meta2.user_id) ";
		$query->query_where   .= " AND meta2.meta_key = 'last_name' ";
		$query->query_orderby  = " ORDER BY meta2.meta_value, user_login ASC ";

		if ( $s ) {
			$query->query_from    .= " LEFT JOIN {$mndb->usermeta} as meta3 ON ({$mndb->users}.ID = meta3.user_id)";
			$query->query_where   .= " AND ( user_login LIKE '%" . esc_sql( str_replace( '*', '', $s ) ) . "%' OR user_nicename LIKE '%" . esc_sql( str_replace( '*', '', $s ) ) . "%' OR meta3.meta_value LIKE '%" . esc_sql( str_replace( '*', '', $s ) ) . "%' ) ";
			$query->query_orderby  = " GROUP BY ID " . $query->query_orderby;
		}

		return $query;
	}

	/**
	 * Prepare customer list items.
	 */
	public function prepare_items() {
		global $mndb;

		$current_page = absint( $this->get_pagenum() );
		$per_page     = 20;

		/**
		 * Init column headers.
		 */
		$this->_column_headers = array( $this->get_columns(), array(), $this->get_sortable_columns() );

		add_action( 'pre_user_query', array( $this, 'order_by_last_name' ) );

		/**
		 * Get users.
		 */
		$admin_users = new MN_User_Query(
			array(
				'role'   => 'administrator1',
				'fields' => 'ID'
			)
		);

		$manager_users = new MN_User_Query(
			array(
				'role'   => 'shop_manager',
				'fields' => 'ID'
			)
		);

		$query = new MN_User_Query( array(
			'exclude' => array_merge( $admin_users->get_results(), $manager_users->get_results() ),
			'number'  => $per_page,
			'offset'  => ( $current_page - 1 ) * $per_page
		) );

		$this->items = $query->get_results();

		remove_action( 'pre_user_query', array( $this, 'order_by_last_name' ) );

		/**
		 * Pagination.
		 */
		$this->set_pagination_args( array(
			'total_items' => $query->total_users,
			'per_page'    => $per_page,
			'total_pages' => ceil( $query->total_users / $per_page )
		) );
	}
}

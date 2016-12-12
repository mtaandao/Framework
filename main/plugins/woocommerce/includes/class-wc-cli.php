<?php

/**
 * Manage WooCommerce from CLI.
 *
 * @class    WC_CLI
 * @version  2.5.0
 * @package  WooCommerce/CLI
 * @category CLI
 * @author   WooThemes
 */
class WC_CLI extends MN_CLI_Command {
}

MN_CLI::add_command( 'wc',                  'WC_CLI' );
MN_CLI::add_command( 'wc coupon',           'WC_CLI_Coupon' );
MN_CLI::add_command( 'wc customer',         'WC_CLI_Customer' );
MN_CLI::add_command( 'wc order',            'WC_CLI_Order' );
MN_CLI::add_command( 'wc product',          'WC_CLI_Product' );
MN_CLI::add_command( 'wc product category', 'WC_CLI_Product_Category' );
MN_CLI::add_command( 'wc report',           'WC_CLI_Report' );
MN_CLI::add_command( 'wc tax',              'WC_CLI_Tax' );
MN_CLI::add_command( 'wc tool',             'WC_CLI_Tool' );

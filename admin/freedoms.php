<?php
/**
 * Your Rights administration panel.
 *
 * @package Mtaandao
 * @subpackage Administration
 */

/** Mtaandao Administration Bootstrap */
require_once( dirname( __FILE__ ) . '/admin.php' );

$title = __( 'Freedoms' );

list( $display_version ) = explode( '-', $mn_version );

include( ABSPATH . 'admin/admin-header.php' );
?>
<div class="wrap about-wrap">

<h1><?php printf( __( 'Welcome to Mtaandao %s' ), $display_version ); ?></h1>

<p class="about-text"><?php printf( __( 'Thank you for updating to the latest version. Mtaandao %s changes a lot behind the scenes to make your Mtaandao experience even better!' ), $display_version ); ?></p>

<div class="mn-badge"><?php printf( __( 'Version %s' ), $display_version ); ?></div>

<h2 class="nav-tab-wrapper mn-clearfix">
	<a href="about.php" class="nav-tab"><?php _e( 'What&#8217;s New' ); ?></a>
	<a href="credits.php" class="nav-tab"><?php _e( 'Credits' ); ?></a>
	<a href="freedoms.php" class="nav-tab nav-tab-active"><?php _e( 'Freedoms' ); ?></a>
</h2>

<p class="about-description"><?php printf( __( 'Mtaandao is Free and open source software, built by a distributed community of mostly volunteer developers from around the world. Mtaandao comes with some awesome, worldview-changing rights courtesy of its <a href="%s">license</a>, the GPL.' ), 'https://mtaandao.co.ke/about/license/' ); ?></p>

<ol start="0">
	<li><p><?php _e( 'You have the freedom to run the program, for any purpose.' ); ?></p></li>
	<li><p><?php _e( 'You have access to the source code, the freedom to study how the program works, and the freedom to change it to make it do what you wish.' ); ?></p></li>
	<li><p><?php _e( 'You have the freedom to redistribute copies of the original program so you can help your neighbor.' ); ?></p></li>
	<li><p><?php _e( 'You have the freedom to distribute copies of your modified versions to others. By doing this you can give the whole community a chance to benefit from your changes.' ); ?></p></li>
</ol>

<p><?php printf( __( 'Mtaandao grows when people like you tell their friends about it, and the thousands of businesses and services that are built on and around Mtaandao share that fact with their users. We&#8217;re flattered every time someone spreads the good word, just make sure to <a href="%s">check out our trademark guidelines</a> first.' ), 'http://Mtaandaofoundation.org/trademark-policy/' ); ?></p>

<p><?php

$plugins_url = current_user_can( 'activate_plugins' ) ? admin_url( 'plugins.php' ) : 'https://mtaandao.co.ke/plugins/';
$themes_url = current_user_can( 'switch_themes' ) ? admin_url( 'themes.php' ) : 'https://mtaandao.co.ke/themes/';

printf( __( 'Every plugin and theme in mtaandao.co.ke&#8217;s directory is 100%% GPL or a similarly free and compatible license, so you can feel safe finding <a href="%1$s">plugins</a> and <a href="%2$s">themes</a> there. If you get a plugin or theme from another source, make sure to <a href="%3$s">ask them if it&#8217;s GPL</a> first. If they don&#8217;t respect the Mtaandao license, we don&#8217;t recommend them.' ), $plugins_url, $themes_url, 'https://mtaandao.co.ke/about/license/' ); ?></p>

<p><?php _e( 'Don&#8217;t you wish all software came with these freedoms? So do we! For more information, check out the <a href="https://www.fsf.org/">Free Software Foundation</a>.' ); ?></p>

</div>
<?php include( ABSPATH . 'admin/admin-footer.php' ); ?>

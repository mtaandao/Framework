<?php

global $custom_branding_settings;

// Login Page Variables
$loginLinkTitle = ( $custom_branding_settings['loginLinkTitle'] ) ? $custom_branding_settings['loginLinkTitle'] : '';
$loginLinkUrl = ( $custom_branding_settings['loginLinkUrl'] ) ? $custom_branding_settings['loginLinkUrl'] : '';
$loginLogo = ( $custom_branding_settings['loginLogo'] ) ? '<img src="' . esc_url( $custom_branding_settings['loginLogo'] ) . '" />' : '';
$loginLogoDelete = ( $custom_branding_settings['loginLogo'] ) ? '' : 'style="display: none;"';
$loginBgImage = ( $custom_branding_settings['loginBgImage'] ) ? '<img src="' . esc_url( $custom_branding_settings['loginBgImage'] ) . '" />' : '';
$loginBgImageDelete = ( $custom_branding_settings['loginBgImage'] ) ? '' : 'style="display: none;"';
$loginBgPosition = $custom_branding_settings['loginBgPosition'];
$loginBgRepeat = $custom_branding_settings['loginBgRepeat'];

// Admin Branding Variables
$adminLogo = ( $custom_branding_settings['adminLogo'] ) ? '<img src="' . esc_url( $custom_branding_settings['adminLogo'] ) . '" />' : '';
$adminLogoFolded = ( $custom_branding_settings['adminLogoFolded'] ) ? '<img src="' . esc_url( $custom_branding_settings['adminLogoFolded'] ) . '" />' : '';
$adminFavicon = ( $custom_branding_settings['adminFavicon'] ) ? '<img src="' . esc_url( $custom_branding_settings['adminFavicon'] ) . '" />' : '';
$adminLogoDelete = ( $custom_branding_settings['adminLogo'] ) ? '' : 'style="display: none;"';
$adminLogoFoldedDelete = ( $custom_branding_settings['adminLogoFolded'] ) ? '' : 'style="display: none;"';
$adminFaviconDelete = ( $custom_branding_settings['adminFavicon'] ) ? '' : 'style="display: none;"';

// Dashboard
$dashboardCustomWidgetTitle = ( $custom_branding_settings['dashboardCustomWidgetTitle'] ) ? $custom_branding_settings['dashboardCustomWidgetTitle'] : '';
$dashboardCustomWidgetText = ( $custom_branding_settings['dashboardCustomWidgetText'] ) ? $custom_branding_settings['dashboardCustomWidgetText'] : '';

// Footer Settings Variables
$footerText = ( $custom_branding_settings['footerText'] ) ? $custom_branding_settings['footerText'] : '';

// Settings
$customLoginURL = ( $custom_branding_settings['customLoginURL'] ) ? $custom_branding_settings['customLoginURL'] : '';
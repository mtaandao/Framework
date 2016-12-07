<!doctype html>
<!--
  Material Design Lite
  Copyright 2015 Google Inc. All rights reserved.

  Licensed under the Apache License, Version 2.0 (the "License");
  you may not use this file except in compliance with the License.
  You may obtain a copy of the License at

      https://www.apache.org/licenses/LICENSE-2.0

  Unless required by applicable law or agreed to in writing, software
  distributed under the License is distributed on an "AS IS" BASIS,
  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  See the License for the specific language governing permissions and
  limitations under the License
-->

<?php require_once( dirname( dirname( __FILE__ ) ) . '/load.php' ); 

          if ( ! defined( 'ABSPATH' ) ) {
        define( 'ABSPATH', dirname( dirname( __FILE__ ) ) . '/' );
          }
      ?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Quick install.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title>Mtaandao &#8250; Installation</title>

    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="icon" sizes="192x192" href="images/logoAndy.png">

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Mtaandao &#8250; Installation">
    <link rel="apple-touch-icon-precomposed" href="images/logoiOS.png">

    <!-- Tile icon for Win8 (144x144 + tile color) -->
    <meta name="msapplication-TileImage" content="images/logoWin.png">
    <meta name="msapplication-TileColor" content="#3372DF">

    <link rel="shortcut icon" href="images/favicon.png">

    <!-- SEO: If your mobile URL is different from the desktop URL, add a canonical link to the desktop page https://developers.google.com/webmasters/smartphone-sites/feature-phones -->
    <!--
    <link rel="canonical" href="http://www.example.com/">
    -->

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="css/material.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
    #view-source {
      position: fixed;
      display: block;
      right: 0;
      bottom: 0;
      margin-right: 40px;
      margin-bottom: 40px;
      z-index: 900;
    }
    </style>
  </head>
  <body>
    <div class="init-layout mdl-layout mdl-layout--fixed-header mdl-js-layout mdl-color--grey-100">
      
      <div class="init-ribbon"></div>
      <main class="init-main mdl-layout__content">
        <div class="init-container mdl-grid">
          <div class="mdl-cell mdl-cell--2-col mdl-cell--hide-tablet mdl-cell--hide-phone"></div>
          <div class="init-content mdl-color--white mdl-shadow--4dp content mdl-color-text--grey-800 mdl-cell mdl-cell--8-col">
            <center><img src="images/mtaandao-logo.png" width="200px">
            <h3>System Requirements</h3></center>
            <ul>
            <li><a href="https://secure.php.net/">PHP</a> version <strong>5.2.4</strong> or higher.</li>
            <li><a href="https://www.mysql.com/">MySQL</a> version <strong>5.0</strong> or higher.</li>
          </ul>

          <h4>Recommendations</h4>
          <ul>
            <li><a href="https://secure.php.net/">PHP</a> version <strong>5.6</strong> or higher.</li>
            <li><a href="https://www.mysql.com/">MySQL</a> version <strong>5.6</strong> or higher.</li>
            <li>The <a href="https://httpd.apache.org/docs/2.2/mod/mod_rewrite.html">mod_rewrite</a> Apache module.</li>
            <li>A link to <a href="https://mtaandao.co.ke/">mtaandao.co.ke</a> on your site.</li>
          </ul>
            <center><h3>Installation</h3></center>
              <p>
                <li>Create a database for your Mtaandao Installation. Note the username and password.</li>
              </p>
              <h4>
                <a>If you have satisfied all the above requirements, click the "INSTALL NOW" button to proceed. Mtaandao will take care of everything moving forward.</a>
              </h4>

              <ol>
              <li>If for some reason the auto-installation process doesn&#8217;t work, don&#8217;t worry. It doesn&#8217;t work on all web hosts. Open up <code>config-sample.php</code> with a text editor like Sublime Text or similar and fill in your database connection details.</li>
              <li>Save the file as <code>configuration.php</code> and upload it.</li>
              <li>Open <a href="<?php echo esc_url( admin_url( '/' ). 'install.php' ); ?>">admin/install.php</a> in your browser.</li>
            </ol>

            <center><h3>Updating</h3></center>
            <h4>Using the Automatic Updater</h4>
            <p>If you are updating from version 2.7 or higher, you can use the automatic updater:</p>
            <ol>
              <li>Open <span class="file"><a href="<?php echo esc_url( admin_url( '/' ). 'update-core.php'); ?>">admin/update-core.php</a></span> in your browser and follow the instructions.</li>
              <li>You wanted more, perhaps? That&#8217;s it!</li>
            </ol>

            <h4>Updating Manually</h4>
            <ol>
              <li>Before you update anything, make sure you have backup copies of any files you may have modified such as <code>index.php</code>.</li>
              <li>Delete your old Mtaandao files, saving ones you&#8217;ve modified.</li>
              <li>Upload the new files.</li>
              <li>Point your browser to <span class="file"><a href="<?php echo esc_url( admin_url( '/' ). 'upgrade.php'); ?>">admin/upgrade.php</a>.</span></li>
            </ol>

            <center><h3>Migrating from other systems</h3></center>
            <p>Mtaandao can <a href="https://mtaandao.co.ke/docs/Importing_Content">import from a number of systems</a>. First you need to get Mtaandao installed and working as described above, before using <a href="<?php echo esc_url( admin_url( '/' ). 'import.php'); ?>" title="Import to Mtaandao">our import tools</a>.</p>
          </div>
        </div>
        <footer class="init-footer mdl-mini-footer">
          <div class="mdl-mini-footer--left-section">
            <ul class="mdl-mini-footer--link-list">
              <li><a href="http://mtaandao.co.ke/help/installation">Online Help</a></li>
              <li><a href="http://mtaandao.co.ke/docs">Documentation</a></li>
              <li><a href="http://mtaandao.co.ke/hosting">Hosting</a></li>
            </ul>
          </div>
        </footer>
      </main>
    </div>
      <a href="<?php echo esc_url( admin_url( '/' ). 'install.php' ); ?>" target="_blank" id="view-source" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--accent mdl-color-text--accent-contrast">INSTALL NOW</a>
    <script src="js/material.min.js"></script>
  </body>
</html>

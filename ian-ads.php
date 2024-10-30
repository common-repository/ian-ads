<?php
/*
Plugin Name: IAN Ads
Description: Add Ads from the Interactive Ad Network (IAN) to your WordPress site.
Version: 1.0.5
Author: Boncom, Inc.
Author URI: https://interactivead.network
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Text Domain: ian-ads
*/
defined( 'ABSPATH' ) or die( 'No direct access allowed.' );

require_once dirname(__FILE__) . '/widget.class.php';
require_once dirname(__FILE__) . '/shortcode.class.php';

class IAN_Ads {
  private static $instance;
  private static $menu_id = '';

  const IAN_URL = 'http://api.interactivead.network/verify-ad-slot';
  const TEXT_DOMAIN = 'ian-ads';
  const FIELD_PREFIX = 'ian-ads-';
  const OPT_NAME = 'ian-ads-slot-codes';

  public static function get_instance() {
    if (self::$instance == NULL) {
      self::$instance = new self();
    }
  }

  private function __construct() {

    // add menu item
    add_filter('admin_menu', array($this, 'admin_menu'));

    // add custom settings
    add_filter('admin_init', array($this, 'create_settings'));

    // add validation endpoint
    add_action('init', array($this, 'validate_token'));

    // add ajax refresh slot codes endpoint
    add_action('wp_ajax_ian_reload_slot_codes', array($this, 'ajax_reload_slot_codes'));

    // Conditionally register widget if there is at least one slot code found
    if (self::has_any_slot_codes()) {
      add_action('widgets_init', array($this, 'register_widget'));
    }

    // add shortcode for displaying the ad slot
    IAN_Ad_Shortcode::register();

  }

  /**
   * Registers widget for use on the site.
   */
  function register_widget() {
    register_widget('IAN_Ad_Widget');
  }

  /**
   * Creates the Admin menu link
   */
  function admin_menu() {
    self::$menu_id = add_options_page(
      __('IAN Ad Options', self::TEXT_DOMAIN),
      __('IAN Ad Options', self::TEXT_DOMAIN),
      'manage_options',
      'ian_options',
      array($this, 'options_page')
    );

    add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
  }

  function enqueue_scripts($hook_suffix) {
    if (self::$menu_id == $hook_suffix) {
      wp_enqueue_script('jquery');
      wp_register_script(self::TEXT_DOMAIN . 'js', plugins_url('index.996942f3.js', __FILE__));
      wp_enqueue_script(self::TEXT_DOMAIN . 'js');
      wp_register_style(self::TEXT_DOMAIN . 'styles', plugins_url('style.2d513c8a.css', __FILE__));
      wp_enqueue_style(self::TEXT_DOMAIN . 'styles');
    }
  }

  function create_settings() {

    // let Wordpress know about the option we're going to be using
    register_setting( self::FIELD_PREFIX . 'ads', self::OPT_NAME, array($this, 'validate_options') );

    // indicate there is going to be a section on the page for the slot codes
    add_settings_section( self::OPT_NAME, '', null, 'ian_options' );

    // see if there is a transient error value of options and use that, otherwise
    // pull the regular options to use
    if ($opts = get_transient(self::OPT_NAME . '-err-' . get_current_user_id())) {
      // clear it out so it isn't used again
      delete_transient(self::OPT_NAME . '-err-' . get_current_user_id());
    } else {
      // get the slot codes
      $opts = get_option(self::OPT_NAME);

    }
    if (!$opts) {
      $opts = [];
    }

    // setup the fields for use. Everything is stored in a single option field
    // so need to loop through and set default values for the first time or if
    // nothing has ever been saved for the slot codes.
    for ($i = 0; $i < 10; $i++) {
      if (count($opts) < $i - 1) {
        $opt = array('name' => '', 'code' => '');
      } else if (!isset($opts[$i]) || !is_array($opts[$i]) || !isset($opts[$i]['name'])) {
        $opt = array('name' => '', 'code' => '');
      } else {
        $opt = $opts[$i];
      }

      add_settings_field(
        'ian_slot_code_' . $i,
        '<span class="slot-name">' . $opt['name'] . '</span> (Slot Code ' . ($i + 1) . '):',
        array( $this, 'slot_code_input'),
        'ian_options',
        self::OPT_NAME,
        array($i, $opt)
      );
    }
  }

  /**
   * This will take in the options passed by the form submit, ensure that all of
   * the settings are correct. If one or more is incorrect, an error is set and
   * the currently saved settings are returned for saving in the database. In
   * addition, a transient value is set so when the settings page is loaded up
   * again, it will check for that transient value and use that instead of the
   * value that is saved in the options table.
   */
  function validate_options($opts) {
    $found_errs = array();
    if ($opts) {
      for ($x=0; $x < count($opts); $x++) {
        $opt = $opts[$x];
        if ($opt['code'] == '' && $opt['name'] == '') continue;

        if (preg_match('/^[3456789bcdfghjkmnpqrstvwxyBCDFGHJKMNPQRSTVWXY]+$/', $opt['code'])) {
          $opt['name'] = sanitize_text_field($opt['name']);
        } else {
          $found_errs[] = 'For #' . ($x + 1) . ', "' . sanitize_text_field($opt['code'])
            . '" is not a valid Slot Code. If you are having problems with the correct value, please <a href="https://interactivead.network/" target="_blank">Contact Us</a>.';
        }
      }
    }
    if ($found_errs && count($found_errs)) {

      set_transient(self::OPT_NAME . '-err-' . get_current_user_id(), $opts, 30);

      for ($x=0; $x < count($found_errs); $x++) {
        add_settings_error(self::OPT_NAME, 'ian_options', $found_errs[$x], 'error');
      }

      // return back what is already in the db so nothing changes
      return get_option(self::OPT_NAME);

    } else {
      // return back options as they have changed (specifically the names)
      return $opts;
    }
  }

  // outputs the input boxes for the slots
  function slot_code_input($args) {
    $idx = absint($args[0]);
    $opt = $args[1];

    // put in a hidden field of the name to ensure everything gets resaved on
    // the other side in the structure that we want
    print '<input data-slot-name type="hidden" name="' . self::OPT_NAME . '[' . $idx . '][name]" value="' .
      esc_attr($opt['name']) . '" />';
    print '<input class="regular-text code slot-code" name="' . self::OPT_NAME . '[' . $idx .
      '][code]" type="text" value="' . esc_attr($opt['code']) . '"/> <span class="button remove-button" data-id="' . $idx . '">Remove</span>';
  }

  /**
   * Callback for options page
   */
  function options_page() {
    $page_title = __('IAN Ad Options', self::TEXT_DOMAIN);
    print <<<start
      <div id="ian-ad-slots" class="wrap">
        <h1>$page_title</h1>
        <div id="no-slots-msg">
          <hr>
          <h3>Currently no ad slots for your site</h3>
          <p>Click on the refresh button below to try and reload any ad slot(s)
            setup for your site.</p>
          <p>It is also possible to manually add more ad slots by clicking on the
            "Add Slot" button and entering the Slot Code.</p>
          <hr>
        </div>
        <div id="has-slots-msg">
          <hr>
          <p>Slot Code values should be letters and numbers with no spaces.</p>
          <p>Once you have added, changed or refreshed them you will need to save the changes.</p>
        </div>
        <form method="post" action="options.php" id="ad-slot-form">
start;

    settings_fields(self::FIELD_PREFIX . 'ads');
    do_settings_sections('ian_options');
    print <<<end
          <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
          <span id="add-slot" class="button">Add Another Slot</span>
          <span id="update-slots-icon" class="dashicons dashicons-update"></span>
          <span id="update-slots-msg">Refreshing</span>
          <span id="update-slots-btn" class="button">Refresh Slot Codes</span>
        </form>
      </div>
end;
  require 'explanation.php';
  }


  /**
   * This is called by the IAN api server to check to make sure a request for the
   * domain is a valid one. The request is made initially by sending over a token
   * included in the request and the api server will hit the endpoint below with
   * the token as a way to say "hey, did you just ask me a question about your
   * domain?" There should be a transient value with the token if it did make
   * the request.
   *
   * NOTE: I'm not real proud that this is being done in a backhanded sort of way
   * that theme and plugin devs won't know what's going on with this URL, but the
   * rewrite API isn't responding correctly and this is pretty lightweight. So,
   * if you're pulling your hair out over the URL /ian-validate-token somewhere
   * else, I apologize. You've found the culprit.
   */
  function validate_token() {

    // trying to keep things light initially, so just a raw string comparison
    if (strpos($_SERVER['REQUEST_URI'], '/ian-validate-token?token=') !== FALSE) {

      if (get_transient($_GET['token']) !== FALSE) {
        delete_transient($_GET['token']);
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
        echo 'OK';
      } else {
        header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
      }
      // going to die whether we fail or succeed
      die();
    }

  }

  /**
   * Reaches out to IAN API to load the known slots for this site.
   * This is called when the plugin is refreshed and whenever the user requests
   * a refresh from the settings page via ajax.
   */
  static function load_registered_slots() {
    $domain = explode('//', get_site_url())[1];
    $token = uniqid(self::FIELD_PREFIX, true);
    set_transient($token, 1, 60);
    $req = new WP_Http();
    $rslt = $req->request(IAN_Ads::IAN_URL . '?domain=' . urlencode($domain) . '&token=' . $token);

    if ($rslt instanceof WP_Error) {
      return array('status' => 'Unable to get slot code\'s');
    } else if ($rslt['response']['code'] == 200) {
      $slot_codes = json_decode($rslt['body'], TRUE);
      // until the server side is updated, need to remap 'id's to 'code's
      foreach ($slot_codes as $code) {
        $code['code'] = $code['id'];
      }
      // fill-in blank slots. I know this isn't ideal to have empty slots and
      // limiting to 10 but it was the way things originally got built and this
      // is faster than to rework/retest everything. Someday come back around
      // and make it more refined to allow as many/few as desired.
      for ($x=count($slot_codes); $x < 10; $x++) {
        $slot_codes[] = array('name' => '', 'code' => '');
      }
      update_option(self::OPT_NAME, $slot_codes);
      return $slot_codes;
    } else {
      return array('status' => 'Problem getting slot codes');
    }
  }

  /**
   * A wrapper function around the load_registered_slots() function to enable
   * the data to be returned via an ajax call in json format.
   */
  function ajax_reload_slot_codes() {
    $slot_codes = self::load_registered_slots();
    $json = json_encode($slot_codes);
    echo $json;
    die();
  }

  /**
   * checks if there are any slot codes currently in the options table saved.
   */
  static function has_any_slot_codes() {
    $slot_codes = get_option(self::OPT_NAME);
    if ($slot_codes) {
      foreach ($slot_codes as $slot) {
        if ($slot['code'] != '') {
          return TRUE;
        }
      }
    }
    return FALSE;
  }

  static function activate() {
    // do nothing
  }
}

$ian_instance = IAN_Ads::get_instance();

register_deactivation_hook(__FILE__, 'flush_rewrite_rules');
register_activation_hook(__FILE__, 'IAN_Ads::activate');

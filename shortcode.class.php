<?php

/**
 * Creates the shortcode that can be used to input an ad slot into the middle of
 * content as desired.
 */
class IAN_Ad_Shortcode {

  private static $instance = NULL;

  private $default_slot_id = '';

  /**
   * Manages registering the shortcode callback and ensuring it is only called
   * once, along with creating a singleton of this class.
   */
  public static function register() {
    if (self::$instance == NULL) {
      self::$instance = new self();
      add_action('init', array(self::$instance, 'register_shortcode'));
    }
  }

  /**
   * Callback to register shortcode
   */
  function register_shortcode() {
    add_shortcode('ian-ad', array($this, 'show_script'));
  }

  /**
   * Callback that generates the <script> tag to show on the page.
   */
  function show_script($atts) {
    extract(shortcode_atts(array(
      'code' => $this->get_default_slot_id()
    ), $atts));

    return '<script type="text/javascript" src="//a.ian.xyz/js/ian.js" data-cfasync="false" data-ian-adslot="' . $code . '"></script>';
  }

  /**
   * Ensure that the default slot id is used if nothing is specified.
   */
  function get_default_slot_id() {
    if ($this->default_slot_id == '') {
      $opts = get_option(IAN_Ads::OPT_NAME);
      if ($opts) {
        foreach($opts as $opt) {
          if ($opt['code']) {
            $this->default_slot_id = $opt['code'];
            break;
          }
        }
      }
    }

    return $this->default_slot_id;
  }
}

<?php

class IAN_Ad_Widget extends WP_Widget {

  const SLOT_ID = 'ian_slot_id';

  public function __construct() {
    $widget_ops = array(
      'classname' => 'ian_ad_slot',
      'description' => __("Show an Ad from Interactive Ad Network (IAN)", 'ian-ads')
    );
    parent::__construct('ian-ad', __('IAN Ad', 'ian-ads'), $widget_ops);

  }

  public function widget($args, $instance) {
    $slot_id = '';
    if (!isset($instance['ian_ad_slot']) || $instance['ian_ad_slot'] == '') {
      // need to load it up from the options
      $slots = get_option(IAN_Ads::OPT_NAME);
      foreach($slots as $id) {
        if ($id['code'] != '') {
          $slot_id = $id['code'];
          break;
        }
      }
    } else {
      $slot_id = $instance['ian_ad_slot'];
    }
    echo $args['before_widget'];
    ?><script type="text/javascript" src="//a.ian.xyz/js/ian.js" data-cfasync="false" data-ian-adslot="<?php echo $slot_id; ?>"></script><?php
    echo $args['after_widget'];
  }

  public function update($new_instance, $old_instance) {
    return $new_instance;
  }

  public function form($instance) {
    $defaults = array(self::SLOT_ID => '');
    $args = wp_parse_args($instance, $defaults);

    // pull out the slot ids that are available
    $id_opts = get_option(IAN_Ads::OPT_NAME);
    $avail_opts = array();
    foreach ($id_opts as $opt) {
      if ($opt['code'] != '') {
        $avail_opts[] = $opt;
      }
    }
    ?>
    <p>
      <label for="<?php echo $this->get_field_id(self::SLOT_ID); ?>">
        <?php _e('Slot Code to Use: ', 'ian-ads');

        if (count($avail_opts) > 1) {
          ?><select id="<?php
              echo $this->get_field_id(self::SLOT_ID);
            ?>" name="<?php
              echo $this->get_field_name(self::SLOT_ID);
            ?>">
            <?php foreach ($avail_opts as $opt) {
              error_log($opt['code'] . ' == ' . $args[self::SLOT_ID]);
              ?><option value="<?php echo $opt['code']; ?>" <?php echo ($args[self::SLOT_ID] == $opt['code'] ? 'selected' : ''); ?>><?php echo $opt['name'] . ' (' . $opt['code'] . ')'; ?></option>
              <?php
            } ?>
          </select>
          <?php
        } else {
          ?>Using Slot Id: <?php echo $avail_opts[0]['name'] . ' (' . $avail_opts[0]['code'] . ')'; ?>
          <input type="hidden" name="<?php echo $this->get_field_id(self::SLOT_ID); ?>" value="">
        <?php } ?>
      </label>
    </p>
    <?php
  }
}

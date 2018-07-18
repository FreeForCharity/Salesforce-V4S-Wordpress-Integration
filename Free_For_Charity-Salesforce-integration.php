<?php
/*
plugin name: FFC Volunteer Site Integration
author: Gavin Glowacki
*/
add_action( 'show_user_profile', 'ffc_show_SalesforceID' );
add_action( 'edit_user_profile', 'ffc_show_SalesforceID' );

function ffc_show_SalesforceID( $user ){
  $Record_ID = get_the_author_meta('SalesforceID', $user->ID);
  ?>
  <h3><?php esc_html_e('Volunteer Record Information', 'ffc'); ?></h3>

  <table class="form-table">
    <tr>
      <th><label for="SalesforceID"><?php esc_html_e('SalesforceID', 'ffc'); ?></label></th>
      <td>
        <input type="text"
        id="SalesforceID"
        name="SalesforceID"
        value="<?php echo esc_attr( $Record_ID ); ?>"
        class="regular-text"
        />
      </td>
    </tr>
  </table>
  <?php
}

add_action( 'user_profile_update_errors', 'ffc_SalesforceID_update_errors', 10, 3 );
function ffc_SalesforceID_update_errors($errors, $update, $user ) {
  if ( empty($_POST['SalesforceID']) ) {
    $errors->add('SalesforceID_error', __('<strong>ERROR</strong>: please enter a valid Salesforce ID.', 'ffc') );
  } elseif (strlen($_POST['SalesforceID']) != 15)  {
    $errors->add('SalesforceID_error', __('<strong>ERROR</strong>: please enter a valid Salesforce ID.', 'ffc') );
  }
}

add_action( 'personal_options_update', 'ffc_update_SalesforceID' );
add_action( 'edit_user_profile_update', 'ffc_update_SalesforceID' );
function ffc_update_SalesforceID( $user_id ) {
  if ( ! current_user_can( 'edit_user', $user_id ) ) {
    return false;
  }

  if ( ! empty($_POST['SalesforceID'] && strlen($_POST['SalesforceID']) == 15) ) {
    update_user_meta( $user_id, 'SalesforceID',($_POST['SalesforceID']) );
  }
}

function ffc_iframe_shortcode( $atts ) {
  $args = shortcode_atts(
    array(
      'width' => '940',
      'height'  => '844'
    ),
    $atts
);
$base_URL = "https://freeforcharity.secure.force.com/Volunteer/GW_Volunteers__PersonalSiteContactInfo?contactId=";
$Record_ID = get_the_author_meta('SalesforceID', $user->ID);
$Target_URL = $base_URL . $Record_ID;

return sprintf( '<iframe src="%1$s"
  height="%2$s"
  width="%3$s"
  frameborder="0"
  scrolling="no"
  </iframe>',
  esc_url($Target_URL),
  $args['height'],
  $args['width']
  );
}
add_shortcode( 'volunteer_site', 'ffc_iframe_shortcode' );
?>

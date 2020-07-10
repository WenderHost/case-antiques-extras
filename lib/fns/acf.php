<?php

namespace CASEXTRAS\acf;

/**
 * Setup ACF options pages.
 */
if( function_exists('acf_add_options_page') ) {
  acf_add_options_page(array(
    'page_title'  => 'Case Antiques General Settings',
    'menu_title'  => 'Case Settings',
    'menu_slug'   => 'case-general-settings',
    'capability'  => 'edit_posts',
    'redirect'    => false
  ));
}

/**
 * Populate ACF select field options with Gravity Forms forms
 */
function populate_gf_forms_ids( $field ) {
  if ( class_exists( 'GFFormsModel' ) ) {
    $choices = [];

    foreach ( \GFFormsModel::get_forms() as $form ) {
      $choices[ $form->id ] = $form->title;
    }

    $field['choices'] = $choices;
  }

  return $field;
}
add_filter( 'acf/load_field/name=submit_project_gf_form_id', __NAMESPACE__ . '\\populate_gf_forms_ids' );

/**
 * Saves ACF configurations as JSON.
 *
 * @param      string  $path   The save path
 *
 * @return     string  The modified save path.
 */
function json_save_point( $path ) {
  // update path
  $path = plugin_dir_path( __FILE__ ) . '../acf-json';

  // return
  return $path;
}
add_filter('acf/settings/save_json', __NAMESPACE__ . '\\json_save_point');

/**
 * Loads ACF JSON Configuration files from our save path.
 *
 * @param      array  $paths  The array containing our ACF save paths
 *
 * @return     array  Filtered ACF save paths array.
 */
function json_load_point( $paths ) {

    // append path
    $paths[] = plugin_dir_path( __FILE__ ) . '../acf-json';

    // return
    return $paths;
}
add_filter('acf/settings/load_json', __NAMESPACE__ . '\\json_load_point');

/**
 * Sets GF Stripe feed to auth-only transaction.
 *
 * @param      <type>   $authorization_only  The authorization only
 * @param      <type>   $feed                The feed
 *
 * @return     boolean  ( description_of_the_return_value )
 */
function stripe_charge_authorization_only( $authorization_only, $feed, $submission_data, $form, $entry ) {

  // Get our ACF option for Auth-Only Forms
  $auth_only_option = get_field( 'authorize_only_forms', 'option' );
  foreach ($auth_only_option as $auth_only_form ) {
    $auth_only_form_ids[] = $auth_only_form['submit_project_gf_form_id'];
  }

  // Check if this current form has been set to Auth-Only
  $current_form_id = $form['id'];
  if( in_array( $current_form_id, $auth_only_form_ids ) ){
    uber_log( '🔔 Form ID ' . $form['id'] . ' has been set to AUTH ONLY for all Stripe feeds.' );
    return true;
  }

  return $authorization_only;
}
add_filter( 'gform_stripe_charge_authorization_only', __NAMESPACE__ . '\\stripe_charge_authorization_only', 10, 5 );
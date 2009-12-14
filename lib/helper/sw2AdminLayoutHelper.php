<?php

function addStylesheet(sfPHPView $view) {

  /**
   * Taken from
   * SVN: $Id: sfPHPView.class.php 11783 2008-09-25 16:21:27Z fabien $
   */
  extract($view->getAttributeHolder()->toArray());
  # We now have all the template variables

  $sf_context->getResponse()->addStylesheet('/sw2UtilityPlugin/css/admin.css');
}

/**
 * Get the Full page with admin layout and menu
 *
 * @param sfPHPView $view
 * @param string $page_data
 * @param string $menu_style Should be horizontal or vertical
 */
function getAdminPage(sfPHPView $view, $page_data, $menu_style='horizontal') {


  /**
   * Taken from
   * SVN: $Id: sfPHPView.class.php 11783 2008-09-25 16:21:27Z fabien $
   */
  extract($view->getAttributeHolder()->toArray());
  # We now have all the template variables

  # Add stylesheet
  $sf_context->getResponse()->addStylesheet('/sw2UtilityPlugin/css/admin.css');

  # Build Menu
  $menu_data = '';

  if( $sf_user->hasCredential(sfConfig::get('app_sw2AdminLayout_menu_credential', 'admin')) ) {
    $menu_data .= '<div id="sf_admin_nav" class="'.$menu_style.'">';
    $menu_data .= Get_Array_Keys_UL(sfConfig::get('app_sw2AdminLayout_menu'));
    $menu_data .= '</div>';
  }

  echo <<<LAYOUT
  <div class="pageContainer">
    $menu_data
    $page_data
    <div id="overlay" style="display: none;"></div>
    <div id="lightbox" style="display: none;"></div>
  </div>
LAYOUT;
}

function Get_Array_Keys_UL($array = array()) {
  $recursion = __FUNCTION__;
  if(empty($array))
    return '';
  $out = '<ul>' . "\n";
  foreach($array as $key => $elem)
    if(is_array($elem)) {
      $out .= '<li>' . $key . $recursion($elem) . '</li>' . "\n";
    }
    else {
      $out .= '<li>' . link_to($key, $elem) . '</li>';
    }
  $out .= '</ul>' . "\n";
  return $out;
}

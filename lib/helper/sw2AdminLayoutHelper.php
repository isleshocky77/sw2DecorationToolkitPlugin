<?php

/**
 * We must add the stylesheets when the helper is loaded so it added before the
 * displaying of stylesheets
 */
addStylesheet();

/**
 * Adds the stylesheet needed for this helper to the response
 */
function addStylesheet() {

  $sf_context = sfContext::getInstance();
  $sf_context->getResponse()->addStylesheet('/sw2DecorationToolkitPlugin/css/admin.css', sfWebResponse::FIRST);
}

/**
 * Get the Full page with admin layout and menu
 *
 * @param sfPHPView $view
 * @param string $page_data
 * @param string $menu_style Should be horizontal or vertical
 */
function getAdminPage($page_data, $menu_style='horizontal') {

  $sf_context = sfContext::getInstance();
  $sf_user = $sf_context->getUser();

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
    if(is_array($elem) && !isset($elem['href'])) {
      $out .= '<li>' . $key . $recursion($elem) . '</li>' . "\n";
    }
    elseif(is_array($elem)) {
      $href = $elem['href'];
      $options = $elem;
      unset($options['href']);
      $out .= '<li>' . link_to($key, $href, $options) . '</li>';
    } else {
      $out .= '<li>' . link_to($key, $elem) . '</li>';
    }
  $out .= '</ul>' . "\n";
  return $out;
}

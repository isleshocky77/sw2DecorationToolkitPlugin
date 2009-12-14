<?php
/**
 * Adds a css class to the html body tag
 *
 * @param string $class space delimited classes
 * @return unknown
 */
function add_body_class($class) {
  return _get_or_set_body_class($class);
}

/**
 * Gets and Sets the static $body_classes variable which holds an array of all body classes
 *
 * @param string $class A list of space delimited css classes to add to the html body tag
 * @return array An array of all body css classes
 */
function _get_or_set_body_class($class = null) {
  static $body_classes = array();
  if($class) {
    $body_classes[] = $class;
    $body_classes = array_unique($body_classes);
  }

  return $body_classes;
}

/**
 * Returns the css body class attribute populated with all the css body classes
 *
 * @param sfView $view
 * @param string $classes A list of space delimited additional css classes to add to the body
 * @return string  A String containing the class="" attribute to be put in the <body /> tag
 */
function get_body_class(sfView $view, $classes = '') {
  if(strlen($classes)) {
    $_body_classes = explode(' ', $classes);
  } else {
    $_body_classes = array();
  }

  /**
   * Taken from
   * SVN: $Id: sfPHPView.class.php 11783 2008-09-25 16:21:27Z fabien $
   */
  extract($view->getAttributeHolder()->toArray());
  # We now have all the template variables

  $module_name = $sf_context->getModuleName();
  $action_name = $sf_context->getActionName();

  //ex: indexSuccess.php
  //$template = $sf_context->getActionStack()->getLastEntry()->getViewInstance()->getTemplate();
  if($module_name == 'sfSimpleCMS' && $action_name == 'show' && isset($page)) {
    $_body_classes[] = 'cms s_' . str_replace('/', '-', $page->slug);
  } else {
    $_body_classes[] = 'm_' . $module_name . ' a_' . $action_name;
  }

  if($body_class = _get_or_set_body_class()) {
    $_body_classes = array_merge($_body_classes, $body_class);
  }

  if(!count($_body_classes)) {
    return '';
  }

  return ' class="' . implode(' ', $_body_classes) . '"';
}

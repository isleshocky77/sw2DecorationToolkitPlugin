<?php

/**
 *
 *
 * @package    symfony
 * @subpackage widget
 * @author     Stephen Ostrow <sostrow@sowebdesigns.com>
 * @version    SVN: $Id$
 */
class sfWidgetFormSchemaFormatterListNoDecorator extends sfWidgetFormSchemaFormatter
{
  protected
    $rowFormat       = "<li>\n  %error%%label%\n  %field%%help%\n%hidden_fields%</li>\n",
    $errorRowFormat  = "<li>\n%errors%</li>\n",
    $helpFormat      = '<br />%help%',
    $decoratorFormat = "\n  %content%";
}

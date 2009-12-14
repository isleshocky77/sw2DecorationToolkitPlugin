<?php

/**
 *
 *
 * @package    symfony
 * @subpackage widget
 * @author     Stephen Ostrow <sostrow@sowebdesigns.com>
 * @version    SVN: $Id$
 */
class sfWidgetFormSchemaFormatterDefinitionList extends sfWidgetFormSchemaFormatter
{
  protected
    $rowFormat       = "\n<dt>%label%</dt>\n<dd>%error%\n%field%\n%help%\n%hidden_fields%</dd>\n",
    $errorRowFormat  = "<li>\n%errors%</li>\n",
    $helpFormat      = '<span class="help">%help%</span>',
    $decoratorFormat = "<dl>\n  %content%</dl>";
}

<?php

class sw2PhoneValidator extends sfValidator
{
  public function initialize ($context, $parameters = null)
  {
    // Initialize parent
    parent::initialize($context);

    // Set default parameters value
    $this->setParameter('replace', false);
    $this->setParameter('match_error', 'Invalid phone number.');
    $this->setParameter('min', 10);
    $this->setParameter('min_error', 'Phone number too short.');
    $this->setParameter('max', 13);
    $this->setParameter('max_error', 'Phone number too long.');

    // Set parameters
    $this->getParameterHolder()->add($parameters);

    return true;
  }
  public function execute (&$value, &$error)
  {
    if ( !preg_match('/^[\(\)\-\+ 0-9]+$/', $value) )
    {
      $error = $this->getParameter('match_error');
      return false;
    }
    $numbers = eregi_replace('(\(|\)|\-|\+| )', '', $value);
    if ( !is_numeric($numbers) )
    {
      $error = $this->getParameter('match_error');
      return false;
    }
    // 000 000 0000
    // AC  PRE SUFX = min 10 digits
    if ( strlen($numbers) < $this->getParameter('min') )
    {
      $error = $this->getParameter('min_error');
      return false;
    }
    if( strlen($numbers) > $this->getParameter('max') )
    {
      // 000 000 000 0000
      // CC  AC  PRE SUFX = max 13 digits
      $error = $this->getParameter('max_error');
      return false;
    }
    if ( $this->getParameter('replace') && $this->getContext()->getRequest()->getParameter($this->getParameter('replace')) == $value )
    {
      preg_match('/^([0-9]{1,3}[0-9]{3}|[0-9]{3})?([0-9]{3})([0-9]{4})$/', $numbers, $matches);
      if ( $matches )
      {
        $formatted_phone_number = '';
        if ( strlen($matches[3]) )
        {
          $formatted_phone_number = $matches[3] . $formatted_phone_number;
        }
        if ( strlen($matches[2]) )
        {
          $formatted_phone_number = $matches[2] . '-' . $formatted_phone_number;
        }
        if ( strlen($matches[1]) > 3 )
        {
          $formatted_phone_number = '+' . substr($matches[1], 0, -3) . ' (' . substr($matches[1], -3) . ') ' . $formatted_phone_number;
        }
        else if ( strlen($matches[1]) == 3 )
        {
          $formatted_phone_number = '(' . $matches[1] . ') ' . $formatted_phone_number;
        }
        $this->getContext()->getRequest()->getParameterHolder()->set($this->getParameter('replace'), $formatted_phone_number);
      }
    }
    return true;
  }
}

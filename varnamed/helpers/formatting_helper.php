<?php 
function format_address($fields, $br=false)
{
	if(empty($fields))
	{
		return ;
	}
	
	// Default format
	$default = "{firstname} {lastname}\n{company}\n{address_1}\n{address_2}\n{city}, {zone} {postcode}\n{country}";
	
	// Fetch country record to determine which format to use
	$CI = &get_instance();
	$CI->load->model('location_model');
	$c_data = $CI->location_model->get_country($fields['country_id']);
	
	if(empty($c_data->address_format))
	{
		$formatted	= $default;
	} else {
		$formatted	= $c_data->address_format;
	}

	$formatted		= str_replace('{firstname}', $fields['firstname'], $formatted);
	$formatted		= str_replace('{lastname}',  $fields['lastname'], $formatted);
	$formatted		= str_replace('{company}',  $fields['company'], $formatted);
	
	$formatted		= str_replace('{address_1}', $fields['address1'], $formatted);
	$formatted		= str_replace('{address_2}', $fields['address2'], $formatted);
	$formatted		= str_replace('{city}', $fields['city'], $formatted);
	$formatted		= str_replace('{zone}', $fields['zone'], $formatted);
	$formatted		= str_replace('{postcode}', $fields['zip'], $formatted);
	$formatted		= str_replace('{country}', $fields['country'], $formatted);
	
	// remove any extra new lines resulting from blank company or address line
	$formatted		= preg_replace('`[\r\n]+`',"\n",$formatted);
	if($br)
	{
		$formatted	= nl2br($formatted);
	}
	return $formatted;
	
}

function format_address_NL($fields, $br=false) {
	if(empty($fields))
	{
		return ;
	}
	
	// Default format
	$default = "{SOORT}\n {NAAM2} {NAAM3}\n{NAAM1}\n{STRAAT}\n{HUISNR}\n{PLAATS}, {LANDCODE} {POSTCODE}\n{LAND}";
	
	// Fetch country record to determine which format to use
	$CI = &get_instance();
	$CI->load->model('location_model');
	$c_data = $CI->location_model->get_country($fields['LANDCODE']);
	
	if(empty($c_data->address_format))
	{
		$formatted	= $default;
	} else {
		$formatted	= $c_data->address_format;
	}
	$type = array(1=>'Invoice address',2=>'Delivery address',3=>'Drop-shipment address',);
	
	$formatted		= str_replace('{SOORT}', '<strong>Type</strong> '.$type[$fields['SOORT']], $formatted);
	$formatted		= str_replace('{NAAM2}', '<strong>Second name</strong> '.$fields['NAAM2'], $formatted);
	$formatted		= str_replace('{NAAM3}',  '<strong>First name</strong> '.$fields['NAAM3'], $formatted);
	$formatted		= str_replace('{NAAM1}',  '<strong>Company</strong> '.$fields['NAAM1'], $formatted);
	
	$formatted		= str_replace('{STRAAT}', '<strong>Street </strong> '.$fields['STRAAT'], $formatted);
	$formatted		= str_replace('{HUISNR}', '<strong>Street Nr. </strong> '.$fields['HUISNR'], $formatted);
	$formatted		= str_replace('{PLAATS}', '<strong>City </strong> '.$fields['PLAATS'], $formatted);
	$formatted		= str_replace('{LANDCODE}', $fields['LANDCODE'], $formatted);
	$formatted		= str_replace('{POSTCODE}', '<strong>Zip </strong> '.$fields['POSTCODE'], $formatted);
	$formatted		= str_replace('{LAND}', '<strong>Country </strong> '.$fields['LAND'], $formatted);
	
	// remove any extra new lines resulting from blank company or address line
	$formatted		= preg_replace('`[\r\n]+`',"\n",$formatted);
	if($br)
	{
		$formatted	= nl2br($formatted);
	}
	return $formatted;
	
}
function format_currency($value, $symbol=true)
{

	if(!is_numeric($value))
	{
		return;
	}
	
	$CI = &get_instance();
	
	if($value < 0 )
	{
		$neg = '- ';
	} else {
		$neg = '';
	}
	
	if($symbol)
	{
		$formatted	= number_format(abs($value), 2, $CI->config->item('currency_decimal'), $CI->config->item('currency_thousands_separator'));
		
		if($CI->config->item('currency_symbol_side') == 'left')
		{
			$formatted	= $neg.$CI->config->item('currency_symbol').$formatted;
		}
		else
		{
			$formatted	= $neg.$formatted.$CI->config->item('currency_symbol');
		}
	}
	else
	{
		//traditional number formatting
		$formatted	= number_format(abs($value), 2, '.', ',');
	}
	
	return $formatted;
}
function changekeyname($array, $newkey, $oldkey)
{
   foreach ($array as $key => $value) 
   {
      if (is_array($value))
         $array[$key] = changekeyname($value,$newkey,$oldkey);
      else
        {
             $array[$newkey] =  $array[$oldkey];    
        }

   }
   unset($array[$oldkey]);          
   return $array;   
}

 function valid_date($date)
{
    $date_format = 'Y-m-d'; /* use dashes - dd/mm/yyyy */

    $date = trim($date);
    /* UK dates and strtotime() don't work with slashes, 
    so just do a quick replace */
    $date = str_replace('/', '-', $date); 


    $time = strtotime($date);

    $is_valid = date($date_format, $time) == $date;

    if($is_valid)
    {
        return true;
    }

    /* not a valid date..return false */
    return false;
}
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

function _clean_input_keys($str)
{
    if ( ! preg_match("/^[a-z0-9:_\/-]+$/i", $str))
    {
        exit('Disallowed Key Characters.');
    }

    // Clean UTF-8 if supported
    if (UTF8_ENABLED === TRUE)
    {
        $str = $this->uni->clean_string($str);
    }

    return $str;
}




























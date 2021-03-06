<?php
    
    
    // are we live
    //use below for devlopement
     //if(!defined('LIVE')) DEFINE('LIVE', false);
	//use below for live
	if(!defined('LIVE')) DEFINE('LIVE', true);
	
	//errors emailed here
	DEFINE('CONTACT_EMAIL', 'hello@dukesnuz.com');
	DEFINE('CONTACT_EMAIL_2', 'david@ajaxtransport.com');
	
	
     //define connection to database                   
    define('MYSQL', '../../include_2/mysqli_connect.php');
    //below for admin folder
    //define('MYSQL_ADMIN', '../../includes_2/mysql.inc.php');

    //define url link when using MOD_WRITE
    define('MODWRITE', '/d/phppercolate_7/ecom-2/ch_14');
	

	
	function my_error_handler($e_number, $e_message, $e_file, $e_line, $e_vars)
	{
		//build error message
		$message = "An error occurred in script '$e_file' on line $e_line:\n$e_message\n";
		//add backtrace
		$message .="<pre>".print_r(debug_backtrace(),1). "</pre>\n";
		
		//or just append $e_vars to the message:
		//$message .="<pre>" .print_r ($e_vars, 1) . "</pre>\n";
		
		if(!LIVE)
			{
				//show error in browser
				echo '<div class="error">' . nl2br($message) . '</div>';
			}else{
				//developement print error
				//send error in an email
				error_log ($message, 1, CONTACT_EMAIL, 'From:DukesNuz');
				
				//only print error in browser, if error isnt a notice
				if($e_number != E_NOTICE)
					{
						echo ' <div class="error">A System error occurred.  We apologize for the 
						inconvenience.</div>';
					}
			}//End of $live IF_ELSE.
			return true; //So that PHP does nt try to handle the error, too.
	} //End of my_error_handler() definition
//Use my error handler
set_error_handler('my_error_handler');


//chapter 9 below functions
//returns price
function get_just_price($regular, $sales)
	{
		if ((0 < $sales) && ($sales < $regular))
			{
				return number_format($sales/100, 2 );
			}else{
				return number_format($regular/100, 2);
			}
	}

//parse sku

function parse_sku($sku)
	{
		//grab first character
		$type_abbr = substr($sku, 0,1);
		
		//grab remaining character
		$pid = substr($sku, 1);
		
		//validate the type
		if($type_abbr === 'C')
			{
				$type = 'coffee';
			}elseif($type_abbr === 'G')
			{
				$type = 'goodies';
			}else{
				$type = NULL;
			}
			
	   //validate product id
	   $pid = (filter_var($pid, FILTER_VALIDATE_INT, array('min_range' => 1))) ? $pid: NULL;
	   
	   //return the values
	   return array($type, $pid);
	}//end of parse_sku() function



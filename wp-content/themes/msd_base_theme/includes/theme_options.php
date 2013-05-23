<?php
/*******************************
  THEME OPTIONS PAGE
********************************/

add_action('admin_menu', 'msdbase_theme_page');
function msdbase_theme_page ()
{
	if ( count($_POST) > 0 && isset($_POST['msdbase_settings']) )
	{
		$options = array ('biz_name','street','street2','city','state','zip','phone','fax','linkedin_link','twitter_user','latest_tweet','facebook_link');
		
		foreach ( $options as $opt )
		{
			delete_option ( 'msdbase_'.$opt, $_POST[$opt] );
			add_option ( 'msdbase_'.$opt, $_POST[$opt] );	
		}			
		 
	}
	add_submenu_page('options-general.php',__('Settings'), __('Theme Options'), 'administrator', 'msdbase-options', 'msdbase_settings');
}
function msdbase_settings()
{
$states = array('ALABAMA'=>"AL",
'ALASKA'=>"AK",
'AMERICAN SAMOA'=>"AS",
'ARIZONA'=>"AZ",
'ARKANSAS'=>"AR",
'CALIFORNIA'=>"CA",
'COLORADO'=>"CO",
'CONNECTICUT'=>"CT",
'DELAWARE'=>"DE",
'DISTRICT OF COLUMBIA'=>"DC",
"FEDERATED STATES OF MICRONESIA"=>"FM",
'FLORIDA'=>"FL",
'GEORGIA'=>"GA",
'GUAM' => "GU",
'HAWAII'=>"HI",
'IDAHO'=>"ID",
'ILLINOIS'=>"IL",
'INDIANA'=>"IN",
'IOWA'=>"IA",
'KANSAS'=>"KS",
'KENTUCKY'=>"KY",
'LOUISIANA'=>"LA",
'MAINE'=>"ME",
'MARSHALL ISLANDS'=>"MH",
'MARYLAND'=>"MD",
'MASSACHUSETTS'=>"MA",
'MICHIGAN'=>"MI",
'MINNESOTA'=>"MN",
'MISSISSIPPI'=>"MS",
'MISSOURI'=>"MO",
'MONTANA'=>"MT",
'NEBRASKA'=>"NE",
'NEVADA'=>"NV",
'NEW HAMPSHIRE'=>"NH",
'NEW JERSEY'=>"NJ",
'NEW MEXICO'=>"NM",
'NEW YORK'=>"NY",
'NORTH CAROLINA'=>"NC",
'NORTH DAKOTA'=>"ND",
"NORTHERN MARIANA ISLANDS"=>"MP",
'OHIO'=>"OH",
'OKLAHOMA'=>"OK",
'OREGON'=>"OR",
"PALAU"=>"PW",
'PENNSYLVANIA'=>"PA",
'RHODE ISLAND'=>"RI",
'SOUTH CAROLINA'=>"SC",
'SOUTH DAKOTA'=>"SD",
'TENNESSEE'=>"TN",
'TEXAS'=>"TX",
'UTAH'=>"UT",
'VERMONT'=>"VT",
'VIRGIN ISLANDS' => "VI",
'VIRGINIA'=>"VA",
'WASHINGTON'=>"WA",
'WEST VIRGINIA'=>"WV",
'WISCONSIN'=>"WI",
'WYOMING'=>"WY");
	?>
<div class="wrap">
	<h2>Theme Options</h2>
	
<form method="post" action="">
	<fieldset style="border:1px solid #ddd; padding-bottom:20px; margin-top:20px;">
	<legend style="margin-left:5px; padding:0 5px; color:#2481C6;text-transform:uppercase;"><strong>Contact Info</strong></legend>
		<table class="form-table">
		<tr valign="top">
			<th scope="row"><label for="biz_name">Business Name:</label></th>
			<td>
				<input name="biz_name" type="text" id="biz_name" value="<?php echo get_option('msdbase_biz_name'); ?>" class="regular-text" />
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="street">Street Address:</label></th>
			<td>
				<input name="street" type="text" id="street" value="<?php echo get_option('msdbase_street'); ?>" class="regular-text" /><br />
				<input name="street2" type="text" id="street2" value="<?php echo get_option('msdbase_street2'); ?>" class="regular-text" />
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="city">City:</label></th>
			<td>
				<input name="city" type="text" id="city" value="<?php echo get_option('msdbase_city'); ?>" class="regular-text" />
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="state">State:</label></th>
			<td>
				<select name="state" id="state" class="regular-text" />
					<option>Select</option>
					<?php foreach($states AS $state => $st){ ?>
						<option value="<?php print $st; ?>"<?php print get_option('msdbase_state')==$st?' SELECTED':'';?>><?php print ucwords(strtolower($state)); ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="zip">Zip:</label></th>
			<td>
				<input name="zip" type="text" id="zip" value="<?php echo get_option('msdbase_zip'); ?>" class="regular-text" />
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="phone">Phone:</label></th>
			<td>
				<input name="main_line" type="text" id="phone" value="<?php echo get_option('msdbase_phone'); ?>" class="regular-text" />
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="fax">Fax:</label></th>
			<td>
				<input name="fax" type="text" id="fax" value="<?php echo get_option('msdbase_fax'); ?>" class="regular-text" />
			</td>
		</tr>
        </table>
        </fieldset>
	<fieldset style="border:1px solid #ddd; padding-bottom:20px; margin-top:20px;">
	<legend style="margin-left:5px; padding:0 5px; color:#2481C6;text-transform:uppercase;"><strong>Social Links</strong></legend>
		<table class="form-table">
		<tr valign="top">
			<th scope="row"><label for="twitter_user">Twitter Username</label></th>
			<td>
				<input name="twitter_user" type="text" id="twitter_user" value="<?php echo get_option('msdbase_twitter_user'); ?>" class="regular-text" />
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="latest_tweet">Display Latest Tweet</label></th>
			<td>
				<select name="latest_tweet" id="latest_tweet">		
					<option value="yes" <?php if(get_option('msdbase_latest_tweet') == 'yes'){?>selected="selected"<?php }?>>Yes</option>
                    <option value="no" <?php if(get_option('msdbase_latest_tweet') == 'no'){?>selected="selected"<?php }?>>No</option>
				</select>
			</td>
		</tr>

        <tr valign="top">
			<th scope="row"><label for="facebook_link">Facebook link</label></th>
			<td>
				<input name="facebook_link" type="text" id="facebook_link" value="<?php echo get_option('msdbase_facebook_link'); ?>" class="regular-text" />
			</td>
		</tr>
        <tr valign="top">
			<th scope="row"><label for="linkedin_link">LinkedIn link</label></th>
			<td>
				<input name="linkedin_link" type="text" id="linkedin_link" value="<?php echo get_option('msdbase_linkedin_link'); ?>" class="regular-text" />
			</td>
		</tr>
        </table>
        </fieldset>
		<p class="submit">
		<input type="submit" name="Submit" class="button-primary" value="Save Changes" />
		<input type="hidden" name="msdbase_settings" value="save" style="display:none;" />
		</p>
</form>
</div>
<?php }

//create copyright message
function msdbase_copyright($address = TRUE){
	$ret .= 'Copyright &copy;'.date('Y').' ';
	$ret .= (get_option('msdbase_biz_name')!='')?get_option('msdbase_biz_name'):get_bloginfo('name');
	if($address){
		if((get_option('msdbase_street')!='') || (get_option('msdbase_city')!='') || (get_option('msdbase_state')!='') || (get_option('msdbase_zip')!='')) {
		$ret .= '<address>';
			$ret .= (get_option('msdbase_street')!='')?get_option('msdbase_street').' ':'';
			$ret .= (get_option('msdbase_street2')!='')?get_option('msdbase_street2').' ':'';
			$ret .= (get_option('msdbase_city')!='')?get_option('msdbase_city').', ':'';
			$ret .= (get_option('msdbase_state')!='')?get_option('msdbase_state').' ':'';
			$ret .= (get_option('msdbase_zip')!='')?get_option('msdbase_zip').' ':'';
		$ret .= '</address>';
		}
		if((get_option('msdbase_phone')!='') || (get_option('msdbase_fax')!='')) {
		$ret .= '<address>';
			$ret .= (get_option('msdbase_phone')!='')?'Phone: '.get_option('msdbase_phone').' ':'';
			$ret .= (get_option('msdbase_fax')!='')?'Fax: '.get_option('msdbase_fax').' ':'';
			$ret .= '</address>';
		}
	}
	print $ret;
}
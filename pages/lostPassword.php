<?php

/*/          
 * pages/lostPassword.php
 * When the lost password item is clicked, a new randomly generated password will be sent to their parents account.
 * Similar to the one sent during the registration process.
 *
 * Usage: Imported by index when this page is requested
 *
 * Devs: Adam
 *
/*/

/* Thinking Code */
include_once('inc/lostPassword.php');

/* Rest of document just deals with displaying information not getting it */

$PAGE['title'] = "Lost password";

$PAGE['content'] .= 
'
<!-- Display confirmation here in case all ok -->
		 	{if:!empty(confirmation_message)}
			  <div id="confirmations"><ul>{confirmation_message}</ul></div>
		 	{end}

<!-- Display errors here in case there are any -->
		 	{if:!empty(error_message)}
			  <div id="errors"><ul>{error_message}</ul></div>
		 	{end}

<b>Lost password?</b>
<section class="text" style="padding-top: 15px; padding-bottom: 15px;">
<p>
Not to worry, just enter your e-mail address below and we will send you a new one!
</p>
</section>
<form action="/Bernie/p=lostPassword" method="POST" name="lostpassword">
<input type="text" placeholder="E-mail address" name="email" maxlength="16" {if:!empty(error_message)}class="error"{end}>
<input type="submit" class="small" value="GO">
</form>

';


?>

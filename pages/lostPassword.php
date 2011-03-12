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
include_once('inc/lib.php');

/* Rest of document just deals with displaying information not getting it */

$PAGE['title'] = "Lost password";

$PAGE['content'] .= 
'

<section class="text">
<b>Lost password?</b>
<p style="padding-top: 15px; padding-bottom: 15px;">
Not to worry, just enter your e-mail address below and we will send you a new one!
</p>

<form action="" method="" name="">
<input type="text" placeholder="E-mail address" name="email" maxlength="16">
<input type="submit" class="small" value="GO">
</form>
</section>
';


?>

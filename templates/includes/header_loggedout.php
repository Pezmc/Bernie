<!--

Below is the code for all variations of the header WHILE LOGGED OUT
This only works if the header is included in master.html, as it includes the onmouseover javascript.

See comments for explanations.

-->

<!-- Am using a div position absolute to display login error messages. 
  		 This is prob very bad coding - Pez let me know if you can think of a less ugly way of doing 
  		 this... 

		 Use the appropriate id for different error messages (username_error or passw_error). 
		 If error messag is displayed, the appropriate input needs to be given the class login_error
		 instead of login
		 atm all are commented out
  		 -->
  		 
	<!-------------------- NEEDS LOGIC: when to disp which error msg, if any -------------------->
	
	<!-- Email address not confirmed 
  	<div id="username_error">
		<div id="error_message">E-mail address awaiting confirmation!</div>
  	</div>
	-->

  	<!-- No such username
  	<div id="username_error">
		<div id="error_message">This user does not exist!</div>
  	</div>
	-->

	<!-- Wrong password  
  	<div id="passw_error">
		<div id="error_message">Incorrect password!</div>
  	</div>
  	-->

	<table cellspacing="0" cellpadding="0">
		<tr>
			<td class="logo" rowspan="2">
			<!-- Logo here -->
			<a href="/Bernie" alt="Go to homepage">
			<img src="testingheader/logo.png" alt="Back to homepage" />
			</a>
			</td>
			<td class="topbar" colspan="2">

			<!-- Begin the login 
			     The login is displayed if the user is logged out
			     --->

			<table>
				<tr>

				<!-------------------- NEEDS PHP: make form work -------------------->
				<form name="" action="" method="">
				
					<td class="loginbox">
					
					<!-- Enter username -->
					<input type="text" name="login_username" value="Username" maxlength="16" class="login">

					</td>
					<td class="loginbox">
					
					<!-- Enter password -->
					<input type="text" name="login_passw" value="Password" maxlength="16" class="login">

					</td>
					<td>
					<input type="submit" value="GO" class="small">
					</td>

					</form>
					
					<td>
					
					<!-- Lost password? Sign up! -->
					<section class="text">
					<a href="" alt="Lost password?">Lost password?</a>
					<br />
					<a href="?p=SignUp.html" alt="Sign up!">Sign up!</a>
					</section>
					
					</td>
				</tr>
			</table>
			
			</td>
		</tr>
		<tr>
			<td class="maincats">

			<!-- The cell for the four tabs -->
			<table>
				<tr>

					<!-- atm all links are inactive because the user has not logged in. 
					     Mouseovers still work tho
							 No logic needed in this bit
					     -->
					     
					<!-- Books -->
					<td id="cat_books" onmouseover="catMouseover('mouseover_books.png', 'cat_books')"    
												    onmouseout="catMouseout('cat_books')">
					<img src="icon_books.png" alt="Bernie books!" />
					</td>

					<!-- TV -->
					<td id="cat_tv" onmouseover="catMouseover('mouseover_tv.png', 'cat_tv')"    
												 onmouseout="catMouseout('cat_tv')">
					<img src="icon_tv.png" alt="Bernie TV!" />
					</td>

					<!-- Music -->
					<td id="cat_music" onmouseover="catMouseover('mouseover_music.png', 'cat_music')"    
														onmouseout="catMouseout('cat_music')">
					<img src="icon_music.png" alt="Bernie music!" />

					<!-- Web -->
					<td id="cat_web" onmouseover="catMouseover('mouseover_web.png', 'cat_web')"    
													onmouseout="catMouseout('cat_web')">
					<img src="icon_web.png" alt="Bernie the web!" />
					</td>
					
				</tr>
			</table>					

			</td>
			<td class="button">

			<!-- The cell for the link on the right -->
			
			<!-- Sign up -->
			<a href="?p=SignUp.html" alt="Sign up!">
			<img src="sign_up_headerbutton.png" alt="Sign up!" /></a>
			
			
			</td>
		</tr>
	</table>

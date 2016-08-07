<?php
function showContactForm() {
	?>
	<div class="space"></div>
    <div class="orangeBox"></div>
    <div id="contactBox">
		<div class="body-content">
			<br> <br>
			<div class="leftBank"><img src="Images/dropline.png"><br><br>
				<form method="POST" action="index.php?id=UploadRegister">
					<div class="contactInputs">
						<input type="text" name="contactName" placeholder="Name" size="40" required><br> 
						<input type="text" name="contactEmail" placeholder="Email" size="40" required><br> 
						<input type="text" name="contactPhone" placeholder="Telephone" required><br>
						<textarea name="contactBody" placeholder="Message" rows="14" required></textarea>
						<input type="submit" name="submit" value="SUBMIT">
					</div>
				</form>
			</div>
		</div>
	<div class="middleBank">
<img src="Images/socialMedia.png" class="contact-media">

	</div>

</div>

<div class="space"></div>
<?php
	}
	
function registerNow() {
		?>
	
	<div class="body-content">
	<div class="space"></div>
		<div>
			<form method="POST" action="index.php?id=UploadRegister">
				<div>Desired Username: <input type="text" name="username" required></div>
				<div>Desired Password: <input type="password" name="password1" required></div>
				<div>Confirm Password: <input type="password" name="password2" required></div>
				<div>FullName: <input type="text" name="fullname" required></div>
				<div>Email Address: <input type="text" name="email" required></div>
				<div>Phone Number: <input type="text" name="phone" required></div>
				<div>Address: <input type="text" name="address" required></div>
				<div><input type="submit" name="submit" value="Submit"></div>
				<div>* Please Note if your username or Email is taken you will be required to select another.</div>
			</form>
		</div>
	</div>
	
	<?php
		}
		
		
function questionPage() {
			?>
			<div class="space"></div>
		        <div class="orangeBox"></div>
				<div class="body-content">
					<div class="questionForm">
						<form method="POST" action="#" enctype="multipart/form-data">
							<table class="sunset-contact-box">
								<tr>
									<td colspan="4" class="contact-header">Questions</td>
								</tr>
								<tr>
									<td colspan="4" class="contact-subheader"><p
											style="font-size: 18px; color: #ff7e00">
											Fill in the details below,<span
												style="font-size: 18px; color: #bebebe;"> and we will contact you
												shortly.</span></td>
								</tr>
								<input type="hidden" name="post_id" id="post_id" value="55" />
								<tr>
									<td><input type="text" name="yourName" style="width: 100%;"
										placeholder="YOUR NAME *" required></td>
									<td><input type="text" name="yourEmail" style="width: 100%;"
										placeholder="YOUR EMAIL *" required></td>
									<td><input type="text" name="yourPhone" style="width: 100%;"
										placeholder="YOUR PHONE NUMBER *" required></td>
									<td><select name="subjectMatter">
											<option>Select Subject</option>
											<option>Suggestion/Idea</option>
											<option>Donation Question</option>
											<option>Request Pickup</option>
											<option>Individual Assistance</option>
											<option>Family Assistance</option>
									</select></td>
								</tr>
								<tr>
									<td colspan="4"><textarea name="comments" rows="6"
											placeholder="YOUR MESSAGE" required></textarea></td>
								</tr>
								<tr>
									<td colspan="4"><center>
											<input type="submit" name="submit" value="SEND">
										</center></td>
								</tr>
							</table>
						</form>
					</div>
				</div>
			</div>
		        <?php
			}
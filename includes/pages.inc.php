<?php
$dbConnection = databaseConnection ();

$bodyCode = new bodyClass ( $dbConnection );
$bodyCode->switchMode ();


class bodyClass {

	protected $dbConnection;
	private $setPostID;
	private $setGetID;
	
	function __construct($dbConnection) {
	
		$this->dbConnection = $dbConnection;
		
		$this->setPostID = filter_input ( INPUT_POST, 'id' );
		$this->setGetID = filter_input ( INPUT_GET, 'id' );
	}

	public function membersChoice() {
	
		echo '<div class="space"> </div>';
		echo '<div class="body-content">';
		
		echo '<div class="orangeMini"></div>';
		echo '<div id="menuOptions"><font color="black">';

		$userUsername = $_SESSION['userUsername'];
		
		if ($stmt = $this->dbConnection->prepare ( "SELECT userSupport FROM users WHERE userUsername=? " )) {
				
			$stmt->bind_param ( "i", $userUsername );
			$stmt->execute ();
			$stmt->bind_result ( $userSupport );
			$stmt->fetch ();
				
		}
		
		if ($stmt = $this->dbConnection->prepare ( "SELECT userSupport FROM users WHERE userUsername=? " )) {
		
			$stmt->bind_param ( "i", $userUsername );
			$stmt->execute ();
			$stmt->bind_result ( $userSupport );
			$stmt->fetch ();
		
		}
		
		echo '	<div class="whatItIs"></div>
				<div class="description">Accomodation</div>
				<div class="topics"></div>
				<div class="replies"></div>
				<div class="lastPost">Last Post: <br> By  <br></div>';
		
		if ($stmt = $this->dbConnection->prepare ( "SELECT accom_registered, userFullName  FROM accommodation INNER JOIN users ON accommodation.userID=users.userID ORDER BY accom_registered LIMIT 1 " )) {
		
			$stmt->execute ();
			$stmt->bind_result ( $accom_registered, $userFullName );
			$stmt->fetch ();
		
		}
		
		echo '	<div class="whatItIs"></div>
				<div class="description">Accomodation</div>
				<div class="topics"></div>
				<div class="replies"></div>
				<div class="lastPost">Last Post: <br> By  <br> </div>';
		
		if ($userSupport == 'Yes')
		{
			
			if ($stmt = $this->dbConnection->prepare ( "SELECT userSupport FROM users WHERE userUsername=? " )) {
			
				$stmt->bind_param ( "i", $userUsername );
				$stmt->execute ();
				$stmt->bind_result ( $userSupport );
				$stmt->fetch ();
			
			}
			
		echo '	<div class="whatItIs"></div>
				<div class="description">Accomodation</div>
				<div class="topics"></div>
				<div class="replies"></div>
				<div class="lastPost">Last Post: <br> By '.$userFullName.' <br> '.datChange($accom_registered).'</div>';
		}

		echo '</div>';
		echo '<div class="orangeMini"></div>';
		
		echo '<div class="space"></div>';
		echo '</div>';
	}

	public function landingPage() {

		?>
		<div class="body-content">
			<div id="thirdRow">
				<div class="services-available">
					<br>
    				<?php
					$aboutID = 2;
		
					if ($stmt = $this->dbConnection->prepare ( "SELECT aboutDescription FROM about WHERE aboutID=? " )) {
			
						$stmt->bind_param ( "i", $aboutID );
						$stmt->execute ();
						$stmt->bind_result ( $aboutDescription );
						$stmt->fetch ();
			
						echo nl2br ( $aboutDescription ) . '<br>';
					}
					?>
    			</div>
			</div>
			
				<table id="triTable">
				<tr><td class="fth1" style="cursor: pointer" onclick="location.href = 'index.php?id=KidsCorner'"></td>
					<td class="fthSpacer">&nbsp;</td>
					<td class="fth2" style="cursor: pointer" onclick="location.href = 'index.php?id=Discussions'"></td>
					<td class="fthSpacer">&nbsp;</td>
					<td class="fth3" style="cursor: pointer" onclick="location.href = 'index.php?id=TownServices'"></td>
				</tr>
				</table>
		</div>
		<div class="space"></div>
		<?php
	}
	
	public function displayFader() {
		?>
		<div class="faderTable">
			<div id="slider">
    	    	<?php
				$stmt = $this->dbConnection->prepare ( "SELECT imageName, imageHyperlink FROM fader ORDER BY imageID " );
				$stmt->execute ();
		
				$stmt->bind_result ( $imageName, $imageHyperlink );
		
				while ( $checkRow = $stmt->fetch () ) {
			
					echo '<figure><img src="Images/' . $imageName . '"  /></figure>';
				}
				?>
			</div>
		</div>
		<?php
	}
	
	public function fpSupporters() {
		?>
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.js"></script>
<link rel="stylesheet" type="text/css" href="/style.css">
<script type='text/javascript'>//<![CDATA[
		$(window).load(function(){
			var divs = $('div[id^="content"]').hide(),
    		i = 0;

			function cycle() {
    			$("#displayArea").html(divs.eq(i).html());
    			i = ++i % divs.length; // increment i, and reset to 0 when it equals divs.length
			}

			setInterval(cycle, 5000);
		});//]]> 

		</script>


<br>
<center>
	<h1>Our Supporters</h1>
</center>
<br>
<div class="supporter-background">
	<div class="body-content">
    			<?php
		$stmt = $this->dbConnection->prepare ( "SELECT companyName, companyLogo, companyHyperlink, companyDescription FROM supporters WHERE companyDescription!='' " );
		$stmt->execute ();
		
		$stmt->bind_result ( $companyName, $companyLogo, $companyHyperlink, $companyDescription );
		
		while ( $checkRow = $stmt->fetch () ) {
			echo '<div id="content" ><br>';
			echo '<div class="supportLeft"><br><br><img src="../Images/logos/' . $companyLogo . '" width="80%" /></div><div class="supporterFeed">' . $companyName . '<br>' . nl2br ( $companyDescription ) . ' <br><br>For more information visit our website at <a href="' . $companyHyperlink . '" target="_blank">' . $companyHyperlink . '</a> </div>';
			echo '</div>';
		}
		
		?>  
    			<div id="displayArea">
			<!-- switch between contentA and contentB on a timer say every 5 seconds -->
		</div>
	</div>
</div>

<div class="space"></div>
<?php
	}
	
	public function showSupporters() {
		?>

<div class="space"></div>
<div class="orangeBox"></div>
<div id="supporterRow">
	<div class="body-content">

		<div id="supporterBox">
			<br> <br><h1>Our Beloved Supporters</h1><br> <br> 
                    <?php
		$stmt = $this->dbConnection->prepare ( "SELECT companyLogo, companyName, companyHyperlink FROM supporters ORDER BY companyName" );
		$stmt->execute ();
		
		$stmt->bind_result ( $companyLogo, $companyName, $companyHyperlink );
		
		while ( $checkRow = $stmt->fetch () ) {
			
			echo '<div class="supportSet"><a id="supporters" href="' . $companyHyperlink . '" target="_blank">';
			
			if ($companyLogo == 'na.png')
				echo '<img src="Images/Logos/' . $companyLogo . '" width=250><br><br>' . $companyName . '<br><br>';
			else {
				echo '<img src="Images/Logos/' . $companyLogo . '" width=250><br><br>';
			}
			echo '</a></div>';
		}
		?>
                </div>
	</div>
</div>

<?php
	}
	
	public function showDiscussions() {
	
		?>
		<div class="space"></div>
			<div class="orangeBox"></div>

				<script type="text/javascript" src="//code.jquery.com/jquery-2.0.2.js"></script>
<script type='text/javascript'>//<![CDATA[
$(window).load(function(){
$(document).ready(function(){    
    var maxChars = 520;
    var ellipsis = "...";
    $(".article").each(function() {
        var text = $(this).find(".text.full").text();
        var html = $(this).find(".text.full").html();        
        if(text.length > maxChars)
        {            
            var shortHtml = html.substring(0, maxChars - 3) + "<span class='ellipsis'>" + ellipsis + "</span>";
            $(this).find(".text.short").html(shortHtml);            
        }
    });
    $(".read-more").click(function(){        
        var readMoreText = "ReadMore";
        var readLessText = "Hide";        
        var $shortElem = $(this).parent().find(".text.short");
        var $fullElem = $(this).parent().find(".text.full");        
        
        if($shortElem.is(":visible"))
        {           
            $shortElem.hide();
            $fullElem.show();
            $(this).text(readLessText);
        }
        else
        {
            $shortElem.show();
            $fullElem.hide();
            $(this).text(readMoreText);
        }       
    });
});
});//]]> 

</script>
			<div id="full-width">
				<div class="body-content">

					<div id="blogBox">
						<br> <br><br> <br><h1>Experiences</h1><br> <br> 
                    	<?php
						$stmt = $this->dbConnection->prepare ( "SELECT blogBody, blogDate, blogSubject,  blogAnonymous, userFullName FROM blog INNER JOIN users ON users.userID=blog.userID ORDER BY blogDate LIMIT 3" );
						$stmt->execute ();
		
						$stmt->bind_result ( $blogBody, $blogDate, $blogSubject, $blogAnonymous, $userFullName );
		
						while ( $checkRow = $stmt->fetch () ) {
			
							if ($blogAnonymous == "Yes") {

								echo '<div class="blogEntry">Anonymous<br>' . datChange ( $blogDate ), '  ::  ' . $blogSubject, '<br></div>';
							
				
							} else {
								echo '<div class="blogEntry">' . $userFullName . '<br>' . datChange ( $blogDate ), '  ::  ' . $blogSubject, '<br></div>';
							
							}
							
							?><div class="article">
							<div class="text short"></div>
							<div class="text full">
								<?php echo $blogBody; ?>							
						
							</div>
							<span class="read-more">ReadMore</span>
							</div>
							<?php 
						}
						?>
                	</div>
				</div>
			</div>

			<?php
	}
	
	public function showTownServices() {
		?>

<div id="full-width">
	<div class="body-content">
		<div id="thirdRow">
			<div class="services-available">
				<br>
    			<?php
		$aboutID = 2;
		
		if ($stmt = $this->dbConnection->prepare ( "SELECT aboutDescription FROM about WHERE aboutID=? " )) {
			
			$stmt->bind_param ( "i", $aboutID );
			$stmt->execute ();
			$stmt->bind_result ( $aboutDescription );
			$stmt->fetch ();
			
			echo nl2br ( $aboutDescription ) . '<br>';
			$stmt->close ();
		}
		?>
    			</div>
		</div>

		<div id="blogBox">

			<div>
				<table width=100% border=0 cellspacing=0 cellpadding=10>

        <?php
		$stmt = $this->dbConnection->prepare ( "SELECT serviceID, serviceName, serviceImage, serviceImage1, serviceFrontDescription FROM services ORDER BY serviceID " );
		$stmt->execute ();
		
		$stmt->bind_result ( $serviceID, $serviceName, $serviceImage, $serviceImage2, $serviceFrontDescription );
		
		while ( $checkRow = $stmt->fetch () ) {
			?>
			<tr>
						<td width=288 align=right><a
							href="index.php?id=Services&&serviceID=<?php echo $serviceID; ?>"><img
								src="Images/<?php echo $serviceImage; ?>"
								onmouseover="this.src='Images/<?php echo $serviceImage2; ?>'"
								onmouseout="this.src='Images/<?php echo $serviceImage; ?>'" /></a></td>
						<td height=45 valign="top"><font color="white"><?php echo $serviceName; ?></font><br>
			<?php echo $serviceFrontDescription; ?></td>
					</tr>
			<?php
		}
		?>
				</table>
			</div>
			<div class="space"></div>
		</div>
	</div>
</div>
<div class="space"></div>

<?php
	}
	
	public function showKidsCorner() {
	
		?>
		<div class="body-content">
			<div class="space"></div>
				<center><h1>Kids Corner</h1></center>
				<div id="thumbwrap">
				<?php
		
				if ($handle = opendir ( 'Images/kidscorner/' )) {
					while ( false !== ($entry = readdir ( $handle )) ) {
						if ($entry != "." && $entry != "..") {
					
							?><a class="thumb" href="#"><img src="../Images/kidscorner/<?php echo $entry; ?>" alt="" width=150> <span><img src="../Images/kidscorner/<?php echo $entry; ?>" alt="" width=350></span></a><?php
						}
					}
					closedir ( $handle );
				}
				?>
				</div>
		</div>
		<br>

		<div class="space"></div>

		<?php
	}
	
	public function familyCookBook() {
		
		echo '<div class="space"></div>';
		echo '<div class="body-content"><br><br>';
		
		$stmt = $this->dbConnection->prepare ( "SELECT cookbookID, cookbookImage, cookbookName FROM cookbook " );
		$stmt->execute ();
		
		$stmt->bind_result ( $cookbookID, $cookbookImage, $cookbookName );
		
		while ( $checkRow = $stmt->fetch () ) {
			
			echo '<div class="threeRow"><br><a style="color: #bebebe; text-decoration: underline;" href="index.php?id=ShowBook&&cookbookID=' . $cookbookID . '"><img src="Images/cookbook/' . $cookbookImage . '" width=300></a><br><br>' . $cookbookName . '<br><br><a style="color: #bebebe; text-decoration: underline;" href="index.php?id=ShowBook&&cookbookID=' . $cookbookID . '">READ MORE</a></div>';
		}
		
		echo '</div>';
		
		echo '<div class="space"></div>';

	}
	
	public function showFaq() {
		
		echo '<div class="space"></div>';
		echo '<div class="orangeBox"></div>';
		echo '<div class="body-content">';
		echo '<br><br><br><br>';
		
		echo '<center><h1>Frequently Asked Questions</h1></center>';
		echo '<br><br><br><br>';
		
		$stmt = $this->dbConnection->prepare ( "SELECT faqQuestion, faqAnswer FROM faq " );
		$stmt->execute ();
		
		$stmt->bind_result ( $faqQuestion, $faqAnswer );
		
		while ( $checkRow = $stmt->fetch () ) {
			
			echo '<div class="faqQ"><br><br>Q: ' . $faqQuestion . '</div>';
			echo '<div class="faqA"><br><br>A: ' . $faqAnswer . '</div>';
			
			echo '<div><br><br><a href="?id=Faq">Back to top</a></div>';
		}
		
		echo '</div>';
		?>
	
		<div class="space"></div>

		<?php
	}
	
	public function showServices() {
		
		$serviceID = filter_input ( INPUT_GET, 'serviceID' );
		?>

		<div class="space"></div>
		<div class="body-content">
		
		<?php
		
		if ($stmt = $this->dbConnection->prepare ( "SELECT serviceID, serviceName, serviceImage1, serviceDescription FROM services WHERE serviceID=? " )) {
			
			$stmt->bind_param ( "i", $serviceID );
			$stmt->execute ();
			$stmt->bind_result ( $serviceID, $serviceName, $serviceImage, $serviceDescription );
			$stmt->fetch ();
			
			echo '<div class="leftBank"><img style="vertical-align: middle;" src="Images/' . $serviceImage . '"></div><div> <h1>' . $serviceName . '</h1><br>' . nl2br ( $serviceDescription ) . '</div>';
		}
		?>
		
		
		</div>
		<div class="space"></div>
		<?php
	}
	
	public function showResources() {
		
		?>
		<div class="space"></div>
			<div class="body-content">
				<center><h1>Resource Files</h1></center>
				<br>
				<hr>
				<br>
				<?php 
				if ($handle = opendir('files/')) {
    				while (false !== ($entry = readdir($handle))) {
        				if ($entry != "." && $entry != "..") {
            				echo '<a href="files/'.$entry.'" download>'.$entry.'<br>';
        				}
   					 }
    				closedir($handle);
				}
				?>
				
				<br><br><br><br><br><br><center><h1>Resource Links</h1></center>
				<br>
				<hr>
		
				<?php
		
				$stmt = $this->dbConnection->prepare ( "SELECT resourceName, resourceLink FROM resources " );
				$stmt->execute ();
		
				$stmt->bind_result ( $resourceName, $resourceLink );
		
				while ( $checkRow = $stmt->fetch () ) {
			
					echo '<div class="padder"><a id="supporters" href="' . $resourceLink . '" target="_blank">' . $resourceName . '</a></div>';
				}
		
				?>
		
			</div>
		<div class="space"></div>
		<?php
	}

	public function showCookBook() {
		
		echo '<div class="space"></div>';
		echo '<div class="body-content">';
		$cookbookID = filter_input ( INPUT_GET, 'cookbookID' );
		
		if ($stmt = $this->dbConnection->prepare ( "SELECT cookbookName, cookbookImage, cookbookIngredient1, cookbookIngredient2, cookbookIngredient3, cookbookIngredient4, cookbookIngredient5, cookbookIngredient6, cookbookIngredient7, cookbookIngredient8, cookbookIngredient9, cookbookIngredient10, cookbookIngredient11, cookbookDescription FROM cookbook WHERE cookbookID=? " )) {
			
			$stmt->bind_param ( "i", $cookbookID );
			$stmt->execute ();
			$stmt->bind_result ( $cookbookName, $cookbookImage, $cookbookIngredient1, $cookbookIngredient2, $cookbookIngredient3, $cookbookIngredient4, $cookbookIngredient5, $cookbookIngredient6, $cookbookIngredient7, $cookbookIngredient8, $cookbookIngredient9, $cookbookIngredient10, $cookbookIngredient11, $cookbookDescription );
			$stmt->fetch ();
			
			$ingredientArray = array (
					$cookbookIngredient1,
					$cookbookIngredient2,
					$cookbookIngredient3,
					$cookbookIngredient4,
					$cookbookIngredient5,
					$cookbookIngredient6,
					$cookbookIngredient7,
					$cookbookIngredient8,
					$cookbookIngredient9,
					$cookbookIngredient10,
					$cookbookIngredient11 
			);
			?>

			<div><h1><?php echo $cookbookName; ?></h1></div>

			<div><br><?php echo '<img src="Images/cookbook/'.$cookbookImage.'">'; ?></div>

			<div><br><?php
			foreach ( $ingredientArray as $value ) {
				
				if ($value)
				echo ' - '.$value . '<br>';
			}
			
			?></div>
			<div><br><br><h1>Directions</h1><br><br><?php echo nl2br($cookbookDescription); ?></div>

			<?php
			$stmt->close ();
		}
		
		echo '</div>';

		echo '<div class="space"></div>';
	}
	
	public function switchMode() {
		
		$localAction = NULL;
		
		if (isset ( $this->setPostID )) {
			$localAction = $this->setPostID;
		} elseif (isset ( $this->setGetID )) {
			$localAction = urldecode ( $this->setGetID );
		}
		
		Switch (strtoupper ( $localAction )) {
	
			case "WISHLIST":
			    wishlist();
			    break;
			case "SHOWBOOK" :
				$this->showCookBook ();
				break;
			case "RESOURCES" :
				$this->showResources ();
				break;
			case "SERVICES" :
				$this->showServices ();
				break;
			case "FAQ" :
				$this->showFaq ();
				break;
			case "COOKBOOK" :
				$this->familyCookBook ();
				break;
			case "TOWNSERVICES" :
				$this->showTownServices ();
				break;
			case "KIDSCORNER" :
				$this->showKidsCorner ();
				break;
			case "DISCUSSIONS" :
				$this->showDiscussions ();
				break;
				case "SUPPORTERS" :
					$this->showSupporters ();
					break;
					case "CONTACT" :
						showContactForm ();
						break;
				/*
				 * Authentication functions in the switch added from the require once dbutils.php
				 * 
				 */
			case "PROCESSLOGIN" :
				processMembersLogin ();
				break;
			case "UPLOADREGISTER" :
				processRegister ();
				break;
			case "MEMBERS" :
				$this->membersChoice ();
				break;
				case "LOGOUT" :
					session_destroy ();
					echo '<font color=black><b>Please Wait!!!!<br>';
					echo '<meta http-equiv="refresh" content="1;url=index.php">';
					break;
			case "REGISTER" :
				registerNow ();
				break;
		

			
		
			default :
				$this->landingPage ();
				$this->fpSupporters ();
		}
		?>

        <?php
	}
}



<?php
// THIS CODE IS OLD AND ONLY PURPOSE TO ANALYSE FOR FUTURE PROJECTS
session_destroy();
ob_start();
//connectie maken met de databank
require_once("includes/dbconn.inc.php");

//function Redirect($url, $permanent = false)
//{
 //   header('Location: ' . $url, true, $permanent ? 301 : 302);

 //   exit();
//}



//sessie starten

session_start();


//testen of er op de knop werd gedrukt
if (isset ($_POST["button"])) {
   //ingevulde gegevens in lokale variabelen 
   $gebruikersnaam = $_POST["gebruikersnaam"];
   $wachtwoord = $_POST["wachtwoord"];	
   
   //testen of gebruikersnaam en wachtwoord correct zijn
   $qrySelectLid = "SELECT BezoekerID, e_mail 
                    FROM tblBezoeker
                    WHERE gebruikersnaam=? AND 
                          wachtwoord=?";
   //voorbereiden prepared statement
   if ($stmt = mysqli_prepare($dbconn, $qrySelectLid))
   {
	  //onbekende waarden in query binden dmv parameters
	  mysqli_stmt_bind_param($stmt, "ss", $gebruikersnaam, 
	  $wachtwoord);
	  //query laten uitvoeren
	  mysqli_stmt_execute($stmt);
	  //verkregen resultaten van de query binden aan lokale 
	  //variabelen
	  mysqli_stmt_bind_result($stmt, $BezoekerID, $e_mail);
	  //verkregen resultaten opslaan
	  mysqli_stmt_store_result($stmt);
	  //bij 1 record onmiddelijk fetch
	  mysqli_stmt_fetch($stmt);
	  //aantal records oprvagen
	  $aantal = mysqli_stmt_num_rows($stmt);
	  
	  //statement niet meer nodig
	  mysqli_stmt_close($stmt);
	  //databank connectie niet meer nodig
	  mysqli_close($dbconn);   
	   
	   
	  
	  //testen of login gelukt is
	  if ($aantal == 1) {
		 $_SESSION["gebruikersnaam"] = $gebruikersnaam;
		
		$_SESSION["wachtwoord"] = $wachtwoord;
		  $_SESSION["BezoekerID"] = $BezoekerID;
		  $_SESSION["e_mail"] = $e_mail;
		  
		 // $message = "U bent ingelogd(deze pop-up is een tijdelijke vervanging van de doorverwijzing naar succes.php)";
		header("location: succes.php");
		  
		  //Redirect('http://devosa.slc-mul.be/succes.php', false);
		  
	  } else {
		 $foutmelding ="Gebruikersnaam of wachtwoord niet 
		                correct";
		   //session_status(true)
	  }
	  
   }
   
}

$count=mysqli_num_rows($result);

// If result matched $username and $password, table row must be 1 row
if($count==1){
    session_start();
    $_SESSION['loged'] = true;
    $_SESSION['username'] = $username;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="Fictief festival over model en lego bouw">
    <meta name="keywords" content="festival gip school little universe official creative fest fun cool">
    <title>Little universe</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i%7cMontserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <!-- Style -->
    <link href="css/style.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js "></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js "></script>
<![endif]-->
</head>

<body>
<div class="header">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<a href="index.php"><img src="images/logo.png" width="80" height="94" alt="little universe logo"></a>
				</div>
				<div class="col-lg-8 col-md-4 col-sm-12 col-xs-12">
					<div class="navigation">
						<div id="navigation">
							<ul>
								<li class="active"><a href="index.php" title="Home">Home</a>
								</li>
								<li class="has-sub"><a href="service-list.php" title="Service List">Tickets</a>
									<ul>
										<li><a href="service-list.php" title="Service List">Dag tickets</a>
										</li>
										<li><a href="service-detail.php" title="Service Detail">Bundle list</a>
										</li>
									</ul>
								</li>
								<li class="has-sub"><a href="https://littleuniversegip.wordpress.com" title="Blog " target="_blank">News</a>
									<ul>
										<li><a href="https://littleuniversegip.wordpress.com" title="Blog" target="_blank">Onze blog</a>
										</li>
										<li><a href="zones.php" title="Blog">De zones</a>
										</li>

									</ul>
								</li>
								<li><a href="#" title="Features">Handige info</a>
									<ul>
										<li><a href="testimonial.php" title="Service List">Regels camping</a>
										</li>
										<li><a href="regel.php" title="Service Detail">Wij staan voor je klaar!</a>
										</li>
									</ul>
								</li>
								<li><a href="contact.php" title="Contact Us">Contact</a> </li>

							</ul>
							<li>
					<?php if (isset($_SESSION['loged']) && $_SESSION['loged'] == 2) {
    echo "Welkom, " . $_SESSION['gebruikersnaam'] . "!" . " <br>";
		echo "<a href=logout.php>Log uit</a>" ;
} else {
    echo "Guest";
}
										
													

							
	?></li>
							</li>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
    <div class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<h2 class="hero-title">Log hier in</h2>
                    <form class="form-group"  name="login" id="login" method="post" action="">
  			<label class="hero-text" for="gebruikersnaam">gebruikersnaam:</label><br>
  			<input type="text" name="gebruikersnaam" id="gebruikersnaam"
  				required><br>
  			<label class="hero-text" for="wachtwoord">wachtwoord:</label><br>
  			<input type="password" name="wachtwoord" id="wachtwoord" 
  			required><br><br>
  			<input type="submit" name="button" id="button" 
  			value="aanmelden" >
						
  		
						<div class="container">
							
						<p class="hero-text"><?php echo $foutmelding; ?></p>
						</div>
</form>
			<a href="register.php">
   				<button>registreer</button>
							</a>	
            </div>
        </div>
    </div>
	</div>
<div class="footer">
        <!-- footer-->
        <div class="container">
            <div class="footer-block">
                <!-- footer block -->
                 <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="footer-widget">
                            <h2 class="widget-title">Festival Adres</h2>
                            <ul class="listnone contact">
                                <li><i class="fa fa-map-marker"></i> Havenkaai 9999 Infinity Street 1, Antwerpen 2000 </li>
                                <li><i class="fa fa-phone"></i> +00 (800) 123-4567</li>
                                <li><i class="fa fa-fax"></i> +00 (123) 456 7890</li>
                                <li><i class="fa fa-envelope-o"></i> info@littleuniverse.com</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="footer-widget footer-social">
                            <!-- social block -->
                            <h2 class="widget-title">Social Feed</h2>
                            <ul class="listnone">
                                <li>
                                    <a href="#"> <i class="fa fa-facebook"></i> Facebook </a>
                                </li>
                                <li><a href="#"><i class="fa fa-twitter"></i> Twitter</a></li>
                                <li><a href="#"><i class="fa fa-google-plus"></i> Google Plus</a></li>
                                <li><a href="#"><i class="fa fa-linkedin"></i> Linked In</a></li>
                                <li>
                                    <a href="#"> <i class="fa fa-youtube"></i>Youtube</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.social block -->
                    </div>
                     <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                        <div class="footer-widget widget-newsletter">
                            <!-- newsletter block -->
                            <h2 class="widget-title">Nieuws</h2>
                            <p>Vul uw e-mail hier in en ontvang meer info over ons</p>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Email Address">
                                <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Abonneer</button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </div>
                        <!-- newsletter block -->
                    </div>
                </div>
                <div class="tiny-footer">
                    <!-- tiny footer block -->
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="copyright-content">
                                <p>© Little universe 2018| all rights reserved</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.tiny footer block -->
            </div>
            <!-- /.footer block -->
        </div>
    </div>
    <!-- /.footer-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/menumaker.js"></script>
    <!-- sticky header -->
    <script src="js/jquery.sticky.js"></script>
    <script src="js/sticky-header.js"></script>
</body>

</html>

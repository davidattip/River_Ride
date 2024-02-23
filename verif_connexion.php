<?php

if (!isset($_POST["email"]) || empty($_POST["email"]) || !isset($_POST["mdp"]) || empty($_POST["mdp"]) ) {
	header('location: connexion.php?message=Veuillez remplir les champs indiqués');
	exit;
}

include ('includes/db.php');


$q = 'SELECT * FROM users WHERE email = :email';

$req = $bdd -> prepare($q);

$req->execute([
	'email' => $_POST['email']
]);

$users = $req->fetchAll(PDO::FETCH_ASSOC);

if($users[0]['password'] !=  hash('sha256',$_POST['mdp'])  ){
	header('location:connexion.php?message=Identifiants incorrects');
	exit;
}

if($users[0]['is_valid'] !=  1  ){
	header('location:connexion.php?message=votre compte n\'est pas vérifié. veuillez consulter vos mails');
	$confirmed_key = $users[0]['confirmed_key'];
    header('location: connexion.php?message=Votre mail n\'est pas confirmé, mail réenvoyé');

    //Envoie de mail de confirmation encore

    include("includes/phpmailer.php");

    $objet = "confirmation de compte" ;
    $message = "Bonjour veuillez vérifier votre compte avec ce lien : https://bodytonic.site/verif_mail.php?key=" . $confirmed_key;
    $destinataire = $_POST["email"];

    sendmail($message, $objet, $destinataire);

	
	exit;
}


$q = 'SELECT role FROM users WHERE email = :email';

$req = $bdd -> prepare($q);

$req->execute([
	'email' => $_POST['email']
]);

$role = $req->fetch();

session_start();

$_SESSION['id'] = $users[0]['id'];
$_SESSION['role'] = $role['role'];

if($_SESSION['role'] == "admin"){
	header('location:admin.php');

}else if ($_SESSION['role'] == "coach") {
	header('location:home_coach.php');
}else{
	header('location:index.php');
}

?>


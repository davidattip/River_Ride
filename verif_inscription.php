<?php
    $key=""; //Création de la clé aléatoire
    for($i=1; $i<12; $i++){
        $key=$key.mt_rand(0,9);
    }
    
    
    //Fin création de la clé

    var_dump($_POST['nom']);

    if (!isset($_POST['nom']) || empty($_POST['nom']) || !isset($_POST['prenom']) || empty($_POST['prenom']) || !isset($_POST['dn']) || empty($_POST['dn']) || !isset($_POST['email']) || empty($_POST['email']) || !isset($_POST['mdp']) || empty($_POST['mdp'])) {
        header('location:inscription.php?message=Tout les champs n\'ont pas été renseignés.');
        exit;
    }

    var_dump($_POST['nom']);

    if(strlen($_POST['mdp']) < 8 ){
		header('location:inscription.php?message=Le mot de passe doit faire au minimum 8 caractères.'); 
        exit;
    }

    if(!preg_match('/[A-Z]/', $_POST['mdp']) ){
		header('location:inscription.php?message=Le mot de passe doit contenir une majuscule.');
        exit;
	}

	if(!preg_match('/[a-z]/', $_POST['mdp']) ){
		header('location:inscription.php?message=Le mot de passe doit contenir une minuscule.');
        exit;
    }

    if(!preg_match('/[0-9]/', $_POST['mdp']) ){
		header('location:inscription.php?message=Le mot de passe doit contenir un chiffre.');
        exit;
    }

    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {

        header('location:inscription.php?message= Email invalide. ');
        exit;
	}

    include('includes/db.php');

	$q = 'SELECT email FROM users WHERE email = :email';

    $req = $bdd ->prepare($q);

    $req->execute([
    				'email' => $_POST['email']
	]);

	if($req->rowcount() > 0){
            header('location:inscription.php?message=L\'email est deja utilisé.');
            exit;
	}

    $q="INSERT INTO users (nom, prenom, date, email, password, confirmed_key) VALUES (:nom, :prenom, :dn, :email, :mdp, :key)";

    $req = $bdd-> prepare($q);

    $result = $req ->execute ([
    						'nom' =>($_POST['nom']),
                            'prenom' =>($_POST['prenom']),
                            'dn' =>($_POST['dn']),
                            'email' =>($_POST['email']),
                            'mdp' =>  hash('sha256',$_POST['mdp']),
                            'key' => $key,
                            ]);
                    
    if(!$result){
        header('location:inscription.php?message=Echec lors de l\'inscription');
        exit;
    }
    include("includes/phpmailer.php");
    $objet = "confirmation de compte" ;
    $message = "Bonjour veuillez vérifier votre compte avec ce lien : http://localhost/river_ride/verif_mail.php?key=" . $key;
    $destinataire = $_POST["email"];

    sendmail($message, $objet, $destinataire);

    header('location:connexion.php?message=Étape créée avec succès. Veuillez vérifier vos e-mail.');
    exit;
    
    session_start();

    $_SESSION['id']=$users[0]['id'];
    
	header('location:index.php');
	exit;

  ?>










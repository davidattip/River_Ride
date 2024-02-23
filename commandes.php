<?php

/*function ajouterUser($nom, $prenom, $email, $motdepasse)
{
  if(require("includes/db.php"))
  {
    $req = $access->prepare("INSERT INTO utilisateurs (nom, prenom, email, motdepasse) VALUES (?, ?, ?, ?)");

    $req->execute(array($nom, $prenom, $email, $motdepasse));

    return true;

    $req->closeCursor();
  }
}
*/
// function getUsers($email, $password){
  
//   if(require("connexion.php")){

//     $req = $access->prepare("SELECT * FROM utilisateur ");

//     $req->execute();

//     if($req->rowCount() == 1){
      
//       $data = $req->fetchAll(PDO::FETCH_OBJ);

//       foreach($data as $i){
//         $mail = $i->email;
//         $mdp = $i->motdepasse;
//       }

//       if($mail == $email AND $mdp == $password)
//       {
//         return $data;
//       }
//       else{
//           return false;
//       }

//     }

//   }

// }
function modifier($image, $nom, $prix, $desc, $id)
{
  if(require("includes/db.php"))
  {
    $req = $bdd->prepare("UPDATE packs SET `image` = ?, nom = ?, prix = ?, description = ? WHERE id=?");

    $req->execute(array($image, $nom, $prix, $desc, $id));

    $req->closeCursor();
  }
}

function afficherUnProduit($id)
{
	if(require("includes/db.php"))
	{
		$req=$bdd->prepare("SELECT * FROM packs WHERE id=?");

        $req->execute(array($id));

        $data = $req->fetchAll(PDO::FETCH_OBJ);

        return $data;

        $req->closeCursor();
	}
}

function reserverProduit($id)
{
	if(require("includes/db.php"))
	{
        $user_id = $_SESSION['id'];
		$req=$bdd->prepare("UPDATE packs SET reserve = 1, id_user = :user_id WHERE id = :id");

        $req->bindParam(":id", $id);
        $req->bindParam(":user_id", $user_id);

        $req->execute();


        $req->closeCursor();
	}
}

  function ajouter($image, $nom, $prix, $desc)
  {
    if(require("includes/db.php"))
    {
      $req = $bdd->prepare("INSERT INTO packs (image, nom, prix, description) VALUES (?, ?, ?, ?)");

      $req->execute(array($image, $nom, $prix, $desc));

      $req->closeCursor();
    }
  }

function afficher()
{
	if(require("includes/db.php"))
	{
		$req=$bdd->prepare("SELECT * FROM packs ORDER BY id DESC");

        $req->execute();

        $data = $req->fetchAll(PDO::FETCH_OBJ);

        return $data;

        $req->closeCursor();
	}
}


function afficherproduitreserve()
{
	if(require("includes/db.php"))
	{
		$req=$bdd->prepare("SELECT * FROM packs WHERE reserve = FALSE ORDER BY id DESC");

        $req->execute();

        $data = $req->fetchAll(PDO::FETCH_OBJ);

        return $data;

        $req->closeCursor();
	}
}

function supprimer($id)
{
	if(require("includes/db.php"))
	{
		$req=$bdd->prepare("DELETE FROM packs WHERE id=?");

		$req->execute(array($id));

		$req->closeCursor();
	}
}

/*function getAdmin($email, $password){
  
  if(require("includes/db.php")){

    $req = $access->prepare("SELECT * FROM admin WHERE id=33");

    $req->execute();

    if($req->rowCount() == 1){
      
      $data = $req->fetchAll(PDO::FETCH_OBJ);

      foreach($data as $i){
        $mail = $i->email;
        $mdp = $i->motdepasse;
      }

      if($mail == $email AND $mdp == $password)
      {
        return $data;
      }
      else{
          return false;
      }

    }

  }

}*/
?>
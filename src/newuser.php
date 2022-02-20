<?php

require_once('./inc/init.php');

// echo '<pre>';
// print_r($_POST);
// echo '</pre>';

if (isConnected()) {
    header('location: index.php');
}


if(isset($_POST['password'],$_POST['confirm_password'])){
 if($_POST['password'] != $_POST['confirm_password']){
    $errpassword = '<p class="text-danger"> Mot de passe incorrect</p>';
    $error = true;
 }else {
     $passord = password_hash($_POST['password'], PASSWORD_DEFAULT);
 }
}

if(isset($_POST['email']))
{
    if(!validateInput('email', $_POST['email']))
    {
        $errEmail = '<p class="text-danger">L\'adresse email est considérée comme invalide.</p>';
        $error = true;
    }
}

if (isset($_POST['name'], $_POST['prenom'],$_POST['email'],$_POST['password']) && !$error) {
    $reqInsert = $bdd->prepare("INSERT INTO user (pseudo, email,password,name,prenom) VALUES (:pseudo, :email,:password,:name,:prenom )");
    $reqInsert->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
    $reqInsert->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
    $reqInsert->bindValue(':password', $_POST['password'], PDO::PARAM_STR);
    $reqInsert->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
    $reqInsert->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);


    $reqInsert->execute();

    if ($reqInsert->rowCount()) {
        $_SESSION['msggNewUser'] = '<p class="alert alert-success p-2 text-center">Bienvenu dans notre site <br> Connectez-vous</p>';
        header('location: connexion.php');
        
    } else {
        $erreur = '<p class="alert alert-danger p-2 text-center">L\'identifiant ou le mot de passe est incorrect.</p>';
    }
}


// if (isset($_GET['action']) && $_GET['action'] == 'deconnexion') {

//     unset($_SESSION['user']);
//     header('location: connexion.php');
// }


require_once('./inc/header.inc.php');
require_once('./inc/nav.inc.php');

?>

<h1 class="text-center">Inscription</h1>


<form class="col-8 mx-auto my-5" method="POST">
   <div class="d-flex justify-content-between">
   <div class="mb-3 col-5">
        <label for="nom" class="form-label">Nom</label>
        <input type="text" name="name" class="form-control" id="nom" aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
    </div>
    <div class="mb-3 col-5">
        <label for="prenom" class="form-label">Prénom</label>
        <input type="text" name="prenom" class="form-control" id="prenom" aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
    </div>
   </div>
    <div class="mb-3">
        <label for="pseudo" class="form-label">Pseudo</label>
        <input type="text" name="pseudo" class="form-control" id="pseudo" aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="text" name="email" class="form-control" id="email" aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text"><?php if(isset($errEmail)) echo $errEmail ?></div>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" name="password" class="form-control" id="password">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Confirmation du motde passe</label>
        <input type="password" name="confirm_password" class="form-control" id="password">
        <div id="emailHelp" class="form-text"><?php if(isset($errpassword)) echo $errpassword ?></div>
    </div>

    <button type="submit" class="btn btn-primary btn-md">Enregistrer</button>
</form>

<?php
require_once('./inc/footer.inc.php');

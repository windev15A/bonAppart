<?php

require_once('./inc/init.php');

// echo '<pre>';
// print_r($_POST);
// echo '</pre>';

if (isConnected()) {
    header('location: index.php');
}

if (isset($_POST['pseudo'], $_POST['password'])) {
    $reqEmail = $bdd->prepare("SELECT * FROM user WHERE pseudo=:pseudo OR email=:email");
    $reqEmail->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
    $reqEmail->bindValue(':email', $_POST['pseudo'], PDO::PARAM_STR);

    $reqEmail->execute();

    if ($reqEmail->rowCount()) {
        $user = $reqEmail->fetch(PDO::FETCH_ASSOC);

        if (password_verify($_POST['password'], $user['password'])) {
            foreach ($user as $key => $value) {
                if ($key != 'password') {
                    $_SESSION['user'][$key] = $value;
                }
            }
            header('location: index.php');
        } else {
            $erreur = '<p class="alert alert-danger p-2 text-center">L\'identifiant ou le mot de passe est incorrect.</p>';
        }
    } else {
        $erreur = '<p class="alert alert-danger p-2 text-center">L\'identifiant ou le mot de passe est incorrect.</p>';
    }
}


    if(isset($_GET['action']) && $_GET['action']== 'deconnexion'){

        unset($_SESSION['user']);
        header('location: connexion.php');

    }


require_once('./inc/header.inc.php');
require_once('./inc/nav.inc.php');

?>

<h1 class="text-center">Connexion</h1>
<?php if (isset($erreur)) echo $erreur; ?>

<form class="col-6 mx-auto my-5" method="POST">
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email Ou Pseudo</label>
        <input type="text" name="pseudo" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Mot de passe</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1">
    </div>

    <button type="submit" class="btn btn-primary">Connecter</button>
</form>



<?php
require_once('./inc/footer.inc.php');

<?php
require_once('./inc/init.php');
// echo '<pre>';
// print_r($_POST);
// echo '</pre>';

if (isset($_POST['title']) && strlen($_POST['title']) < 10) {
    $titleErreur = '<p class="text-danger py-2">Le titre doit avoir au moins 10 caractéres !</p>';
    $erreur = true;
}
if (isset($_POST['postal_code']) && !preg_match ("~^[0-9]{5}$~",$_POST['postal_code'])){
    $postalErreur = '<p class="text-danger py-2">Code postal non conforme  !</p>';
    $erreur = true;
}
          




if (isset($_POST['title'], $_POST['description'], $_POST['postal_code'], $_POST['city'], $_POST['type'], $_POST['price']) && !isset($erreur) ) {

    $reqInsert = $bdd->prepare("INSERT INTO advert (title, description, postal_code, city, type, price) VALUES (:title, :description, :postal_code, :city, :type, :price)");

    $reqInsert->bindValue(':title', $_POST['title'], PDO::PARAM_STR);
    $reqInsert->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
    $reqInsert->bindValue(':postal_code', $_POST['postal_code'], PDO::PARAM_STR);
    $reqInsert->bindValue(':city', $_POST['city'], PDO::PARAM_STR);
    $reqInsert->bindValue(':type', $_POST['type'], PDO::PARAM_STR);
    $reqInsert->bindValue(':price', $_POST['price'], PDO::PARAM_STR);

    if ($reqInsert->execute()) {
        $messageInsert = '<p class="alert alert-success py-2 text-center">Votre annonce a été bien enregistré !</p>';

        $_SESSION['message'] = $messageInsert;
        header('location:index.php');
    }
}


require_once('./inc/header.inc.php');
require_once('./inc/nav.inc.php');
?>


<div class="py-5 text-center">
    <h2>Nouvelle annonce</h2>
</div>

<div class="row g-5">

    <div class="col-md-7 col-lg-8 mx-auto">

        <form class="needs-validation" method="POST">
            <div class="row g-3">
                <div class="col">
                    <label for="title" class="form-label">Titre</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Titre de l'annonce">

                    <smal>
                        <?php if (isset($titleErreur)) echo $titleErreur ?>
                    </smal>

                </div>


                <div class="col-12">
                    <label for="Description" class="form-label">Description</label>
                    <div class="input-group">
                        <textarea class="form-control" name="description" id="Description" placeholder="Description de l'annonce"></textarea>

                    </div>
                </div>


                <div class="col-md-6">
                    <label for="price" class="form-label">Prix</label>
                    <input type="text" class="form-control" name="price" id="price" placeholder="Prix" name="price">

                </div>
                <div class="col-md-6 mx-auto">
                    <label for="state" class="form-label">Type </label>
                    <select class="form-select" id="state" name="type">
                        <option value="">Choisir un type </option>
                        <option value="location">Location</option>
                        <option value="vente">Vente</option>
                    </select>

                </div>

                <div class="col-md-6">
                    <label for="postal_code" class="form-label">Code postal</label>
                    <input type="text" class="form-control" id="postal_code" placeholder="Code postal" name="postal_code">
                    <smal>
                        <?php if (isset($postalErreur)) echo $postalErreur ?>
                    </smal>

                </div>
                <div class="col-md-6">
                    <label for="city" class="form-label">Ville</label>
                    <input type="text" class="form-control" name="city" id="city" placeholder="Ville">

                </div>
            </div>


            <button class="w-100 btn btn-primary btn-lg my-3" type="submit">Enregistrer</button>
        </form>
    </div>


    <?php
    require_once('./inc/footer.inc.php');
    ?>
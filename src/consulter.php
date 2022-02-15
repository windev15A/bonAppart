<?php
require_once('./inc/init.php');
// echo '<pre>';
// print_r($bdd);
// echo '</pre>';

if (isset($_GET['id'])) {
    $reqData = $bdd->prepare("SELECT * FROM advert WHERE id= :id");
    $reqData->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    $reqData->execute();
    $datas = $reqData->fetch(PDO::FETCH_ASSOC);

    if (empty($datas)) {

        $_SESSION['message'] = "<p class='alert alert-warning py-2 text-center'>Cette annonce n'existe plus </p>";
        header('location: index.php');
    }
}


if (isset($_POST['reservation_message']) && empty($_POST['reservation_message'])) {
    $msgeErreur = '<p class="text-danger py-2">Laisser nous un message pour vous contacter !</p>';
    $erreur = true;
}

// Ajouter le message de reservation au BDD
if (isset($_POST['reservation_message']) && !isset($erreur)) {

    $reqUpdate = $bdd->prepare("UPDATE advert set reservation_message = :reservation_message WHERE id= :id");
    $reqUpdate->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    $reqUpdate->bindValue(':reservation_message', $_POST['reservation_message'], PDO::PARAM_STR);

    if ($reqUpdate->execute()) {
        $_SESSION['message'] = "<p class='alert alert-success py-2 text-center'>l'annonce n° $_GET[id] est réserver  </p>";
        header('location: index.php');
    } else {
        $message = "<p class='alert alert-danger py-2 text-center'>l'annonce n° $_GET[id] n'existe pas  </p>";
    }
}

require_once('./inc/header.inc.php');
require_once('./inc/nav.inc.php');
?>
<div class="py-5 text-center">
    <h2>Détail de l'annonce N° <?= $_GET['id'] ?></h2>
</div>

<?php if (isset($message)) echo $message  ?>

<div class="row my-4">
    <div class="col-10 mx-auto">
        <div class="card flex-md-row mb-4 box-shadow">
            <img class="card-img-right flex-auto d-none d-md-block" src="../img/home.jpg" alt="<?= $datas['title'] ?>" style="width: 250px;">
            <div class="card-body d-flex flex-column align-items-start">
                <strong class="d-inline-block mb-2 text-primary"><?= ucfirst($datas['type']) ?></strong>
                <h3 class="mb-0">
                    <a class="text-dark" href="#"><?= strtoupper($datas['title']) ?></a>
                </h3>
                <!-- <div class="mb-1 text-muted">Nov 12</div> -->
                <p class="card-text my-4"><?= $datas['description'] ?></p>
                <form class="col-12" method="POST">
                    <div class="col-12">
                        <label for="Description" class="form-label">Message</label>
                        <div class="input-group">
                            <textarea class="form-control" name="reservation_message" id="Description" placeholder="Ecrire un message pour être contacter"><?php if (isset($datas['reservation_message'])) echo $datas['reservation_message'] ?></textarea>
                        </div>
                        <smal>
                            <?php if (isset($msgeErreur)) echo $msgeErreur ?>
                        </smal>
                    </div>
                    <button type="submit" class="btn btn-dark my-3">Je réserve</a>
                </form>
            </div>
        </div>
    </div>

</div>


<?php
require_once('./inc/footer.inc.php');
?>
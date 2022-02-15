<?php
require_once('./inc/init.php');
// echo '<pre>';
// print_r($bdd);
// echo '</pre>';
$reqDatas = $bdd->query("SELECT * FROM advert ORDER BY id DESC", PDO::FETCH_ASSOC);
$datas = $reqDatas->fetchAll(PDO::FETCH_ASSOC);
$titre = "Tous les annonces" ;

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

if(isset($_GET['filter'])){
    $reqDatas = $bdd->prepare("SELECT * FROM advert WHERE type = :type ORDER BY id DESC ");
    if($_GET['filter'] == 'location'){
        $reqDatas->bindValue(':type', $_GET['filter'], PDO::PARAM_STR);
        $reqDatas->execute();
        $datas= $reqDatas->fetchAll(PDO::FETCH_ASSOC);
        $titre = "Les annonces de <strong>LOCATION</strong>" ;
    }elseif($_GET['filter'] == 'vente')
    {
        $reqDatas->bindValue(':type', $_GET['filter'], PDO::PARAM_STR);
        $reqDatas->execute();
        $datas= $reqDatas->fetchAll(PDO::FETCH_ASSOC);
        $titre = "Les annonces de <strong>VENTE</strong>" ;
    }
}


require_once('./inc/header.inc.php');
require_once('./inc/nav.inc.php');
?>


<div class="py-5 text-center">
    <h2><?= $titre ?></h2>
</div>
<?php if (isset($message)) echo $message; ?>

<div class="d-flex justify-content-between items-align-center">
        <a href="?filter=location" class="btn btn-warning">En location</a>
        <a href="?filter=vente" class="btn btn-warning">En vente</a>

    </div>

<div class="row my-5 position-relative ">
    <?php foreach ($datas as $key => $produit) : ?>
        <div class="card col-md-4 col-sm-12 my-2 <?php echo empty($produit['reservation_message']) ? '' : 'bg-secondary' ?>">
            <img class="card-img-top" src="../img/home.jpg" alt="<?= $produit['title'] ?>">
            <div class="card-body">
                <h5 class="card-title"><?= strtoupper($produit['title']) ?></h5>
                <p class="card-text"><?= substr($produit['description'], 0, 50) ?>...</p>
                <p class="card-text"><?= number_format($produit['price'],2) ?> € <?php if($produit['type'] == 'location') echo '<b> / MOIS </b>'; ?></p>
                <a href="consulter.php?id=<?= $produit['id'] ?>" class="btn btn-dark ">Consulter</a>
            </div>
            <?php if (!empty($produit['reservation_message'])) :  ?>
                <div class="position-absolute top-0 end-0">
                    <h4 class="btn btn-danger">Réservé</h4>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>


<?php
require_once('./inc/footer.inc.php');
?>
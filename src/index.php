    <?php
    require_once('./inc/init.php');
    // echo '<pre>';
    // print_r($bdd);
    // echo '</pre>';

    $reqDatas = $bdd->query("SELECT * FROM advert ORDER BY id DESC LIMIT 0,15", PDO::FETCH_ASSOC);
    $datas = $reqDatas->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        unset($_SESSION['message']);
    }
    require_once('./inc/header.inc.php');
    require_once('./inc/nav.inc.php');
    ?>

    <div class="py-5 text-center">
        <h2>Les dernières annonces</h2>
    </div>
    <?php if (isset($message)) echo $message; ?>

    <div class="d-flex flex-wrap justify-content-around my-5 position-relative">
        <?php foreach ($datas as $key => $produit) : ?>
            <div class="card col-md-4 col-lg-3 col-sm-12 my-2 <?php echo empty($produit['reservation_message']) ? '' : 'bg-secondary' ?>">
                <img class="card-img-top" src="../img/home.jpg" alt="<?= $produit['title'] ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= strtoupper($produit['title']) ?></h5>
                    <p class="card-text"><?= substr($produit['description'], 0, 50) ?>...</p>
                    <p class="card-text"><?= number_format($produit['price'],2) ?> € <?php if($produit['type'] == 'location') echo '<b> / MOIS </b>'; ?></p>
                    <a href="consulter.php?id=<?= $produit['id'] ?>" class="btn btn-dark">Consulter</a>
                </div>
                <?php if(!empty($produit['reservation_message'])):  ?>
                
                    <h4 class="btn btn-danger btn_rotate">Reservé</h4>
                
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
    require_once('./inc/footer.inc.php');
    ?>
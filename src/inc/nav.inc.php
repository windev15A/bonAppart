
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">LE BON APPART</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample07">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php"> Home <span class="sr-only"></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ajout.php">Nouvelle annonnce</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tous_les_annonces.php">Consulter toutes les annonces</a>
                </li>
            </ul>

        </div>

        <div>
        <ul class="navbar-nav mr-auto">
            <?php if(!isConnected()): ?>
                <li class="nav-item active">
                    <a class="nav-link" href="newuser.php"> Créer un compte <span class="sr-only"></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="connexion.php">Connexion</a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link " href="connexion.php">Bonjour 
                        <?php 
                            if(isset($_SESSION['user'])){
                                echo $_SESSION['user']['name'];
                            }
                        ?>
                    
                    </a>
                </li> 
            <?php endif; ?>
                <?php if(isConnected()): ?>
                    <li class="nav-item">
                        <a class="nav-link btn btn-success" href="connexion.php?action=deconnexion">Déconnecter</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <main>
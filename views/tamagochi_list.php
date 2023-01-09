<?php
require_once('../DB/dbConn.php');
require_once('../DB/Database.class.php');
require_once('../class/Tamagotchi.class.php');

if (isset($_GET['userId'])) {
    $userId = $_GET['userId'];
    $tamago = new Tamagotchi('test', $userId);
    $tamagos = $tamago->getAllUserTamagos($userId);
    if ($tamagos != false) {
        foreach ($tamagos as $tamago) {
            $birthdate = new \DateTime(substr($tamago['created_at'], 0, strpos($tamago['created_at'], ' ')));
            $today = new \DateTime(date('Y-m-d'));
            $age = date_diff($birthdate, $today)->format("%a days");
        }
    }
}

include_once('components/doctype.php');
?>


<body class="list">
    <h1 class="allh1 lists">My tamagotchis</h1>
    <h6>@monpseudod'utilisateur</h6>
    <a href="tamagochi_new.php?userId=<?= $userId ?>" class="createnew">New Tamagotchi</a>
    <a href="graveyard.php" class="cimeterygo">✝ Graveyard</a>
    <div class="listoft">
        <?php if ($tamagos == false) { ?>
            <main class="listtamago">
                <article>
                    <button> Add Tamagochi </button>
                </article>
            </main>
            <?php } else {
            foreach ($tamagos as $tamago) {
            ?>
                <main class="listtamago">
                    <article>
                        <h2>Nom du tamagochi: <?= $tamago['name'] ?></h2>
                        <span>Niveau <em><?= $tamago['level'] ?></em></span>
                        <span>Date de création <em><?= $tamago['created_at'] ?></em></span>
                        <span>Âge <em> <?= $age ?></em></span>
                        <br />
                        <span>Faim <strong><?= $tamago['faim'] ?>%</strong></span>
                        <div class="progressbar-wrapper">
                            <div class="progressbar" style="width: <?= $tamago['faim'] ?>%"></div>
                        </div>
                        <span>Soif <strong><?= $tamago['soif'] ?>%</strong></span>
                        <div class="progressbar-wrapper">
                            <div class="progressbar" style="width: <?= $tamago['soif'] ?>%"></div>
                        </div>
                        <span>Amusement <strong><?= $tamago['ennui'] ?> %</strong></span>
                        <div class="progressbar-wrapper">
                            <div class="progressbar" style="width: <?= $tamago['ennui'] ?>%"></div>
                        </div>
                        <span>Level <strong><?= $tamago['level'] ?> %</strong></span>
                        <div class="progressbar-wrapper">
                            <div class="progressbar" style="width: <?= $tamago['level'] ?>%"></div>
                        </div>
                        <br />
                        <a href="takecareof.php" class="takecareof">Take care of me</a>
                    </article>
                </main>
            </br>
            <?php }
        } ?>
    </div>

</body>

</html>

<!--
Il doit être possible d'a cher le cimetière des tamagotchis par cet a chage.
Il doit être possible de créer un nouveau tamagotchi par cet a chage. Il n'y a pas de
limite de tamagotchis par compte.
-->
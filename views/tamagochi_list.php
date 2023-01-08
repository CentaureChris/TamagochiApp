<?php include_once('components/doctype.php') ; ?>
    <body class="list">
        <h1 class="allh1 lists">My tamagotchis</h1>
        <h6>@monpseudod'utilisateur</h6>
        <a href="tamagochi_new.php" class="createnew">New Tamagotchi</a>
        <a href="graveyard.php" class="cimeterygo">✝ Graveyard</a>
        <div class="listoft">
            <main class="listtamago">
                <article>
                    <h2>Nom du tamagochi</h2>
                    <span>Niveau <em>1</em></span>
                    <span>Date de création <em>00/00/0000</em></span>
                    <span>Âge <em>1 jour</em></span>
                    <br/>
                    <span>Faim <strong>100 %</strong></span>
                    <div class="progressbar-wrapper">
                        <div class="progressbar" style="width: 100%" ></div>
                    </div>
                    <span>Amusement <strong>100 %</strong></span>
                    <div class="progressbar-wrapper">
                        <div class="progressbar" style="width: 100%" ></div>
                    </div>
                    <span>Santé <strong>100 %</strong></span>
                    <div class="progressbar-wrapper">
                        <div class="progressbar" style="width: 100%" ></div>
                    </div>
                    <span>Expérience <strong>100 %</strong></span>
                    <div class="progressbar-wrapper">
                        <div class="progressbar" style="width: 100%" ></div>
                    </div>
                    <br/>
                    <a href="takecareof.php" class="takecareof">Take care of me</a>
                </article>
                <article></article>
                <article></article>
            </main>
        </div>
       
    </body>
</html>

<!--
Il doit être possible d'a cher le cimetière des tamagotchis par cet a chage.
Il doit être possible de créer un nouveau tamagotchi par cet a chage. Il n'y a pas de
limite de tamagotchis par compte.
-->
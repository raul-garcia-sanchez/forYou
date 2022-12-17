<?php session_start();
$_SESSION["see"] = false;
$arrayTranslateText= $_SESSION["translateText"];
if (!isset($_POST['inputName']) && !isset($_SESSION['user'])) {
    header("Location: error403.php");
}
else if($_SESSION["accesToWinLose"] == false){
    header("Location: error403.php");
}
?>
<!DOCTYPE html>
<html lang="<?php echo $arrayTranslateText["lang"]?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $arrayTranslateText["headLose"]?></title>
    <link rel="stylesheet" href="./style.css">
</head>
<noscript>
    <h1 id="messageNoJavascript"><?php echo $arrayTranslateText["nojavascript"]?>!!!</h1>
</noscript>
<body class="body_lose">

    <?php
    include './resources/auxFunctions.php';
    if(isset($_SESSION["see"])){
        calculateTotalPoints("lose");//Tiene un parametro para saber que has perdido
    }
    
    ?>

    <div class="headerFinalPages">
    <nav class="navigationBarIndex">
        <ul>
            <li class="dropdown">
                <a id="aPlay" href="./game.php"><span id="iconNavigationBar">&#9776;</span></a>
                <div class="dropdown-content">
                    <a class="linksToPagesGame" href="./game.php"><strong><?php echo $arrayTranslateText["menuLoseToGame"]?></strong></a>
                    <a class="linksToPagesGame" href="./index.php"><strong><?php echo $arrayTranslateText["menuLoseToIndex"]?></strong></a>
                    <label class="switch">
                        <input id="checkBoxDarkMode" type="checkbox" onchange="changeTheme()">
                        <span class="slider"><?php echo $arrayTranslateText["darkMode"]?></span>
                    </label>
                </div>
            </li>
        </ul>
    </nav>
    </div>

    <main>
        <div id="idTextLose">
            <h1><?php echo strtoupper($_SESSION['user']); ?> <?php echo $arrayTranslateText["textLoseH1"]?></h1>
            <h1><?php echo $arrayTranslateText["pointsLosePt1"]?> <?php echo $_SESSION["totalPointsUser"] ?> <?php echo $arrayTranslateText["pointsLosePt2"]?>!!</h1>
            <p id="pSeeOcultWord"><?php echo $arrayTranslateText["textLoseP"]?> <b id="bWordResult"> <?php echo $_SESSION["ocultWord"][count($_SESSION["ocultWord"]) - 2]; ?></b></h2>
        </div>
        <div id="finalMessage">  
        <?php
           
            for($i=0;$i<strlen($arrayTranslateText["finalMessageLose"]);$i++){
                $style=strval($i+1);
                echo "<span style='--i:{$style}'>{$arrayTranslateText["finalMessageLose"][$i]}</span>";
            }
            ?>
        </div>
        <div id="statistics">
            <p><?php echo $arrayTranslateText["gameLoseText"]?>: <?php echo $_SESSION['loseGames'];?></p>
            <p><?php echo $arrayTranslateText["gameWinText"]?>: <?php echo $_SESSION['winGames'];?></p>
            <p><?php getStatisticsWin($arrayTranslateText['numberWinsText'],$arrayTranslateText['numberAttemptsText'])?></p>
        </div>

        <form id="formWrite" method="POST">
            <input hidden type="checkbox" id="accept" name="accept">
        </form>


    </main>

    <?php
        if($_SESSION["sound"]){
            echo "<script>
                var sound = document.createElement('iframe');
                sound.setAttribute('src', './resources/lose.mp3');
                sound.setAttribute('hidden','hidden')
                document.body.appendChild(sound);
                </script>";
            $_SESSION["sound"] = false;
        }
        $_SESSION["accesToWinLose"] = false;
    ?>

    <?php
        unset($_SESSION["see"]);
    ?>

    <script>

        function changeTheme(){
            document.body.classList.toggle("dark-mode");

        }

        function changeToDarkOrLightMode(query){
            if (query.matches) {

                    if (!document.getElementById('checkBoxDarkMode').checked){
                        document.getElementById('checkBoxDarkMode').checked = true;

                        changeTheme();
                    }

                }
                else{

                    if (document.getElementById('checkBoxDarkMode').checked){
                        document.getElementById('checkBoxDarkMode').checked = false;

                        changeTheme();

                    }
                }
        }

        const query = window.matchMedia('(prefers-color-scheme: dark)');
        changeToDarkOrLightMode(query);
        query.addListener(changeToDarkOrLightMode);

    </script>

</body>
</html>
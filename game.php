<?php session_start();
$_SESSION["see"] = true;
$arrayTranslateText= $_SESSION["translateText"];
if (!isset($_POST['inputName']) && !isset($_SESSION['user'])) {
    header("Location: error403.php");
}
$_SESSION["loseGameChronoByTime"] = false;
if(isset($_POST["gameMode"])){//ELIGE EL MODO DE JUEGO SEGUN QUE HEMOS ELEGIDO
    if($_POST["gameMode"] == $arrayTranslateText["buttonNormalMode"]){//Verifica el modo de juego que hemos seleccionado
        $gameModeWordle= 0;//EL 0 es el modo normal
        $_SESSION["gameModeWordle"]= 0;
    }
    
    if($_POST["gameMode"] == $arrayTranslateText["buttonChronoMode"]){//Verifica el modo de juego que hemos seleccionado
        $gameModeWordle= 1;//EL 1 es el modo crono
        $_SESSION["gameModeWordle"]= 1;
    }
}

elseif(isset($_SESSION["gameModeWordle"])){
    if($_SESSION["gameModeWordle"] == 0){//Verifica el modo de juego que hemos seleccionado
        $gameModeWordle= 0;//EL 0 es el modo normal
    }
    
    if($_SESSION["gameModeWordle"] == 1){//Verifica el modo de juego que hemos seleccionado
        $gameModeWordle= 1;//EL 1 es el modo crono
    }
}

else{
    echo "NO HA ENTRADO";
    $gameModeWordle= 0;//EL 0 es el modo normal QuickPLAY
    $_SESSION["gameModeWordle"]= 0;
}
$translateWordsHidden= $_SESSION["translateWordsHidden"];
?>
<!DOCTYPE html>
<html lang="<?php echo $arrayTranslateText["lang"]?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $arrayTranslateText["headGame"]?></title>
    <link rel="stylesheet" href="./style.css">
</head>
<noscript>
  <h1 id="messageNoJavascript"><?php echo $arrayTranslateText["nojavascript"]?>!!!</h1>
</noscript>
<body class="body_game">
    <?php
        include './resources/auxFunctions.php';
        $_SESSION['user'] = (isset($_POST['inputName']) && strlen($_POST['inputName']) > 0 )
            ? $_POST['inputName']
            : $_SESSION['user'];

        $_SESSION['statisticsUser'] = (isset($_SESSION['statisticsUser']))
            ? $_SESSION['statisticsUser']
            : array();

        $_SESSION["totalPointsUser"] = (isset($_SESSION["totalPointsUser"]))
            ? $_SESSION["totalPointsUser"]
            : 0;

        $_SESSION['sound'] = true;

    ?>

    <nav class="navigationBarIndex">
    <?php //Añade la imagen del cronometro en el modo Crono
    
    ?>
        <ul>
            <li class="dropdown">
                <a id="aPlay" href=".game.php"><span id="iconNavigationBar">&#9776;</span></a>
                <div class="dropdown-content">
                    <a class="linksToPagesGame" href="./index.php"><strong><?php echo $arrayTranslateText["menuGameToIndex"]?></strong></a>
                    <label class="switch">
                            <input id="checkBoxDarkMode" type="checkbox" onchange="changeTheme()">
                            <span class="slider"><?php echo $arrayTranslateText["darkMode"]?></span>
                    </label>
                </div>
                
            </li>
        </ul>
    </nav>

    <div class="divCrono"> <!-- Cambia el el tag p segun el modo de juego -->
        <?php
        if($gameModeWordle == 1){
            echo '<p class="pCrono">02:00</p>';
        }
        else{
            echo '<p class="pCrono">00:00:00</p>';
        }

        ?>
    </div>

    <header>
        <h1 class="class-header"><?php echo $arrayTranslateText["headerh1"]?></h1>
        <h2 class="class-header"><?php echo $arrayTranslateText["headerh3Pt1"]?> <?php echo $_SESSION['user']?> <?php echo $arrayTranslateText["headerh3Pt2"]?></h2>
        <h3 class="class-header"><?php echo $arrayTranslateText["textPlayerRecord"]?>: <?php echo getUserRecord()?></h3>
        <h3 id="puntuation" class="class-header"><?php echo $arrayTranslateText["points"]?>: <?php echo $_SESSION["totalPointsUser"]?></h3>
    </header>

    <div class ="containerMainContent">
        <table>
            <?php
                for ($i=1; $i <= 6 ; $i++) {            
                    echo "<tr>";
                    for ($j=1; $j <= 5 ; $j++) {        
                        echo "<td id='$i$j'></td>\n";
                    }
                    echo "</tr>\n";
                }
                echo "\n"
            ?>
        </table>
    </div>


    <?php
        $randomWord = randomWord($translateWordsHidden);
        $_SESSION['keysSendDelete']= $arrayTranslateText["keysSendDelete"];
        $firstRowKeyboard = explode(",",$arrayTranslateText["firstRowKeyboard"]);
        $secondRowKeyboard = explode(",",$arrayTranslateText["secondRowKeyboard"]);
        $thirdRowKeyboard = explode(",",$arrayTranslateText["thirdRowKeyboard"]);
        if (isset($_SESSION['ocultWord']) && gettype($_SESSION['ocultWord']) == "string" ) {
            $_SESSION['ocultWord'] = "";
        }

        if ($_SESSION['ocultWord']){
            array_push( $_SESSION['ocultWord'], $randomWord);
        }
        else {
            $arrayTemporalWords = [];
            array_push($arrayTemporalWords, $randomWord);
            $_SESSION['ocultWord'] = $arrayTemporalWords;

        }
    ?>
    <div id="divKeyboard">
        <?php
        echo "<div class='rowKeyboard'>\n";
        for ($i = 0; $i <count( $firstRowKeyboard); $i++){
            echo "<button id='$firstRowKeyboard[$i]' class='class-keyboard'>$firstRowKeyboard[$i]</button>\n";
        }
        echo "</div>\n";
        echo "<div class='rowKeyboard'>\n";
        for ($j = 0; $j <count( $secondRowKeyboard); $j++){
            echo "<button id='$secondRowKeyboard[$j]' class='class-keyboard'>$secondRowKeyboard[$j]</button>\n";
        }
        echo "</div>\n";
        echo "<div class='rowKeyboard'>\n";
        for ($k = 0; $k <count( $thirdRowKeyboard); $k++){
            echo "<button id='$thirdRowKeyboard[$k]' class='class-keyboard'>$thirdRowKeyboard[$k]</button>\n";
        }
        echo "</div>\n";
        function filterAccents($word){
            if(str_contains($word,"à")){
                return str_replace("à","a",$word);
            }
            elseif(str_contains($word,"á")){
                return str_replace("á","a",$word);
            }
            else if(str_contains($word,"è")){
                return str_replace("è","e",$word);
            }
            else if(str_contains($word,"é")){
                return str_replace("é","e",$word);
            }
            else if(str_contains($word,"í")){
                return str_replace("í","i",$word);
            }
            else if(str_contains($word,"ò")){
                return str_replace("ò","o",$word);
            }
            else if(str_contains($word,"ó")){
                return str_replace("ó","o",$word);
            }
            else if(str_contains($word,"ú")){
                return str_replace("ú","u",$word);
            }
            else{
                return $word;
            }
        }

        function exceptionLetter($word){
            if(str_contains($word, "ç")){
                return str_replace("ç","Ç",$word);
            }
            else{
                return $word;
            }
        }
        function randomWord($lenguage){
            $fileWords= file("./resources/words".$lenguage.".txt");
            $fileOpen= fopen("./resources/words".$lenguage.".txt", "r");
            $arrayWords= [];
            foreach ($fileWords as $lineWord => $word){
                array_push($arrayWords, $word);
            };
            $arrayLen= count($arrayWords);
            $randomNumber= rand(0,$arrayLen-1);
            $randomWord= $arrayWords[$randomNumber];
            $randomWord= filterAccents($randomWord);
            $randomWord= exceptionLetter($randomWord);
            fclose($fileOpen);
            
            return trim(strtoupper(substr($randomWord,0)));
        }

        ?>
    </div>
    
        <form id="formDataGames" method="POST">
            <input hidden type="number" id="secPoints" name="secPoints"> <!--Modo normal con puntuacion CRONO -->
            <input hidden type="number" id= "loseGameChrono" name="loseGameChrono">
            <input hidden type="number" id="numYellows" name="numYellows">
            <input hidden type="number" id="numBrowns" name="numBrowns">
            <input hidden type="number" id="numAttempts" name="numAttempts">
            <input hidden type="text" id="winGame" name="winGame">
        </form>
    
    <?php
        $secPoints= 0;
        $loseGames = 0;
        $winGames = 0;
        $totalPoints = 0;
        if(isset($_POST['numYellows']) && isset($_POST['numBrowns']) && isset($_POST['numAttempts']) && isset($_POST['winGame'])){
            $dict = array();
            array_push($dict,$_POST['numYellows'],$_POST['numBrowns'],$_POST['numAttempts'],$_POST['winGame']);
            array_push($_SESSION['statisticsUser'],$dict);
            foreach($_SESSION['statisticsUser'] as $array){
                if($array[3] == "false"){
                    $loseGames = $loseGames + 1;
                }
                else{
                    $winGames = $winGames + 1;
                }
            }
            $secPoints= round(70-($_POST['secPoints']/2));
            $_SESSION['loseGames'] = $loseGames;
            $_SESSION['winGames'] = $winGames;
            $_SESSION['secPoints']= $secPoints;//MODO NORMAL PUNTUACION CRONO
        }

        
        if(isset($_POST['winGame']) || isset($_POST['loseGameChrono'])){
            if($_POST['loseGameChrono'] == 1){
                $_SESSION["loseGameChronoByTime"] = true;
                $_SESSION["accesToWinLose"] = true;
                echo "
                <script> 
                    window.location.replace('./lose.php');
                </script>";
            }
            else if($_POST['winGame'] == "false"){
                $_SESSION["accesToWinLose"] = true;
                echo "
                <script> 
                    window.location.replace('./lose.php');
                </script>";
            }
            else{
                $_SESSION["accesToWinLose"] = true;
                echo "
                <script>
                    window.location.replace('./win.php');
                </script>";
            }
        }
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

        var keysSendDelete = "<?php echo $_SESSION["keysSendDelete"]?>";
        <?php
            echo "var gameModeNum = '$gameModeWordle';";
            echo "var ocultWord = '$randomWord';";
        ?>
    </script>
    <script src="./playPage.js"></script>
    

    
</body>
</html>
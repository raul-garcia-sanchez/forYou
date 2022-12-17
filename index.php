<?php session_start();
if(isset($_POST["lenguageSelected"])){
    $_SESSION["lenguage"]= $_POST["lenguageSelected"];
    $lenguageSelected=$_POST["lenguageSelected"];
    $arrayTranslateText = changeLenguage($lenguageSelected);
    $_SESSION["translateWordsHidden"]= $_POST["lenguageSelected"];
}
elseif(isset($_SESSION["lenguage"])){
    $arrayTranslateText = changeLenguage($_SESSION["lenguage"]);
    $_SESSION["translateWordsHidden"]= $_SESSION["lenguage"];
}
else{
    $arrayTranslateText = changeLenguage("ES");
    $_SESSION["translateWordsHidden"]= "ES";
}
$_SESSION["translateText"]= $arrayTranslateText;
$_SESSION["accesToWinLose"] = false;
?>
<!DOCTYPE html>
<html lang="<?php echo $arrayTranslateText["lang"]?>">
<head>
    <title><?php echo $arrayTranslateText["headIndex"]?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
</head>
<noscript>
    <h1 id="messageNoJavascript"><?php echo $arrayTranslateText["nojavascript"]?>!!!</h1>
</noscript>
<body class="body_index">
    
    <header class="header-index">
        
        <nav class="navigationBarIndex">
                <ul>
                    <li class="dropdown">
                        <a id="aPlay" href="./game.php"><span id="iconNavigationBar">&#9776;</span></a>
                        <div class="dropdown-content">
                            <a class="linksToPages" id= "linksToPages" href="./game.php"><strong><?php echo $arrayTranslateText['menuQuickPlay']; ?></strong></strong></a>
                            <label class="switch">
                                <input id="checkBoxDarkMode" type="checkbox" onchange="changeTheme()">
                                <span class="slider"><?php echo $arrayTranslateText["darkMode"]?></span>
                            </label>
                        </div>
                    </li>
                </ul>
        </nav>

        <form id="formLanguage" method="POST">
                <select id="lenguageSelected" name="lenguageSelected" onchange="this.form.submit()">
                    <option value="ES" <?php 
                        if(isset($_SESSION["lenguage"])){
                            if ($_SESSION["lenguage"]== "ES"){
                                echo "selected";
                            }
                        }
                        elseif(isset($_POST["lenguageSelected"])){
                            if ($_POST["lenguageSelected"]== "ES"){
                                echo "selected";
                            }
                        }
                        ?>>ES</option>
                    <option value="CA" <?php
                        if(isset($_SESSION["lenguage"])){
                            if ($_SESSION["lenguage"]== "CA"){
                                echo "selected";
                            }
                        }
                        elseif(isset($_POST["lenguageSelected"])){
                            if ($_POST["lenguageSelected"]== "CA"){
                                echo "selected";
                            }
                        }
                        ?>>CA</option>
                    <option value="EN" <?php 
                        if(isset($_SESSION["lenguage"])){
                            if ($_SESSION["lenguage"]== "EN"){
                                echo "selected";
                            }
                        }
                        elseif (isset($_POST["lenguageSelected"])){
                            if ($_POST["lenguageSelected"]== "EN"){
                                echo "selected";
                            }
                        }
                        ?>>EN</option>
                </select>
            </form>
            <div class="headerLanding">
                <button onclick="seeHallOfFame()" id="hallOfFame"class="hallOfFame"><?php echo $arrayTranslateText['buttonHallFame']?> </button>
            </div>
    </header>
    <h1 class="titleWordle"><?php echo $arrayTranslateText["header"]?></h1>

    <div class ="containerMainContent">
        <img class="imgLanding" src="<?php echo $arrayTranslateText['imgWordle']?>" alt="Quadrícula joc">
        <p class="instructions">
            <?php echo $arrayTranslateText["instructions"]?>
        </p>
    </div>
    <br>

    <form id="formName" action="./game.php" class="formName" method="POST">
        <input class="inputName" type="text" name="inputName" id="inputName" placeholder="<?php echo $arrayTranslateText["placeholder"]?>">
        <br>
        <label><?php echo $arrayTranslateText["buttonStart"]?></label>
        <hr class="hrJugar">
        <div class="divSubmits">
            <input class="btnSubmit" id="btnSubmit" onclick="sendPlayPage(event)" value="<?php echo $arrayTranslateText['buttonNormalMode']?>"  type="submit" name="gameMode"> <!-- Les he añadido un name para saber el modo d juego en el game.php -->
            <input class="btnSubmit" id="btnSubmit" onclick="sendPlayPage(event)" value="<?php echo $arrayTranslateText['buttonChronoMode']?>"  type="submit" name="gameMode">
        </div>
        <hr class="hrJugar">
    </form>
    <br>
    <div class="divReset">
        <button class="btnReset" name="btnReset" id="btnReset"><?php echo $arrayTranslateText['buttonReset']?></button>
    </div>
    <br>
    <div class="alert" id="alert">
        <span class="closebtn" onclick="this.parentElement.style.visibility='hidden';">&times;</span> 
         <strong><?php echo $arrayTranslateText["alert"]?></strong>
    </div>

    <script>

        function sendPlayPage(event) {
            const playerName = document.getElementById("inputName").value;
            
            var userExist =      <?php
                            if (isset($_SESSION['user'])){
                                echo " true;";
                            }
                            else{
                                echo " false;";
                            }
                        ?>

            if (playerName.length == 0  && !userExist) {

                if (document.getElementById("alert").style.visibility === 'hidden' || document.getElementById("alert").style.visibility.length==0){
                    event.preventDefault();
                    document.getElementById("alert").style.visibility = 'visible';
                }
                else{
                    event.preventDefault();
                    document.getElementById("alert").style.visibility = 'visible';
                }
            }
            else{
                
                <?php
                    $_SESSION['ocultWord'] = "";
                ?>
                
                document.getElementById("formName").submit();
            }
        }

        function seeHallOfFame(){
            window.location.href = "./ranking.php"
        }

    </script>
    <?php
        if (isset($_SESSION["user"])){
            echo "<script> document.getElementById('inputName').value = '".$_SESSION["user"]."'; </script>";
            echo "<script> document.getElementById('linksToPages').style.cursor = 'pointer'; </script>";
            echo "<script> document.getElementById('linksToPages').style.pointerEvents = 'auto' </script>";
            // echo "<script> document.getElementById('linksToPagesChrono').style.cursor = 'pointer'; </script>";
            // echo "<script> document.getElementById('linksToPagesChrono').style.pointerEvents = 'auto' </script>";
        }
        function changeLenguage($lenguage){
            $fileWords= file("./resources/wordleText".$lenguage.".txt");
            $fileOpen= fopen("./resources/wordleText".$lenguage.".txt", "r");
            $signDictionary= ":";
            $keysValues= [];
            foreach ($fileWords as $numberLine => $wordsLine){
                $signDictionaryPosition= strpos($wordsLine, $signDictionary);
                $key= substr($wordsLine,0,$signDictionaryPosition);
                $value= trim(substr($wordsLine, $signDictionaryPosition+1));
                $keysValues[$key] = $value;
            };
            return $keysValues;
        };
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

    <dialog id="modalReset">
        <div class="titleDialog">
            <h2><?php echo $arrayTranslateText['titleCautionReset']?></h2>
        </div>
        <h3><?php echo $arrayTranslateText['textCautionReset']?></h3>
        <div class="buttonsModalReset">
            <button id="btnReset-no"><?php echo $arrayTranslateText['buttonCancel']?></button>
            <button id="btnReset-yes" onclick="window.location.href='logout.php'"><?php echo $arrayTranslateText['buttonReset']?></button>
        </div>
    </dialog>
    <script>

            const openModal = document.getElementById("btnReset");
            const closeModal = document.querySelector("#btnReset-no");
            const modal = document.querySelector("#modalReset");

            openModal.addEventListener("click",() => {
                modal.showModal();
            });

            closeModal.addEventListener("click", () => {
                modal.close();
            });
    </script>

    <?php
        if (isset($_POST['inputDarkMode'])) {
            if ($_POST["inputDarkMode"] == 'dark') {
                echo "<script> document.getElementById('checkBoxDarkMode').checked = true;
            changeThemeCheckingCheckBox()
            </script>";
            }
            else{
                echo "<script> document.getElementById('checkBoxDarkMode').checked = false;
            changeThemeCheckingCheckBox()
            </script>";
            } 
        }
    ?>

</body>
</html>
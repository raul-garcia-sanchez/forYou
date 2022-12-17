<?php session_start();
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
    <title><?php echo $arrayTranslateText["headWin"]?></title>
    <link rel="stylesheet" href="./style.css">
</head>
<noscript>
    <h1 id="messageNoJavascript"><?php echo $arrayTranslateText["nojavascript"]?>!!!</h1>
</noscript>
<body class="body_win">

    <?php
        include './resources/auxFunctions.php';
        if(isset($_SESSION["see"])){
            calculateTotalPoints("win");//Tiene un parametro para saber que has perdido
        }
    ?>

    <div class="headerFinalPages">
        <nav class="navigationBarIndex">
            <ul>
                <li class="dropdown">
                    <a id="aPlay" href="./game.php"><span id="iconNavigationBar">&#9776;</span></a>
                    <div class="dropdown-content">
                        <a class="linksToPagesGame" href="./game.php"><strong><?php echo $arrayTranslateText["menuWinToGame"]?></strong></a>
                        <a class="linksToPagesGame" href="./index.php"><strong><?php echo $arrayTranslateText["menuWinToIndex"]?></strong></a>
                        <label class="switch">
                            <input id="checkBoxDarkMode" type="checkbox" onchange="changeTheme()">
                            <span class="slider"><?php echo $arrayTranslateText["darkMode"]?></span>
                        </label>
                    </div>
                </li>
            </ul>
        </nav>
        <button onclick="seeHallOfFame()" id="hallOfFame" class="hallOfFame"><?php echo $arrayTranslateText["buttonHallFame"]?> </button>
        <button class="publish"><?php echo $arrayTranslateText["publishPoints"]?></button>
    </div>

    <dialog id="modalPublish">
        <div id="containerDialog">
            <div class="titleDialog" id="divTitleDialog">
                <h2 id="titleDialog"><?php echo $arrayTranslateText["titleStatistics"]?></h2>
            </div>
            <div id="btnsDialog" class="buttonsModal">
                <button id="btnPublish-no"><?php echo $arrayTranslateText["buttonCancel"]?></button>
                <button id="btnPublish-yes"><?php echo $arrayTranslateText["buttonAccept"]?></button>
            </div>
        </div>
    </dialog>

    <dialog id="messagePostWriteStatistics">
        <h2><?php echo $arrayTranslateText["textAcceptStatistics"]?>!!</h2>
        <div class="buttonModalInformation">
            <button id="btn-ok-close">Ok</button>
        </div>
    </dialog>

    <main>
        <div id="idTextWin">
            <h1> <?php echo strtoupper($_SESSION['user']); ?> <?php echo $arrayTranslateText["textWin"]?></h1>
            <h1> <?php echo $arrayTranslateText["pointsWinPt1"]?> <?php echo $_SESSION["totalPointsUser"]; ?> <?php echo $arrayTranslateText["pointsWinPt2"]?>!!</h1>
        </div>
        <div id="finalMessage">
            <?php
            for($i=0;$i<strlen($arrayTranslateText["finalMessageWin"]);$i++){
                $style=strval($i+1);
                echo "<span style='--i:{$style}'>{$arrayTranslateText["finalMessageWin"][$i]}</span>";
            }
            ?>
        </div>
       
        <div id="statistics">
            <p><?php echo $arrayTranslateText["gameLoseText"]?>: <?php echo $_SESSION['loseGames'];?></p>
            <p><?php echo $arrayTranslateText["gameWinText"]?>: <?php echo $_SESSION['winGames'];?></p>
            <p><?php getStatisticsWin($arrayTranslateText['numberWinsText'],$arrayTranslateText['numberAttemptsText']);?></p>
        </div>

        <form id="formWrite" method="POST">
            <input hidden type="checkbox" id="accept" name="accept">
        </form>
    </main>

    <?php
        if($_SESSION["sound"]){
            echo "<script>
                var sound = document.createElement('iframe');
                sound.setAttribute('src', './resources/win.mp3');
                sound.setAttribute('hidden','hidden')
                document.body.appendChild(sound);
                </script>";
            $_SESSION["sound"] = false;
            $_SESSION["accesToWinLose"] = true;
        }
        else{
            $_SESSION["accesToWinLose"] = false;
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

        function seeHallOfFame(){
            window.location.href = "./ranking.php"
        }

        const openModal = document.querySelector(".publish");
        const closeModal = document.querySelector("#btnPublish-no");
        const modal = document.querySelector("#modalPublish");


        openModal.addEventListener("click",() => {
            modal.showModal();
        })

        closeModal.addEventListener("click", () => {
            document.getElementById("formWrite").submit();
            modal.close();
        })

        modal.addEventListener('click', (event) => {
                if (event.target.id !== 'containerDialog' && event.target.id !== 'divTitleDialog'  && event.target.id !== 'titleDialog' && event.target.id !== 'btnsDialog'  && event.target.id !== 'btnPublish-no' && event.target.id !== 'btnPublish-yes') {
                    modal.close();
                }
            });

        const closeModalInformation = document.querySelector("#btn-ok-close");
        const modalInformation = document.querySelector("#messagePostWriteStatistics");
        const confirmWriteStatistics = document.querySelector("#btnPublish-yes");
        const btnOkInformation = document.querySelector("#btn-ok-close");

        confirmWriteStatistics.addEventListener("click",() => {
            modal.close();
            modalInformation.showModal();
            document.getElementById("accept").checked = true;
            setTimeout(() => {
                document.getElementById("formWrite").submit();
                document.getElementById("iframe").remove();
            }, 2000);
            
        })

        btnOkInformation.addEventListener("click",() => {
            modalInformation.close();
        })

        

        <?php
            if(isset($_POST["accept"])){
                writeStatistics();
            }
        ?>

    </script>


    <?php
        unset($_SESSION["see"]);
    ?>

</body>
</html>
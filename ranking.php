<?php session_start();
$arrayTranslateText= $_SESSION["translateText"];
$translateWordsHidden= $_SESSION["translateWordsHidden"];
?>
<!DOCTYPE html>
<html lang="en">
<!-- Andres cambia el lenguaje -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $arrayTranslateText["headRanking"]?></title>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="body_ranking">

    <nav class="navigationBarIndex">
        <ul>
            <li class="dropdown">
                <a id="aPlay" href="./game.php"><span id="iconNavigationBar">&#9776;</span></a>
                <div class="dropdown-content">
                    <a class="linksToPagesGame" href="./index.php"><strong><?php echo $arrayTranslateText["menuLoseToIndex"]?></strong></a>
                    <label class="switch">
                        <input id="checkBoxDarkMode" type="checkbox" onchange="changeTheme()">
                        <span class="slider"><?php echo $arrayTranslateText["darkMode"]?></span>
                    </label>
                </div>
            </li>
        </ul>
    </nav>

    <h1 id="titleRanking"><?php echo $arrayTranslateText["buttonHallFame"]?></h1>
    
    <table>
        <tr>
            <td><i class="fa fa-user" aria-hidden="true"></i> <?php echo $arrayTranslateText["rankingName"]?></td>
            <td><i class="fa fa-shopping-basket" aria-hidden="true"></i> <?php echo $arrayTranslateText["rankingPoints"]?></td>
            <td colspan="6"><i class="fa fa-trophy" aria-hidden="true"></i> <?php echo $arrayTranslateText["rankingNumberVictory"]?></td>
            <td><i class="fa fa-times" aria-hidden="true"></i> <?php echo $arrayTranslateText["rankingDefeat"]?></td>
        </tr>
        <tr>
            <td style="visibility:hidden"></td>
            <td style="visibility:hidden"></td>
            <td>1 <i class="fa fa-check" aria-hidden="true"></i></td>
            <td>2 <i class="fa fa-check" aria-hidden="true"></i></td>
            <td>3 <i class="fa fa-check" aria-hidden="true"></i></td>
            <td>4 <i class="fa fa-check" aria-hidden="true"></i></td>
            <td>5 <i class="fa fa-check" aria-hidden="true"></i></td>
            <td>6 <i class="fa fa-check" aria-hidden="true"></i></td>
            <td style="visibility:hidden"></td>
        </tr>
        <tr>
        <td style="visibility:hidden"></td>
        </tr>
        <?php
        include './resources/auxFunctions.php';
        $arrayRanking = getHallOfFames();
        foreach($arrayRanking as $array){
            echo "<tr>";
            foreach($array as $arrayPublish){
                echo "<td class='td-hall'>$arrayPublish</td>";
            }
            echo "</tr>";
        }

        ?>
    </table>
    
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
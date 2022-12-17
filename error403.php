<?php
    session_start();
    $arrayTranslateText = $_SESSION["translateText"];
    http_response_code(403);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title><?php echo $arrayTranslateText["headError"]?></title>
</head>
<body class="body_error">
    <nav class="navigationBarIndex">
        <ul>
            <li class="dropdown">
                <a id="aPlay" href="./game.php"><span id="iconNavigationBar">&#9776;</span></a>
                <div class="dropdown-content">
                    <a class="linksToPagesGame" href="./index.php"><strong><?php echo $arrayTranslateText["menuWinToIndex"]?></strong></a>
                    <label class="switch">
                        <input id="checkBoxDarkMode" type="checkbox" onchange="changeTheme()">
                        <span class="slider"><?php echo $arrayTranslateText["darkMode"]?></span>
                    </label>

                </div>
            </li>
        </ul>
    </nav>
    <div>
        <h1 class="titleError"><?php echo $arrayTranslateText["titleError"]?></h1>
        <h3 class="descriptionError"><?php echo $arrayTranslateText["textError"]?></h3>
    </div>

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
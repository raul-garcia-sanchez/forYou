const keys = document.querySelectorAll('.class-keyboard');//Array con todos los elementos que contienen la clase class-keyboard

let id;
let modeChronoId;
let userWordArr = [[]];//Array que vamos añadiendo las letras que vamos pulsando en el teclado
let positionStartWord = 11;//Posicion en la que empezamos a escribir

let loseGameChrono = 0;//Sirve para saber si has perdido por tiempo en el modo Crono 
let secPoints=0;//puntuacion crono que se añade en el modo normal
let countYellows = 0;
let countBrowns = 0;
let winGame = false;
let finishGame = false;
var keysSendDelete = keysSendDelete.split(",");
let gameMode= gameModeNum;//Game Mode WORDLE

let countSends = 0;//Iniciamos contador de veces que le damos a enviar
for (let i = 0; i < keys.length; i++){//Bucle para que cada vez que le demos a la tecla del teclado nos escriba la letra en su espacio correspondiente
    keys[i].onclick = ({ target }) => {//Cada vez que hacemos click a un boton, cogemos valor id del boton y lo escribimos
        const letter = target.getAttribute("id");
        if (letter === keysSendDelete[0]){
            sendWord();//Llamamos funcion enviar
            return;
        }
        if (letter === keysSendDelete[1]){
            deleteLetter();//Llamamos funcion borrar
            return;
        }
        
        updateUserWord(letter);//Escribimos letra en posicion 
    };
}

if(gameMode == 1){
    modeChrono();
}
else{
    crono();
}

function generateDictionary(){ //Creamos diccionario con letras y cantidad de veces que se repiten
    let dictOcultWord = new Map();
    var sameLetters = 0;
    for(let i = 0; i < ocultWord.length; i++){
        if(dictOcultWord.has(ocultWord[i])){
            let sameLettersLetter = dictOcultWord.get(ocultWord[i]);
            dictOcultWord.delete(ocultWord[i]);
            dictOcultWord.set(ocultWord[i],sameLettersLetter+1);
        }
        else{
            dictOcultWord.set(ocultWord[i],sameLetters+1);
        }
    }
    return dictOcultWord;
}

function getArrayWord(){//Funcion para obtener el array de letras que vamos escribiendo
    const wordArr = userWordArr.length
    return userWordArr[wordArr-1];
}

function updateUserWord(letter){//Funcion para escribir la letra en su espacio
    const wordArr = getArrayWord();
    if (wordArr && wordArr.length < 5){//Si longitud array es mas pequeño que 5 vamos añadiendo letras al array
        wordArr.push(letter);
        const spaceLetter = document.getElementById(String(positionStartWord));
        positionStartWord = positionStartWord +1;
        spaceLetter.textContent = letter;
    }
}


function sendWord(){//Funcion de boton enviar, comprobamos longitud, si gana, si pierde, letras acertadas...
    const wordArr = getArrayWord();
    let dictOcultWord = generateDictionary();
    const ocultWordArr = ocultWord.split("");

    if(wordArr.length !== 5){//Si la longitud del array es diferente de 5 no hacemos nada
        return;
    }

    const userWord = wordArr.join("");//Pasamos el array a un string

    for (let i = 0; i < wordArr.length ; i++){//Bucle para marcar las palabras que están en su posición correcta
        let color = "#98ff96"; //Color verde
        if (ocultWord.charAt(i) == userWord.charAt(i)){
            var lettersRepeats = dictOcultWord.get(userWord.charAt(i));


            document.getElementById(userWord.charAt(i)).style.backgroundColor = color; //Cambio de color del teclado
            
            document.getElementById(userWord.charAt(i)).classList.add('green');



            if (lettersRepeats > 0){
                dictOcultWord.delete(userWord.charAt(i));
                dictOcultWord.set(userWord.charAt(i),lettersRepeats-1);
            }  
        }
        else{
            color = "#8C661F";//Color marron
        }


        let letterToCompare = positionStartWord - 5 + i;
        const spaceLetter = document.getElementById(String(letterToCompare));

        if (color === "#98ff96"){
            spaceLetter.style.backgroundColor = color;
            spaceLetter.classList.add('green');
        }

    }

    
    for (let i = 0; i < wordArr.length ; i++){//Bucle para marcar las letras que estan en la palabra pero no en la posicion correcta
        let color = "#8C661F"; //Color marron
        let letterToCompare = positionStartWord - 5 + i;
        const spaceLetter = document.getElementById(String(letterToCompare));

        if(ocultWordArr.includes(wordArr[i])){
            var lettersRepeats = dictOcultWord.get(userWord.charAt(i));
            
            if(lettersRepeats > 0 && spaceLetter.style.backgroundColor != "rgb(152, 255, 150)" && document.getElementById(letterToCompare).style.backgroundColor != "rgb(14, 61, 35)"){ //entra si la letra esta en el diccionario y no esta pintada ya de verde
                dictOcultWord.delete(userWord.charAt(i));
                dictOcultWord.set(userWord.charAt(i),lettersRepeats-1);
                color = "#F2E205"; //Color amarillo
                if ( document.getElementById(letterToCompare).style.backgroundColor != "rgb(152, 255, 150)"){

                    document.getElementById(letterToCompare).style.backgroundColor = color; //Cambio de color del teclado
                    document.getElementById(userWord.charAt(i)).classList.add('yellow');

                }
                
                
            }
            else{

                if ( document.getElementById(letterToCompare).style.backgroundColor != "rgb(152, 255, 150)" && document.getElementById(letterToCompare).style.backgroundColor != "rgb(14, 61, 35)"){
                    if ( document.getElementById(userWord.charAt(i)).style.backgroundColor != "rgb(152, 255, 150)" && document.getElementById(userWord.charAt(i)).style.backgroundColor != "rgb(14, 61, 35)") {
                        document.getElementById(letterToCompare).style.backgroundColor = color; //Cambio de color del teclado
                        document.getElementById(userWord.charAt(i)).classList.add('brown');
                    }
                    

                }
                else{
                    continue;
                }
                
            }        
        }
        else{
            if(document.getElementById(letterToCompare).style.backgroundColor != "rgb(152, 255, 150)" && document.getElementById(letterToCompare).style.backgroundColor != "rgb(242, 226, 5)"){
                document.getElementById(letterToCompare).style.backgroundColor = color; //Cambio de color del teclado
                document.getElementById(userWord.charAt(i)).classList.add('brown');

            };
        }
        
        spaceLetter.style.backgroundColor = color;
        if (color === "#F2E205" && spaceLetter.style.backgroundColor != "rgb(152, 255, 150)" && spaceLetter.style.backgroundColor != "rgb(14, 61, 35)"){
            spaceLetter.classList.add('yellow');
        }
        if (color === "#8C661F" && spaceLetter.style.backgroundColor != "rgb(152, 255, 150)" && spaceLetter.style.backgroundColor != "rgb(14, 61, 35)"){
            spaceLetter.classList.add('brown');

        }
        

    }

    
    

    for(let i = 0; i<wordArr.length; i++){
        let letterToCompare = positionStartWord - 5 + i;
        const spaceLetter = document.getElementById(String(letterToCompare));
        if(spaceLetter.style.backgroundColor == "rgb(242, 226, 5)"){
            countYellows = countYellows +1;

        }
        else if(spaceLetter.style.backgroundColor == "rgb(140, 102, 31)"){
            countBrowns = countBrowns + 1;
        }
    }

    if(userWord == "XNEOX"){
        var soundMatrix = document.createElement("iframe");
        soundMatrix.setAttribute("id","soundMatrix");
        soundMatrix.setAttribute("src", "./resources/matrixSound.mp3");
        soundMatrix.setAttribute("hidden","hidden");
        document.body.appendChild(soundMatrix);
        document.body.style.background = "url('./resources/gifMatrix.gif') no-repeat center center fixed";
        document.body.style.backgroundSize = "cover";
        document.getElementsByTagName("header")[0].classList.add("easterEgg")
        document.getElementsByTagName("li")[0].style.backgroundColor = "white";
        document.getElementsByTagName("li")[0].style.width = "max-content";
        document.body.classList.add("neo");

        

    }

    if (userWord === ocultWord){//Comprobamos si la palabra oculta es igual a la que el usuario inserta
        soundWin();
        winGame = true;
        finishGame = true;
        
    }
    else{
        soundError();
    }
    


    if(wordArr.length === 5){//Cuando el array es de 5 posiciones, reseteamos array y añadimos 1 al contador de enviado
        positionStartWord = positionStartWord + 5;
        userWordArr = [[]];
        countSends = countSends + 1; 
    }

    if (countSends == 6 && userWord !== ocultWord){//Comprobamos que ha enviado la palabra 6 veces y la palabra no es correcta
        finishGame = true;
    }

    if(finishGame == true){
        clearTimeout(id);
        clearInterval(modeChronoId);
        document.getElementById("secPoints").value = secPoints;//MODO NORMAL PUNTUACION CRONO
        document.getElementById("numYellows").value = countYellows;
        document.getElementById("numBrowns").value = countBrowns;
        document.getElementById("numAttempts").value = countSends;
        document.getElementById("winGame").value = winGame;
        document.getElementById("loseGameChrono").value = loseGameChrono;
        setTimeout(() => {
            document.getElementById("formDataGames").submit();
        }, 2000);
        
    }

    if(document.getElementById("soundError")){
        setTimeout(() => {
            deleteSoundError();
        }, 2000);
        }
    
    }

function soundError(){
    var sound = document.createElement("iframe");
    sound.setAttribute("id","soundError");
    sound.setAttribute("src", "./resources/incorrect.mp3");
    sound.setAttribute("hidden","hidden");
    document.body.appendChild(sound);
}

function deleteSoundError(){
    document.getElementById("soundError").remove();
}

function soundWin(){
    var soundWin = document.createElement("iframe");
    soundWin.setAttribute("id","soundWin");
    soundWin.setAttribute("src", "./resources/correct.mp3");
    soundWin.setAttribute("hidden","hidden");
    document.body.appendChild(soundWin);
}

function deleteLetter(){//Funcion para borrar letras de una misma fila
    const wordArr = getArrayWord();

    if(wordArr.length > 0){
        wordArr.pop()
        positionStartWord = positionStartWord-1;
        const spaceLetter= document.getElementById(String(positionStartWord));
        spaceLetter.textContent = null;
    }
    else{
        return;
    }
}

function modeChrono(){
    let secFinal= 0;
    let secMode= 60;
    let minMode= 1;
    modeChronoId = setInterval(function(){
        if(secFinal == 119){
            loseGameChrono = 1;
            document.getElementById("secPoints").value = secPoints;//MODO NORMAL PUNTUACION CRONO
            document.getElementById("loseGameChrono").value = loseGameChrono;
            document.getElementById("numYellows").value = countYellows;
            document.getElementById("numBrowns").value = countBrowns;
            document.getElementById("numAttempts").value = countSends;
            document.getElementById("winGame").value = winGame;
            clearInterval(modeChronoId);
            setTimeout(() => {
                document.getElementById("formDataGames").submit();
            }, 1000);

        }
        else if (secMode<=0){
            secMode= 59;
            minMode-= 1;
            document.querySelector(".pCrono").style.color="red";
        }
        else{
            secMode -= 1;
            secFinal += 1;
        }
        let classModeChrono= document.querySelector(".pCrono");
        classModeChrono.innerHTML= `${minMode.toString().padStart(2,"0")}:${secMode.toString().padStart(2,"0")}`;
    }, 1000)
}

function crono(){
    let sec= 0;
    let min= 0;
    let hour= 0;
    id = setInterval(function(){
        if(min>=59){
            min= 0;
            hour= hour +1;
        }
        else if(sec>=59){
            sec= 0;
            min= min+1;
        }
        else{
            sec= sec+1;
        }
        secPoints= secPoints+1;
        let pCrono= document.querySelector(".pCrono");
        pCrono.innerHTML= `${hour.toString().padStart(2,"0")}:${min.toString().padStart(2,"0")}:${sec.toString().padStart(2,"0")}`;
    },1000);
}

function stopCrono(function_Crono){
    clearInterval(function_Crono);
}
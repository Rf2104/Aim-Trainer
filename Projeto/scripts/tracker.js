$(document).ready(function () {


    var timeLeft = 29;
    var elem = $('#timeleft');
    var timerId;
    function timer() {
        if (timeLeft >= 0) {
            elem.html("Time: " + timeLeft + 's');
            timeLeft--;
        }
        else clearInterval(timerId);
    }

    var divBox = $("#divbox");
    var divGame = $("#divgame");
    var pgbutton = $("#pgbutton");
    var gameWidth = divGame.width();
    var gameHeight = divGame.height();
    var hitsElement = $("#hits");
    var audio = new Audio("/Projeto/images/shot.mp3");
    var currentX = 0;
    var currentY = 0;
    var accuracyElement = $("#ac");
    var accuracy;
    var tiros;
    var acertos;
    var userNameElement = document.getElementById('user-name');
    var userName = userNameElement.dataset.userName;

    divGame.on("click", function () {
        audio.currentTime = 0;
        audio.play();
    });

    divGame.css("backgroundImage", "none");
    divGame.css("backgroundColor", "rgba(7, 8, 70, 0.7)");
    pgbutton.css("display", "block");
    pgbutton.on("click", function () {
        pgbutton.css("display", "none");
        accuracyElement.css("display", "none");
        elem.html("Time: 30s");
        tiros = -1;
        acertos = 0;
        timerId = setInterval(timer, 1000);
        timeLeft = 29;
        moveBox();
        divGame.css("backgroundColor", "none");
        hitsElement.html("Hits: " + acertos);
        divGame.css("backgroundImage", "url(/Projeto/images/mapa3.jpg)");
    });
    $("#divgame").append(pgbutton);

    function moveBox() {
        if (timeLeft >= 0) {
            divBox.css("display", "block");
            var randomX = Math.floor(Math.random() * (gameWidth - divBox.width()));
            var randomY = Math.floor(Math.random() * (gameHeight - divBox.height()));
            var marginLeft = randomX - currentX;
            var marginTop = randomY - currentY;
            var speed = 1; // ajuste a velocidade aqui
            var interval = setInterval(function () {
                if (marginLeft > 0) {
                    currentX++;
                    marginLeft--;
                } else if (marginLeft < 0) {
                    currentX--;
                    marginLeft++;
                }
                if (marginTop > 0) {
                    currentY++;
                    marginTop--;
                } else if (marginTop < 0) {
                    currentY--;
                    marginTop++;
                }
                divBox.css("margin-left", currentX);
                divBox.css("margin-top", currentY);
                if (marginLeft === 0 && marginTop === 0) {
                    clearInterval(interval);
                    moveBox();
                }
            }, speed);
        }
        else {

            var xhr = new XMLHttpRequest();
            xhr.open("GET", "http://localhost:8888/Projeto/top.php?nome=" + userName + "&hits=" + acertos + "&tracker=1", true);
            xhr.send();

            divBox.css("display", "none");
            divGame.css({
                "backgroundImage": "none",
                "backgroundColor": "rgba(7, 8, 70, 0.7)"
            });
            accuracy = (1 - ((tiros - acertos) / tiros)) * 100;
            pgbutton.css("display", "block");
            accuracyElement.html("Accuracy: " + accuracy.toFixed(0) + "%");
            accuracyElement.css("display", "block");
        }
    }

    divBox.on("click", function () {
        acertos++;
        hitsElement.html("Hits: " + acertos);
    });
    divGame.on("click", function () {
        tiros++;
        console.log(tiros);
    });
});
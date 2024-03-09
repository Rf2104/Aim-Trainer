$(document).ready(function () {


    var time = 1;
    var elem = $('#time');
    var timerId;
    function timer() {
        var formattedTime = time.toString().padStart(2, '0');
        elem.html("Time: " + formattedTime + 's');
        time++;
    }

    var divGame = $("#divgame");
    var pgbutton = $("#pgbutton");
    var hitsElement = $("#hits");
    var vidaElement1 = $("#vida1");
    var vidaElement2 = $("#vida2");
    var vidaElement3 = $("#vida3");
    var vidas = 3;
    var audio = new Audio("/Projeto/images/shot.mp3");
    var accuracyElement = $("#ac");
    var tiros;
    var acertos;
    var timeoutID;
    var intID;
    var divs = [];
    var timeouts = [[]];
    var userNameElement = document.getElementById('user-name');
    var userName = userNameElement.dataset.userName;

    divGame.on("click", function () {
        audio.currentTime = 0;
        audio.play();
        tiros++;
    });

    divGame.css("backgroundImage", "none");
    divGame.css("backgroundColor", "rgba(7, 8, 70, 0.7))");
    pgbutton.css("display", "block");
    $(document).on("click", "#pgbutton", function () {
        pgbutton.css("display", "none");
        accuracyElement.css("display", "none");

        setTimeout(function () {
            vidaElement1.css("display", "inline-block");
            vidaElement2.css("display", "inline-block");
            vidaElement3.css("display", "inline-block");
            pgbutton.css("display", "none");
            accuracyElement.css("display", "none");
            elem.html("Time: 00s");
            tiros = 0;
            acertos = 0;
            timerId = setInterval(timer, 1000);
            time = 1;
            vidas = 3;
            showDivs();
            divGame.css("backgroundColor", "none");
            hitsElement.html("Hits: " + acertos.toString().padStart(2, '0'));
            divGame.css("backgroundImage", "url(/Projeto/images/mapa2.jpg)");
        }, 500);
    });
    $("#divgame").append(pgbutton);

    function showDivs() {

        intID = setInterval(function () {
            if (vidas <= 0) {
                clearInterval(timerId);
                timeouts.forEach(clearTimeout); // Cancela todos os timeouts armazenados
                clearInterval(intID);
                return;
            }

            // Cria uma nova div
            var divBox = $("<div class='divBox'></div>");

            divBox.css({
                "width": "10px",
                "height": "10px",
                "borderRadius": "100%",
                "backgroundColor": "blue",
                "border": "1px solid white",
                "position": "fixed",
                "marginLeft": Math.floor(Math.random() * 785) + "px",
                "marginTop": Math.floor(Math.random() * 485) + "px",
                "transition": "width 0.5s, height 0.5s" // Adiciona a transição de 1 segundo para a mudança de tamanho da div
            });

            minitimeout = setTimeout(function () {
                divBox.css({
                    "width": "15px",
                    "height": "15px"
                });
            }, 10);

            divs.push(divBox);
            // Adiciona a div ao corpo do documento
            divGame.append(divBox);

            var index = timeouts.indexOf(divBox);
            if (index === -1) {
                index = timeouts.push([]) - 1; // Adiciona uma nova matriz vazia ao array
            }

            // Remove a div após 5 segundos
            timeoutID = setTimeout(function () {
                divBox.css({
                    "transition": "width 1s, height 1s", // Adiciona a transição de 1 segundo para a mudança de tamanho da div
                    "width": "0px",
                    "height": "0px"
                });

                timeoutID2 = setTimeout(function () {
                    console.log("entrou");
                    divBox.remove();
                    vidas--;
                    if (vidas == 0) {
                        
                        var xhr = new XMLHttpRequest();
                        xhr.open("GET", "http://localhost:8888/Projeto/top.php?nome=" + userName + "&hits=" + acertos + "&precision=1", true);
                        xhr.send();

                        vidaElement3.css("display", "none");
                        divGame.empty();
                        divGame.css({
                            "backgroundImage": "none",
                            "backgroundColor": "rgba(7, 8, 70, 0.7)"
                        });
                        accuracy = (1 - ((tiros - acertos) / tiros)) * 100;
                        pgbutton.css("display", "block");
                        accuracyElement.html("Accuracy: " + accuracy.toFixed(0) + "%");
                        accuracyElement.css("display", "block");
                        $("#divgame").append(accuracyElement);
                        $("#divgame").append(pgbutton);
                        clearInterval(intID);
                        timeouts.forEach(clearTimeout); // Cancela todos os timeouts armazenados
                        clearInterval(timerId);
                    }
                    else if (vidas == 2) {
                        vidaElement1.css("display", "none");
                    } else if (vidas == 1) {
                        vidaElement2.css("display", "none");
                    }
                }, 500);
            }, 2000);

            timeouts[index].push(timeoutID);

            divBox.on("click", function () {
                acertos++;
                hitsElement.html("Hits: " + acertos.toString().padStart(2, '0'));
                divBox.remove();
                clearTimeout(timeouts[index]);
            });

        }, 700);
    }
});
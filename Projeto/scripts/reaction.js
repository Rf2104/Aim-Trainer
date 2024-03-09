var clickedTime;
var createdTime;
var reactionTime;
var average;
var hits = 0;
var totalTime = 0;
var audio = new Audio("/Projeto/images/shot.mp3");
var divGame = document.getElementById("divgame");
var userNameElement = document.getElementById('user-name');
var userName = userNameElement.dataset.userName;

divGame.addEventListener("click", function () {
    audio.currentTime = 0;
    audio.play();
});


divGame.style.backgroundImage = "none";
divGame.style.backgroundColor = "rgba(7, 8, 70, 0.7)";
pgbutton.style.display = "block";
pgbutton.onclick = function () {
    pgbutton.style.display = "none";
    hits = 0;
    totalTime = 0;
    makebox();
    divGame.style.backgroundColor = "";
    document.getElementById("hits").innerHTML = "Hits: " + hits + "/8";
    document.getElementById("avg").innerHTML = "Average Time: 0.00";
    document.getElementById("lasthit").innerHTML = "Last Hit: 0.00";
    divGame.style.backgroundImage = "url(/Projeto/images/mapa1.jpg)";


}
document.getElementById("divgame").appendChild(pgbutton);


function position() {
    var color = ["red", "blue", "green", "yellow"];
    var codColor = Math.floor(Math.random() * color.length);
    var randomMarginTop = Math.floor(Math.random() * 450);
    var randomMarginLeft = Math.floor(Math.random() * 750);

    document.getElementById("divbox").style.backgroundColor = color[codColor];
    document.getElementById("divbox").style.borderRadius = "100%";
    document.getElementById("divbox").style.marginTop = randomMarginTop + "px";
    document.getElementById("divbox").style.marginLeft = randomMarginLeft + "px";
}

function makebox() {
    position();
    var delay = Math.floor(Math.random() * 300) + 1000;

    setTimeout(function () {
        document.getElementById("divbox").style.display = "block";

        createdTime = Date.now();
    }, delay);
}

document.getElementById("divbox").onclick = function () {
    clickedTime = Date.now();

    reactionTime = (clickedTime - createdTime) / 1000;
    totalTime += reactionTime;
    hits++;
    average = totalTime / hits;
    document.getElementById("lasthit").innerHTML = "Last Hit: " + reactionTime.toFixed(2);
    document.getElementById("avg").innerHTML = "Average Time: " + average.toFixed(2);
    document.getElementById("hits").innerHTML = "Hits: " + hits + "/8";
    document.getElementById("divbox").style.display = "none";

    if (hits < 8) {
        makebox();
    }
    else {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "http://localhost:8888/Projeto/top.php?nome=" + userName + "&avg=" + average.toFixed(2) + "&reaction=1", true);
        xhr.send();


        divGame.style.backgroundImage = "none";
        divGame.style.backgroundColor = "rgba(7, 8, 70, 0.7)";
        pgbutton.style.display = "block";
        pgbutton.onclick = function () {
            pgbutton.style.display = "none";
            hits = 0;
            totalTime = 0;
            makebox();
            divGame.style.backgroundColor = "";
            document.getElementById("hits").innerHTML = "Hits: " + hits + "/8";
            document.getElementById("avg").innerHTML = "Average Time: 0.00";
            document.getElementById("lasthit").innerHTML = "Last Hit: 0.00";
            divGame.style.backgroundImage = "url(/Projeto/images/mapa1.jpg)";
        }
        document.getElementById("divgame").appendChild(pgbutton);
    }
}
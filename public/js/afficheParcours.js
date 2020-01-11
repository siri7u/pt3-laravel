function afficheParcours(fichier, charger) {

    //on récupère
    var filecontent = fichier;

    // pour des raisons de sécurité, blade remplace les balises
    // et autres caractères spéciaux alors on doit tout refaire
    var filecontent = filecontent.replace(/&gt;/g, '>');
    var filecontent = filecontent.replace(/&lt;/g, '<');
    var filecontent = filecontent.replace(/&quot;/g, '"');
    var filecontent = filecontent.replace(/&#039;/g, "'");
    var filecontent = filecontent.replace(/&amp;/g, '&');

    if (typeof myChart !== 'undefined') {
        window.myChart.destroy();
        $("#chart1").empty();
    }



    //On efface tous les layers existants
    map.eachLayer(function(layer) {
        if (layer instanceof L.Polyline || layer instanceof L.Marker) {
            map.removeLayer(layer);
        }
    });

    //xmlDoc = le fichier envoyé sous forme de string
    var parser = new DOMParser();
    var xmlDoc = parser.parseFromString(filecontent, "text/xml");

    //change le placeholder du fileinput pour afficher le nom du fichier
    //TODO

    //on commence à décoder xmlDoc
    var coords = xmlDoc.getElementsByTagName("trkpt");
    var coordsLen = coords.length;

    window.latlngs = [];
    window.eles = [];
    window.times = [];

    //extrait et stock les coordonnées dans latlngs
    for (i = 0; i < coordsLen; i++) {

        var lat = parseFloat(coords[i].attributes["lat"].value);
        var long = parseFloat(coords[i].attributes["lon"].value);


        //console.log(lat);

        latlngs.push([lat, long]);


        for (var j = 0; j < coords[i].childNodes.length; j++) {
            if (coords[i].childNodes[j].nodeName == "ele") {

                window.eles.push(parseFloat(coords[i].childNodes[j].childNodes[0].data));
            }
            if (coords[i].childNodes[j].nodeName == "time") {

                window.times.push(new Date(coords[i].childNodes[j].childNodes[0].data));
            }

        }

    }

    //console.log(eles);
    data = [];
    var labels = new Array(100);

    renderChart(eles, labels, "chart1");
    myChart.update();
    //renderChart(eles, labels, "chart2");
    //renderChart(eles, labels, "chart3");

    //affichage du premier point sur la map
    /*     var greenIcon = L.icon({
            iconUrl: 'img/depart.png',
            iconSize: [50, 25],
            iconAnchor: [50, 25],
        });

        L.marker([xmlDoc.getElementsByTagName("trkpt")[0].attributes["lat"].value,
                xmlDoc.getElementsByTagName("trkpt")[0].attributes["lon"].value
            ], {
                icon: greenIcon
            })
            .addTo(map); */

    //affichage du premier point point sur la map
    L.marker([
            xmlDoc.getElementsByTagName("trkpt")[0].attributes["lat"].value,
            xmlDoc.getElementsByTagName("trkpt")[0].attributes["lon"].value, {
                color: 'red'
            }
        ])
        .addTo(map);

    //affichage du denier point point sur la map
    L.marker([
            xmlDoc.getElementsByTagName("trkpt")[coordsLen - 1].attributes["lat"].value,
            xmlDoc.getElementsByTagName("trkpt")[coordsLen - 1].attributes["lon"].value, {
                color: 'red'
            }
        ])
        .addTo(map);

    //affichage lignes parcours
    var polyline = L.polyline(latlngs, {
        color: 'red',
        weight: 3,
        opacity: 0.6,
        smoothFactor: 1
    }).addTo(map);

    //console.log(latlngs[0][0]);

    // centre la map sur le parcours
    map.fitBounds(polyline.getBounds());
    map.invalidateSize();

}


//affiche un graphique
function renderChart(data, labels, name) {

    /* x = 100;

    window.altitude = smallerTable(eles, x);

    window.temps = smallerTable(times, x);

    len = (Object.keys(latlngs).length);
    window.coords = [
        []
    ]; */

    /* for (i = 0; i < len; i = i + len / x) {

        coords.push([latlngs[Math.round(i)][0], latlngs[Math.round(i)][1]]);

    } */

    datatest = [];
    //crée la table qui contient les coordonnées
    coords = [];
    for (i = 0; i < Object.keys(eles).length; i++) {
        coords.push(new L.LatLng(latlngs[i][0], latlngs[i][1]));
    }

    //crée la table des vitesses
    for (i = 1; i < Object.keys(eles).length; i++) {
        //datatest.push(eles[i] + 109);

        //calcul distance - Haversine formula
        distance = Math.round(coords[i - 1].distanceTo(coords[i]));

        //calcul vitesse moyenne
        temps1 = times[i - 1];
        temps2 = times[i];
        diff = Math.abs(temps1 - temps2);
        vitesse = 3600 * distance / diff; // m/ms -> km/h = *3600

        datatest.push(vitesse);
    }

    limites = []
        //console.log("eles : " + Object.keys(eles).length);

    var ctx = document.getElementById(name).getContext('2d');
    window.myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: new Array(Object.keys(eles).length),
            datasets: [{

                yAxisID: 'yA',
                xAxisID: 'A',
                data: eles,
                label: 'Altitude (m)',
                fill: false,

                borderColor: "lightblue",
                backgroundColor: "lightblue",

                pointBackgroundColor: [],
                pointBorderColor: [],
                pointRadius: [],

            }, {
                yAxisID: 'yB',
                xAxisID: 'B',
                data: datatest,
                label: 'Vitesse (km/h)',
                fill: false,

                borderColor: "lightgreen",
                backgroundColor: "lightgreen",

                pointBackgroundColor: [],
                pointBorderColor: [],
                pointRadius: [],


                lineTension: 10,
                steppedLine: true,
            }]
        },

        options: {
            showTooltips: true,
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    id: 'yA',
                    type: 'linear',
                    position: 'left',
                    ticks: {
                        beginAtZero: true,
                    }
                }, {
                    id: 'yB',
                    type: 'linear',
                    position: 'right',
                }],


                xAxes: [{
                    id: 'A',
                    ticks: {

                    }
                }, {
                    id: 'B',
                    ticks: {
                        maxTicksLimit: 10,
                    }
                }]
            },
            onClick: clickEvent, //fonction quand on clique
            elements: {
                point: {
                    radius: 0
                }
            },
            tooltips: {
                mode: 'index',
                intersect: false,
                enabled: true,
                callbacks: {
                    title: function(tooltipItems, data) {
                        //console.log(tooltipItems[0].index);

                        date1 = times[tooltipItems[0].index];
                        date2 = times[0];

                        temps = millisToMinutesAndSeconds(Math.abs(date2 - date1));



                        return 'à ' + times[tooltipItems[0].index].getHours() + "h" + times[tooltipItems[0].index].getMinutes() + ", depuis " + temps;
                    },
                    /*  beforeLabel: function(tooltipItem, data) {
                         return '' + tooltipItem.index;
                     }, */
                    label: function(tooltipItem, data) {

                        return data.datasets[tooltipItem.datasetIndex].label + ': ' + tooltipItem.yLabel + ' ';
                    },
                    /* afterFooter: function(tooltipItem, data) {
                        return '' + tooltipItem.index;
                    } */

                }
            },
        },

        label: "alt",

    });

    Chart.defaults.global.legend.display = true;
    Chart.defaults.global.tooltips.enabled = true;
    Chart.defaults.global.hover = true;
}



function smallerTable(table, x) {

    len = (Object.keys(eles).length);
    tmp = [];

    for (i = 0; i < len; i = i + len / x) {
        tmp.push(eles[Math.round(i)]);
    }

    return tmp;

}

//contiendra toutes les sections de parcours
sectionsList = [];
nombreDeSections = 0;


//ce qui se passe quand on clique sur le graphique
function clickEvent(c, i) {
    e = i[0];
    console.log("index", e._index)
    var x_value = this.data.labels[e._index];
    var y_value = this.data.datasets[0].data[e._index];
    console.log("x value", x_value);
    console.log("y value", y_value);



    limites.push(e._index);

    //
    sectionCoords = [];
    sectionTemps = [];
    sectionEles = [];


    dats = []

    //tous les deux clics
    if (Object.keys(limites).length >= 2) {

        //
        //clearSections();
        console.log("deuxieme clic");

        lat = [];
        long = [];


        //a changer
        //x1 premier point selectionné
        //x2 second point selectionné
        x1 = limites[0];
        x2 = limites[1];

        // console.log("len " + Object.keys(latlngs).length);

        if (x2 < x1) {
            tmp = x2;
            x2 = x1;
            x1 = tmp;
        }

        console.log("x1: " + x1 + " " + "x2: " + x2);

        //ajoute dans le tableau toutes les coordonnées qui correspond à la section selectinnée sur le graphique (de x1 à x2)
        for (i = x1; i < x2; i++) {
            sectionCoords.push(new L.LatLng(latlngs[i][0], latlngs[i][1]));
            sectionEles.push(eles[i]);
            sectionTemps.push(times[i]);
        }





        var s = new L.polyline(sectionCoords, {
            color: 'blue',
            weight: 3,
            opacity: 1,
            smoothFactor: 1
        }).addTo(map);
        sectionsList.push(s);

        //on supprime
        limites = [];

        //change les points des sections (couleur) sur le graphgique
        for (i = x1; i < x2; i++) {
            myChart.config.data.datasets[0].pointBackgroundColor[i] = "blue";
            myChart.config.data.datasets[0].pointBorderColor[i] = "blue";
            myChart.config.data.datasets[0].pointRadius[i] = 1;
        }
        myChart.update();

        ajouterInfo();
    }
}


/* function clearPolylines() {
    var i = 0;
    map.eachLayer(function(layer) {
        if (i > 1) {
            if (layer instanceof L.Polyline) {
                console.log(layer);
                layer.remove();
            }
        }
        i++;
    });
} */

function clearSections() {
    sectionsList.forEach(element => map.removeLayer(element));
    for (i = 0; i < Object.keys(eles).length; i++) {
        myChart.config.data.datasets[0].pointRadius[i] = 0;
    }
    myChart.update(0);
}

function ajouterInfo() {
    nombreDeSections++;
    /*  $("#sectionInfo").append("<h5>Section " + nombreDeSections + "</h5>");
     $("#sectionInfo").append("<ul>"); */

    len = Object.keys(sectionEles).length;

    //calcul distance - Haversine formula
    distance = Math.round(sectionCoords[0].distanceTo(sectionCoords[len - 1]));

    //calcul pente - pente (%) = 100 x hauteur / distance horizontale.
    hauteurMax = sectionEles[len - 1];
    hauteurMin = sectionEles[0];
    hauteur = hauteurMax - hauteurMin;
    pente = Math.round(100 * hauteur / distance * 100) / 100;

    //calcul vitesse moyenne
    temps1 = sectionTemps[0];
    temps2 = sectionTemps[len - 1];
    diff = Math.abs(temps1 - temps2);
    vitesse = 3600 * distance / diff; // m/ms -> km/h = *3600

    /* $("#sectionInfo").append("<li> Distance : " + distance + "m</li>");
    $("#sectionInfo").append("<li> Temps : " + millisToMinutesAndSeconds(diff) + "</li>");
    $("#sectionInfo").append("<li> Pente moyenne : " + pente + "%</li>");
    $("#sectionInfo").append("<li> Vitesse moyenne : " + Math.round(vitesse * 100) / 100 + "km/h</li>");
    $("#sectionInfo").append("</ul><br>"); */


    $("#sectionInfo").append("<tr>");
    $("#sectionInfo").append(`<th>` + nombreDeSections + `</th>`);
    $("#sectionInfo").append("<td>" + distance + "m</td>");

    $("#sectionInfo").append("<td>" + millisToMinutesAndSeconds(diff) + "</td>");
    $("#sectionInfo").append("<td>" + Math.round(vitesse * 100) / 100 + "km/h</td>");
    $("#sectionInfo").append("<td>" + pente + "%</td>");

    $("#sectionInfo").append("</tr>");

    /* <
    td > Mark < /td> <
        td > Otto < /td> <
        td > @mdo < /td> <
        /tr> */
}

function millisToMinutesAndSeconds(millis) {
    var minutes = Math.floor(millis / 60000);
    var seconds = ((millis % 60000) / 1000).toFixed(0);
    return minutes + ":" + (seconds < 10 ? '0' : '') + seconds;
}


console.log("test");

/* console.log("section test");
console.log(sectionCoords);
console.log(sectionEles);
console.log(sectionTemps); */
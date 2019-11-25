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
    //renderChart(eles, labels, "chart2");
    //renderChart(eles, labels, "chart3");

    //affichage du premier point sur la map
    var greenIcon = L.icon({
        iconUrl: 'img/depart.png',
        iconSize: [50, 25],
        iconAnchor: [50, 25],
    });

    L.marker([xmlDoc.getElementsByTagName("trkpt")[0].attributes["lat"].value,
            xmlDoc.getElementsByTagName("trkpt")[0].attributes["lon"].value
        ], {
            icon: greenIcon
        })
        .addTo(map);

    //affichage du denier point point sur la map
    L.marker([
            xmlDoc.getElementsByTagName("trkpt")[coordsLen - 1].attributes["lat"].value,
            xmlDoc.getElementsByTagName("trkpt")[coordsLen - 1].attributes["lon"].value, {
                color: 'red'
            }
        ])
        .addTo(map);

    //affichage parcours
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


//affiche une stats
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

    limites = []
        // altitude     ]
        // temps        |-----> table de 100 elements
        // coords       ]


    console.log("eles : " + Object.keys(eles).length);

    var ctx = document.getElementById(name).getContext('2d');
    window.myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: new Array(Object.keys(eles).length),
            datasets: [{
                data: eles,
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    ticks: {}
                }],
                xAxes: [{
                    ticks: {}
                }]
            },
            onClick: clickEvent,
            elements: {
                point: {
                    radius: 0
                }
            },
            tooltips: {
                mode: 'index',
                intersect: false
            },
            hover: {
                mode: 'index',
                intersect: false
            }
        },

        label: "alt",

    });


    Chart.defaults.global.legend.display = false;
    Chart.defaults.global.tooltips.enabled = false;
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

function clickEvent(c, i) {
    e = i[0];
    console.log("index", e._index)
    var x_value = this.data.labels[e._index];
    var y_value = this.data.datasets[0].data[e._index];
    console.log("x value", x_value);
    console.log("y value", y_value);

    limites.push(e._index);

    section = [];
    dats = []

    //tous les deux clics
    if (Object.keys(limites).length >= 2) {
        console.log("deuxieme clic");

        lat = [];
        long = [];


        //a changer
        x1 = limites[0];
        x2 = limites[1];

        console.log("len " + Object.keys(latlngs).length);

        if (x2 < x1) {
            tmp = x2;
            x2 = x1;
            x1 = tmp;
            console.log("oui");
        }

        console.log("x1: " + x1 + " " + "x2: " + x2);

        for (i = x1; i < x2; i++) {

            section.push(new L.LatLng(latlngs[i][0], latlngs[i][1]));

        }

        new L.polyline(section, {
            color: 'blue',
            weight: 3,
            opacity: 0.3,
            smoothFactor: 1
        }).addTo(map);

        limites = [];
    }
}


function clearPolylines() {

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
}
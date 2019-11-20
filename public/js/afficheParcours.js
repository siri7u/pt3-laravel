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

    $("#logs").empty();
    $("#temp-f").empty();

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

    var latlngs = [];
    var eles = [];
    var times = [];

    //extrait et stock les coordonnées dans latlngs
    for (i = 0; i < coordsLen; i++) {

        var lat = parseFloat(coords[i].attributes["lat"].value);
        var long = parseFloat(coords[i].attributes["lon"].value);

        latlngs.push([lat, long]);

        for (var j = 0; j < coords[i].childNodes.length; j++) {
            if (coords[i].childNodes[j].nodeName == "ele") {

                eles.push(parseFloat(coords[i].childNodes[j].childNodes[0].data));
            }
            if (coords[i].childNodes[j].nodeName == "time") {

                times.push(new Date(coords[i].childNodes[j].childNodes[0].data));
            }

        }

        var p = $("<tr><td>" + lat + "</td><td>" + long + "</td></tr>");
        $("#logs").append(p);

    }

    console.log(eles);
    data = [];
    var labels = new Array(100);

    renderChart(eles, labels, "chart1");
    renderChart(eles, labels, "chart2");
    renderChart(eles, labels, "chart3");

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
        color: 'red'
    }).addTo(map);

    // centre la map sur le parcours
    map.fitBounds(polyline.getBounds());

}


// affiche une map vide, placé dans la div id=map (marche pas)
function afficheMap() {

    var map = L.map('map').setView([0, 0], 1);
    L.tileLayer('https://api.maptiler.com/maps/streets/{z}/{x}/{y}.png?key=CZhoDNPVBHSRiPKPQGHH', {
        tileSize: 512,
        zoomOffset: -1,
        minZoom: 1,
        //attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">© MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">© OpenStreetMap contributors</a>',
        crossOrigin: true
    }).addTo(map);

}

//affiche une stats
function renderChart(data, labels, name) {
    var ctx = document.getElementById(name).getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{

                data: data,
            }]
        },
        label: "alt",
    });
    Chart.defaults.global.legend.display = false;
    Chart.defaults.global.tooltips.enabled = false;
}
/*
 *   Permet de lire un fichier GPX et de l'afficher sous forme de map
 */



function readFile(input) {

    let file = input.files[0];
    let reader = new FileReader();



    reader.readAsText(file);

    //se lance quand le fichier charge
    reader.onload = function() {

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
        var xmlDoc = parser.parseFromString(reader.result, "text/xml");

        //change le placeholder du fileinput pour afficher le nom du fichier
        $("#placegolder").ready(function() {
            //console.log("oui");

            // alert($("#placegolder").attr("placeholder"));
            $("#placegolder").attr("placeholder", file.name + " " + Math.round(file.size / 1024) + " ko");

        });

        //on commence à décoder xmlDoc
        var coords = xmlDoc.getElementsByTagName("trkpt");
        var coordsLen = coords.length;


        var latlngs = [];
        var eles = [];
        var times = [];



        function affiche() {
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



            // console.log(times);
            //affichage du premier point sur la map
            var greenIcon = L.icon({
                iconUrl: 'img/depart.png',
                iconSize: [50, 25],
                iconAnchor: [50, 25],
            });

            L.marker([xmlDoc.getElementsByTagName("trkpt")[0].attributes["lat"].value,
                    xmlDoc.getElementsByTagName("trkpt")[0].attributes["lon"].value
                ], { icon: greenIcon })
                .addTo(map);

            //affichage du denier point point sur la map
            L.marker([
                    xmlDoc.getElementsByTagName("trkpt")[coordsLen - 1].attributes["lat"].value,
                    xmlDoc.getElementsByTagName("trkpt")[coordsLen - 1].attributes["lon"].value,
                    { color: 'red' }
                ])
                .addTo(map);

            //affichage parcours
            var polyline = L.polyline(latlngs, { color: 'red' }).addTo(map);

            // centre la map sur le parcours
            map.fitBounds(polyline.getBounds());
        }

        //cas erreur fichier
        if (coordsLen === 0) {
            $("#logs").empty();
            $(".temp").empty();
            $("#table").hide();
            $(".boxalert").append("<div class=\"alert alert-dismissible alert-danger\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button><strong>ERREUR : </strong> <a href=\"#\" class=\"alert-link\">Erreur fichier</a> Veuillez charger un fichier GPX valide");

            //cas tout est ok
        } else {
            $(".temp").empty();
            $(".boxalert").empty();
            $("#table").show();
            $("#table").append("<thead><tr><th>lon</th><th>lat</th></tr></thead>");
            affiche();


            data = [];
            var labels = new Array(100);


            renderChart(eles, labels, "chart1");
            renderChart(data, labels, "chart2");


        }
    };

    reader.onerror = function() {
        console.log(reader.error);
    };

}

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
    });
}
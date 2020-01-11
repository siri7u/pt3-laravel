<div class="card" style="height: 100%">

    <div class="card-header" id="titre-carte">
        <h4 class="card-title" id="type-donne">Aucune donnée</h4>
    </div>

    <div class="card-body">
            
            <canvas id="chart1"></canvas>
    </div>

    <div class="card-footer" style="padding-bottom: 0px;">

        <div class="row " style="margin:0; padding:0">

            <div class="col-sm-4">
            <ul class="pagination">

                <li class="page-item active" id="item1">
                    <a class="page-link" href="#">1</a>
                </li>

                <li class="page-item" id="item2">
                    <a class="page-link" href="#" >2</a>
                </li>

                <li class="page-item" id="item3">
                    <a class="page-link" href="#" >Supprimer</a>
                </li>

            </ul>
        </div>


        <div class="col-sm-8 ">
            @include('formulaire') {{--formulaire.blade.php--}}
            
        </div>
        
    </div>
</div>

<script>

$(document).ready(function() {

    //altitude
    $( "#item1" ).click(function() {
        $( "#item2").removeClass("active");
        $( "#item1").addClass("active");


   
        var labels = new Array(Object.keys(eles).length);
        console.log(labels.length);
        /* var eles = [];

        for (let i = 0; i < 100; i++) {
            eles.push(Math.floor(Math.random() * 100) + 50);
        } */

        myChart.config.data = {
                labels: labels,
                datasets: [{
                    data: eles,
                    pointBackgroundColor: [],
                pointBorderColor: [],
                pointRadius: [],
            }]
        }

        myChart.update();

    

        $("#type-donne").text("Altitude");


    });

    //données randoms
    $( "#item2" ).click(function() {
        $( "#item1").removeClass("active");
        $( "#item2").addClass("active");
        
        var labels = new Array(Object.keys(eles).length);
        console.log(labels.length);

         var len = Object.keys(eles).length;

        rand = [];

        for (let i = 0; i < len; i++) {
            rand.push(Math.floor(Math.random() *3));
        }  

        myChart.config.data = {
                labels: labels,
                datasets: [{
                data: rand,
                pointBackgroundColor: [],
                pointBorderColor: [],
                pointRadius: [],
            }]
        }

        myChart.update();

    
        
        $("#type-donne").text("Hearth rate");

    });

    $( "#item3" ).click(function() {
        /* $( "#item1").removeClass("active");
        $( "#item2").removeClass("active"); */

        //efface toutes les sections selectionnées
        clearSections();
        //vide la balise html
        $("#sectionInfo").empty();

        

        //window.myChart.destroy();
        /* myChart.config.data = {
            labels: [],
            datasets: [{
                data: [],

            }]
        }
        myChart.update();
        $("#type-donne").text("Aucune donnée"); */
    });


});

</script>









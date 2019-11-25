@extends('layouts.app')

<head>
    <!--<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script> -->
    
{{--         <link rel="stylesheet" href="styles/bootstrap.min.css">
    <script type="text/javascript" src="scripts/bootstrap-filestyle.min.js"></script> --}}
    

   
    <title>PT3</title>
    <script src="{{ asset('js/afficheStats.js')}}"></script>
    <script src="{{ asset('js/afficheParcours.js')}}"></script>
{{--     <script src="{{ asset('js/afficheMap.js')}}"></script> --}}

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://code.iconify.design/1/1.0.3/iconify.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.3.1/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0/dist/Chart.min.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.3.1/leaflet.css" />

    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />


</head>

@section('content')


<div class="container">

    <div class="panel panel-primary">

        <div class="panel-body">

            @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>

            @endif @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Attention!</strong> Il y a un problème avec votre fichier.
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <p></p>
            {{-- <form action="{{ route('tests1.upload.post') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <div class="col-md-6">
                        <input type="file" name="file" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <button type="submit" class="btn btn-success">Upload</button>
                    </div>

                </div>
            </form> --}}

            {{-- <div class="bootstrap-filestyle input-group">
                    <form action="{{ route('tests1.upload.post') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" id="input04" tabindex="-1" style="position: absolute; clip: rect(0px, 0px, 0px, 0px);">

                    <span class="group-span-filestyle input-group-btn" tabindex="0">
                        <label for="input04" style="margin-bottom: 0;" class="btn btn-secondary ">
                                <span class="iconify" data-icon="oi-folder"> </span>
                    <span class="buttonText"> Charger un fichier</span>
                    </label>
                    </span>
                    <button type="submit" class="btn btn-success">Upload</button>
            </div> --}}
<br>
            <!-- aucun fichier envoyé, alors on affiche un map vide -->
            @if (empty(Session::get('filecontent')))


                <div class="container">
                    <div class="row">
                            <div class="col" id="map" style="background-color:darkseagreen">
                                @include('map') {{--map.blade.php--}}
                            </div>
                            
                            <div class="col">
                                @include('statshtml') {{--map.blade.php--}}   
                            </div>
                    </div>
                </div>

            @endif

            <!-- si fichier envoyé, alors on affiche le parcours et les graphs-->
            @if ($filecontent = Session::get('filecontent') )
            
                    <div class="row">
                        <div class="col-sm-8"><div id="map"></div></div>
                        @include('map') {{--map.blade.php--}}</div>
                        <div class="col-sm-4">@include('statshtml') {{--map.blade.php--}}</div>
                </div>
        

                <script>
                    afficheParcours("{{ $filecontent }}",true)
                </script>

                <br>
                <br>

                <!-- affiche les statistiques -->
                <script type="application/javascript">
                    //pas ici, dans afficheParcours, pas encore de focntion car ça marche pas
                </script>
            @endif

        </div>
    </div>
</div>

<!-- affiche les parcours utilisateur -->
<div class="container">

    <div class="row justify-content-start">
    @if (isset($posts))
        <br>
        
        <p style="background-color:blue"></p>
        @foreach ($posts as $post)

    
            {{-- parcours nom, id image --}}
            <div class="col-3">
            <br>
                <div class="card" style="width: 14rem;" id="{{ $post->id}} btn">
                    <div class="card-body">
                        <h5 class="card-title">                     ID post {{ $post->id}}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">  Id createur {{ $post->cid}}</h6>
                        <p class="card-text">                       Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam dolorum ullam iusto sunt, dicta quod consequatur sapiente vero ipsum. Voluptatibus?</p>
                        <a href="#" class="card-link">

                            <div id={{ $post->id}} style="background:darkcyan; padding-left: 50px; padding-top: 5px; padding-bottom: 5px; cursor: pointer;">Cliquer ici</div>
                                <script>
                                    var test = document.getElementById({{ $post->id}});
                                    test.onclick = function() {

                                        $( "#item2").removeClass("active");
                                        $( "#item1").addClass("active");

                                        if (typeof myChart !== 'undefined') {
                                            window.myChart.destroy();
                                        }

                                        if (typeof eles !== 'undefined') {
                                            var labels = new Array(100);
                                            renderChart(eles, labels, "chart1");
                                            $("#type-donne").text("Altitude");
                                        } else {
                                            $("#type-donne").text("Aucune donnée");
                                        }

                                        $("#type-donne").text("Altitude");
                                        afficheParcours("{{ $post->data}}", false)
                                        
                                    }
                            </script>
                        </a>
                    </div>
                </div>
            </div>

            {{-- aaa --}}
        @endforeach 
        </div>
        
    @endif 
</div>
</div>
<br>
</div>

@endsection
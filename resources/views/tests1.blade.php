@extends('layouts.app')

<head>
    <!--<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
    <link rel="stylesheet" href="styles/bootstrap.min.css
    <script type="text/javascript" src="scripts/bootstrap-filestyle.min.js"></script>
    ">

    -->
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

    <style>
        #map {
            height: 400px;
        }
    </style>
</head>

@section('content')

<div class="container">

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h2>Formulaire laravel</h2></div>
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
            <form action="{{ route('tests1.upload.post') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <div class="col-md-6">
                        <input type="file" name="file" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <button type="submit" class="btn btn-success">Upload</button>
                    </div>

                </div>
            </form>

            <!-- si aucun fichier envoyé, alors on affiche un map vide-->
            @if (empty(Session::get('filecontent')))
                <div id="map" class></div>

                <script type="application/javascript">
                    var map = L.map('map').setView([0, 0], 1);
                    L.tileLayer('https://api.maptiler.com/maps/streets/{z}/{x}/{y}.png?key=CZhoDNPVBHSRiPKPQGHH', {
                        tileSize: 512,
                        zoomOffset: -1,
                        minZoom: 1,
                        //attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">© MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">© OpenStreetMap contributors</a>',
                        crossOrigin: true
                    }).addTo(map);
                </script>

            @endif

            <!-- si fichier envoyé, alors on affiche le parcours et les graphs-->
            @if ($filecontent = Session::get('filecontent') )
                <div id="map" class></div>

                <script>
                    var map = L.map('map').setView([0, 0], 1);
                    L.tileLayer('https://api.maptiler.com/maps/streets/{z}/{x}/{y}.png?key=CZhoDNPVBHSRiPKPQGHH', {
                        tileSize: 512,
                        zoomOffset: -1,
                        minZoom: 1,
                        //attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">© MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">© OpenStreetMap contributors</a>',
                        crossOrigin: true
                    }).addTo(map);

                    afficheParcours("{{ $filecontent }}",true)
                </script>

                <br>
                <br>

                <!-- graph holder -->
                <div class="container">
                    <div class="card border-primary mb-3">
                        <div class="card-header">
                            <h4 class="card-title">Altitude</h4>
                            <div class="container">
                                <canvas id="chart1"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <div class="card border-primary mb-3" style="max-width: 40rem; min-height: 100%; height: 100%;">
                                <div class="card-header">
                                    <h4 class="card-title">1</h4>
                                    <div class="container">
                                        <canvas id="chart2"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="card border-primary mb-3" style="max-width: 40rem; min-height: 100%; height: 100%;">
                                <div class="card-header">
                                    <h4 class="card-title">2</h4>
                                    <div class="container">
                                        <canvas id="chart3"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- affiche les statistiques -->
                <script type="application/javascript">
                    //dans afficheParcours, pas encore de focntion
                </script>
            @endif

        </div>
    </div>
</div>

<!-- affiche les parcours utilisateur -->
<div class="container">
    <br>
    <h1>Mes parcours</h1>
    <div class="row">
    @if (isset($posts))
        <br>
        
        <p style="background-color:blue"></p>
        @foreach ($posts as $post)

    
            {{-- aaa --}}
            <div class="col">
            <br>
                <div class="card" style="width: 18rem;" id="{{ $post->id}} btn">
                    <div class="card-body">
                        <h5 class="card-title">ID post {{ $post->id}}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Id createur {{ $post->cid}}</h6>
                        <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam dolorum ullam iusto sunt, dicta quod consequatur sapiente vero ipsum. Voluptatibus?</p>
                        <a href="#" class="card-link">

                            <div id={{ $post->id}} style="background:darkcyan; padding-left: 50px; padding-top: 5px; padding-bottom: 5px; cursor: pointer;">Cliquer ici</div>
                                <script>
                                    var test = document.getElementById({{ $post->id}});
                                    test.onclick = function() {

                                        afficheParcours("{{ $post->data}}", false)
                                    }
                            </script>
                        </a>
                    </div>
                </div>
        </div>

            {{-- aaa --}}
        @endforeach 
        <</div>
    @endif
    <div class="container">
        <div class="card border-primary mb-3">
            <div class="card-header">
                <h4 class="card-title">Altitude</h4>
                <div class="container">
                    <canvas id="chart1"></canvas>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm">
                <div class="card border-primary mb-3" style="max-width: 40rem; min-height: 100%; height: 100%;">
                    <div class="card-header">
                        <h4 class="card-title">1</h4>
                        <div class="container">
                            <canvas id="chart2"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="card border-primary mb-3" style="max-width: 40rem; min-height: 100%; height: 100%;">
                    <div class="card-header">
                        <h4 class="card-title">2</h4>
                        <div class="container">
                            <canvas id="chart3"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>



<br>
</div>

{{--
<script type="application/javascript">
    //génère la map à mettre dans la div map
    var map = L.map('map').setView([0, 0], 1);
    L.tileLayer('https://api.maptiler.com/maps/streets/{z}/{x}/{y}.png?key=CZhoDNPVBHSRiPKPQGHH', {
        tileSize: 512,
        zoomOffset: -1,
        minZoom: 1,
        //attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">© MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">© OpenStreetMap contributors</a>',
        crossOrigin: true
    }).addTo(map);
</script> --}} 
@endsection
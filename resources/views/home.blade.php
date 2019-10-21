@extends('layouts.app')

<head>
    <!--<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
    <link rel="stylesheet" href="styles/bootstrap.min.css
    <script type="text/javascript" src="scripts/bootstrap-filestyle.min.js"></script>
    ">

    -->

    <script src="{{ asset('js/read.js')}}"></script>

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
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif You are logged in! {{ Auth::user()->name }}
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="container">

        <!--
    <div class="col-sm">
        <div class="card border-primary mb-3" style="max-width: 40rem; min-height: 100%; height: 100%;">
            <div class="card-header">

                <label>Charger un fichier </label>
                <div class="bootstrap-filestyle input-group">
                    <input type="file" id="input04" tabindex="-1" style="position: absolute; clip: rect(0px, 0px, 0px, 0px);" onchange="readFile(this)">

                    <input type="text" class="form-control " placeholder="No file" style="border-top-left-radius: 0.25rem; border-bottom-left-radius: 0.25rem;" id="placegolder">

                    <span class="group-span-filestyle input-group-btn" tabindex="0">
                        <label for="input04" style="margin-bottom: 0;" class="btn btn-secondary ">
                                <span class="iconify" data-icon="oi-folder"> </span>
                    <span class="buttonText"> Charger un fichier</span>
                    </label>
                    </span>
                </div>
            </div>

            <div class="card-body">
                <h4 class="card-title">
                    <div class="temp">Veuillez charger un fichier</div>
                    <br>
                    <div class="boxalert"></div>
                </h4>
                <p class="card-text ">
                    <div class="overflow-auto" style="margin-left:auto; margin-right:auto; height: 300px;">
                        <div class="table-wrapper-scroll-y my-custom-scrollbar">
                            <table class="table table-bordered table-striped mb-0" id="table">
                                <tbody id="logs"></tbody>
                            </table>
                        </div>
                    </div>
                </p>
            </div>
        </div>
    </div>-->

        <div class="row">
            <!------------>
            <div class="col-sm-8">
                <div class="card border-primary">
                    <div class="card-header">

                        <label>Charger un fichier </label>
                        <div class="bootstrap-filestyle input-group">
                            <input type="file" id="input04" tabindex="-1" style="position: absolute; clip: rect(0px, 0px, 0px, 0px);" onchange="readFile(this)">

                            <input type="text" class="form-control " placeholder="No file" style="border-top-left-radius: 0.25rem; border-bottom-left-radius: 0.25rem;" id="placegolder">

                            <span class="group-span-filestyle input-group-btn" tabindex="0">
                                <label for="input04" style="margin-bottom: 0;" class="btn btn-secondary ">
                                        <span class="iconify" data-icon="oi-folder"> </span>
                            <span class="buttonText"> Charger un fichier</span>
                            </label>
                            </span>
                        </div>
                    </div>

                    <div class="card-body">
                        <h4 class="card-title"></h4>
                        <p class="card-text ">
                            <!--Affiche la carte-->

                            <div id="map" class></div>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card border-primary" style=" height:100%">
                    <div class="card-body">
                        <h4 class="card-title">
                    <div class="temp">Veuillez charger un fichier</div>
                    <br>
                    <div class="boxalert"></div>
                </h4>
                        <p class="card-text ">
                            <div class="overflow-auto" style="margin-left:auto; margin-right:auto; height: 300px;">
                                <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                    <table class="table table-bordered table-striped mb-0" id="table">
                                        <tbody id="logs"></tbody>
                                    </table>
                                </div>
                            </div>
                        </p>
                    </div>
                </div>
            </div>
            <!--    ---------->
         


            @section('javascript')

            <script type="application/javascript">

                console.log("salut");
                var map = L.map('map').setView([0, 0], 1);
                L.tileLayer('https://api.maptiler.com/maps/streets/{z}/{x}/{y}.png?key=CZhoDNPVBHSRiPKPQGHH', {
                    tileSize: 512,
                    zoomOffset: -1,
                    minZoom: 1,
                    //attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">© MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">© OpenStreetMap contributors</a>',
                    crossOrigin: true
                }).addTo(map);
            
                </script>

            @endsection

        </div>

    </div>

    <br>

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
                            <canvas id="chart2"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
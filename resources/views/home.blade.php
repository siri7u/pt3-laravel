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

            <!-- on notifie l'utilisateur s'il n'est pas connecté -->
            @if (!Auth::user())
                <h1>Veuillez vous enregistrer ou vous connecter</h1><div class="links">
                    <button type="button" class="btn btn-primary btn-lg"><a href="{{ url('/register') }}">Register</a> </button>
                    <button type="button" class="btn btn-primary btn-lg">  <a href="{{ route('login') }}">Login</a></button>
                </div>      
            @endif
            @if (Auth::user())
                
<br>
            <!-- aucun fichier envoyé, alors on affiche un map vide -->
            @if (empty(Session::get('filecontent')))
                <div class="container">
                    <div class="row">
                        <div class="col" id="map" style="background-color:darkseagreen">
                            @include('map') {{--map.blade.php--}}
                        </div>
                        
                        <div class="col">
                            @include('statshtml') {{--statshtml.blade.php--}}   
                        </div>
                    </div>
                </div>
            @endif

            <!-- si fichier envoyé, alors on affiche le parcours et les graphs-->
            @if ($filecontent = Session::get('filecontent') )
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
                <!-- affiche le parcours -->
                <script>afficheParcours("{{ $filecontent }}",true)</script>
            @endif

           
        </div>
    </div>
</div>

<!-- affiche les parcours utilisateur -->
<div class="container">
    <div class="row">
        <div class="col"> <!-- première colone -->
            <br>
            <h4> Mes parcours </h4>
            
            <div class="row justify-content-start">
            @if (isset($posts))
                <p style="background-color:blue"></p>
                @foreach ($posts as $post)
                    
                
            
                    {{-- parcours nom, id image --}}
                    <div class="col-3">
                    
                        <div class="card" style="width: 8rem;" id="{{ $post->id}} btn">
                            <div class="card-body">
                                <h5 class="card-title">                     Parcours {{ $post->id}}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">  Id createur {{ $post->cid}}</h6>
{{--                                 <p class="card-text">                       Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam dolorum ullam iusto sunt, dicta quod consequatur sapiente vero ipsum. Voluptatibus?</p>
 --}}                                <a href="#" class="card-link">

                                    <div id={{ $post->id}} style="background:darkcyan; padding: 3px; cursor: pointer;"> Cliquer ici</div>
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
                                                afficheParcours("{{ $post->data}}", false);
                                                myChart.update();
                                                
                                            }
                                    </script>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- aaa --}}
                @endforeach 
                </div>
            </div>

            <div class="col">
                <br>
                <h4> Info sections </h4>
                
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Distance</th>
                        <th scope="col">Temps</th>
                        <th scope="col">Vitesse moyenne</th>
                        <th scope="col">Pente moyenne</th>
                      </tr>
                    </thead>

                    <tbody id="sectionInfo">

                    </tbody>

                  </table>
            </div>
        </div>
        
    @endif 
</div>

<br>
<br>
<h4> Ajouter un amis </h4>

{!! Form::open(array( 'route'=>'home.upload.post')) !!} 
    <div class="form-group">
        {!! Form::text('pid', 'ID Amis', ['class' => 'form-control', 'placeholder' => 'ID Ami', 'name' => 'ami']) !!}
    </div>
    {!! Form::submit('Sumbit', ['class' => 'btn btn-primary']) !!}

{!! Form::close() !!}
<br>



<br>



<h4> Parcours de mes amis </h4>


<div class="row justify-content-start">
    @if (isset($listeamis))
        <p style="background-color:blue"></p>
        @foreach ($listeamis as $post)
            
        
    
            {{-- parcours nom, id image --}}
            <div class="col-3">
            
                <div class="card" style="width;" id="{{ $post->id}} btn">
                    <div class="card-body">
                        <h5 class="card-title">                     Parcours {{ $post->id}}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">  Id createur {{ $post->cid}}</h6>
{{--                                 <p class="card-text">                       Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam dolorum ullam iusto sunt, dicta quod consequatur sapiente vero ipsum. Voluptatibus?</p>
--}}                                <a href="#" class="card-link">

                            <div id={{ $post->id}} style="background:darkcyan; padding: 3px; cursor: pointer;"> Cliquer ici</div>
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
                                        afficheParcours("{{ $post->data}}", false);
                                        myChart.update();
                                        
                                    }
                            </script>
                        </a>
                    </div>
                </div>
            </div>

            {{-- aaa --}}
        @endforeach 
        </div>
    </div>
    @endif


@endif
</div>
<br>


</div>

@endsection
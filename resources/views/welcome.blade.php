<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PT3</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('styles/bootstrap.min.css') }}" rel="stylesheet">

        <style>
            
			body { background-color:#E5D394;}
            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

			.header {
			overflow: hidden;
			background-color: #FDFBFB;
			width:100%;
			}
			.header a {
			float: left;
			color: #636b6f;;
			text-align: center;
			  padding: 12px;
			  text-decoration: none;
			  font-size: 18px;
			  line-height: 25px;
			  border-radius: 4px;
}
            .m-b-md {
                margin-bottom: 30px;
			}
			.btn-default {
				background-color: #fff;
				border-color: #dfdfe8;
            }
			.btn {
				align-items: left;
				border: 1px solid transparent;
				border-radius: 4px;
				cursor: pointer;
				display: inline-flex;
				-webkit-box-orient: horizontal;
				-webkit-box-direction: normal;
				transition: background-color 200ms ease, color 200ms ease, border-color 200ms ease;
				user-select: none;
				vertical-align: middle;
				white-space: nowrap;
				will-change: background-color, color, border-color;
			}
			a.btn {
				color: #292827;
				text-decoration: none;
				font-family: Impact, "Arial Black", Arial, Verdana, sans-serif;
				font-size: 30px;
			}
			.header-content nav {
				-webkit-box-flex: 1;
				-ms-flex: 1 1;
				flex: 1 1;
				text-align: right;
			}
			h2 {
				font-family: roboto;
			 font-size:55px;
			
			
			}
			#im1,#im2 {
				display : inline-block;
			}
			#im1 {
				float:left
				height:250;
				width:250;
				
			}
			.left { float:left; 
			position:absolute;
			margin:0 100px 0 20px; 
			margin-left:0px;
			
			}
			.right { float:right; 
			margin-left:780px;
			
			
			}
			.links > a {
				float: left;
                color: #636b6f;
                padding: 25 0px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
			footer {
			background-color:#292827;
			position: absolute;
			bottom:0;
			width:100%;
			
		
			padding-top:50px;
			padding-bottom:50px;
			
			padding:50px;
			height:50px;}
			p {	margin-left:580px;
				margin-bottom : 100px;
				font-size :53px;
				font-family: roboto;
				font-color:#CECBC0;
			}
			
}
        </style>
    </head>
	<header class="header">
		
			<div class="header">
				<div class="header-right">
						<a class="active" href="#home">Page d'acceuil</a>
						
							<a href="{{ url('/register') }}">S'enregistrer</a>
					

						<a href="{{ route('login') }}">Se connecter </a>
										
				</div>
</div>
			
			
	
	</header>
    <body>
        
            <!--@if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif-->

            <div class="main container">
                <h2 class="text-center">
                    Bienvenue
                </h2>
				<div class="main-content row">
					<div class="col-md-5 col-md-offset-1">
						<div class="text-left">
							<img class="left" src="{{ asset('img/sil.png')}}" height="418" width="350" style="float:left;margin:0 10px 0 20px;" ></img> 
						</div>
						
						<p></p>
					</div>
				</div>
				<p style="color:#716F6F">Profitez de notre application de partage des parcours</p>
			</div>	

                
                <br><br>
                
               

                <br><br>
				<footer class="footer">
					<div class="links">
                    <a href="https://laravel.com/docs">Comment ça marche ?</a>
					
					</div>
					<div class="text-right">
						<img class="right" src="{{ asset('img/logo.png')}}" height="45" width="300" style="float:left;"></img>
					</div>	
						
							
								
							
						
				
				</footer>
               
            </div>
        
    </body>
</html>

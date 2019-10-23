@extends('layouts.app')



@section('content')

    <div class="container">


        <h1>ID      : {{ Auth::user()->id }}</h1>
        <h1>MAIL    : {{ Auth::user()->name }}</h1>
        <h1>EMAIL   : {{ Auth::user()->email }}</h1>

    </div>

    <script>

        console.log( "{{ Auth::user()->name }}") ;
        console.log( "{{ Auth::user()->email }}") ;
        console.log( "{{ Auth::user()->password }}") ;

    </script>




@endsection


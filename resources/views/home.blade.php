@extends('layouts.app')

@section('content')


<div class="app-body">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif


    @if(Auth::check())
        @if (Auth::user()->rol == 1)
            @include('sidebarAdministrador')           
            <template v-if="menu==0">
                <usuarios></usuarios>
            </template>
            <template v-if="menu==1">
                <quienes></quienes>
            </template>
            
        @else
            @include('sidebarUsuario')           
            <template v-if="menu==0">
                <adopcion></adopcion>
            </template>
            <template v-if="menu==1">
                <adopcion></adopcion>
            </template>
            <template v-if="menu==2">
                <quienes-somos></quienes-somos>
            </template> 
        @endif
    @endif

  

      
@endsection

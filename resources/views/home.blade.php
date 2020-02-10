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
                <h1>modulo adaopcion</h1>
            </template>
            <template v-if="menu==1">
                <h1>modulo clientes</h1>
            </template>
            <template v-if="menu==2">
                <h1>modulo consulta</h1>
            </template>
            <template v-if="menu==3">
                <h1>modulo informacion</h1>
            </template>
            <template v-if="menu==4">
                <donaciones></donaciones>
            </template>
            <template v-if="menu==5">
                <usuarios></usuarios>
            </template>
            <template v-if="menu==6">
                <quienes-somos></quienes-somos>
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

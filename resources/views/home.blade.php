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
            @include('sidebarAdministrador') <!---Administrador-->        
            <template v-if="menu==0">
                <inicio-general></inicio-general>
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
                <registrar-donaciones></registrar-donaciones>
            </template>
            <template v-if="menu==5">
                <registrar-usuarios></registrar-usuarios>
            </template>
            <template v-if="menu==6">
                <quienes-somos></quienes-somos>
            </template>
            
        @elseif (Auth::user()->rol == 2)<!---Cliente-->
            @include('sidebarCliente') 
            <template v-if="menu==0">
                <inicio-general></inicio-general>
            </template>
            <template v-if="menu==1">
                <informacion-general></informacion-general>
            </template>
            <template v-if="menu==2">
                <h1>visualizar consulta</h1>
            </template>
            <template v-if="menu==3">
                <h1>modulo dar en adopcionnnnnnnnnnn</h1>
            </template>
            <template v-if="menu==4">
                <h1>modulo adopcionnnnnnnnnnnnn</h1>
            </template>
            <template v-if="menu==5">
                <quienes-somos></quienes-somos>
            </template>
            

        @else
            @include('sidebarUsuario')<!---Usuario-->
            <template v-if="menu==0">
                <inicio-general></inicio-general>
            </template>
            <template v-if="menu==1">
                <informacion-general></informacion-general>
            </template>
            <template v-if="menu==2">
                <h1>modulo de adopcion</h1>
            </template>
            <template v-if="menu==3">
                <h1>modulo dar en adopcion</h1>
            </template>
            <template v-if="menu==4">
                <h1>visualizar consulta</h1>
            </template>
            <template v-if="menu==5">
                <quienes-somos></quienes-somos>
            </template>
        @endif
    @endif

  

      
@endsection

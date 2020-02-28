@extends('layouts.app')

@section('content')


<div class="app-body">
  <!--  @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif-->


    @if(Auth::check())
        @if (Auth::user()->rol == 0)
            @include('sidebarAdministrador') <!---Administrador-->        
            <template v-if="menu==0">
                <inicio-general></inicio-general> <!-----TODOS LOS USUARIOS--->
    
            </template>

            <template v-if="menu==1">
                <registrar-clientes></registrar-clientes>
            </template>

            <template v-if="menu==2">
                <registrar-mascota></registrar-mascota>
            </template>

            <template v-if="menu==3">
                <registrar-consulta></registrar-consulta>
            </template>

            <template v-if="menu==4">
                <registrar-informacion></registrar-informacion>
            </template>
            
            <template v-if="menu==5">
                <registrar-donaciones></registrar-donaciones>
            </template>

            <template v-if="menu==6">
                <registrar-datos></registrar-datos> 
            </template>

            <template v-if="menu==7">
                <registrar-adopcion></registrar-adopcion> 
            </template>

            <template v-if="menu==8">
                <inicio-adopcion></inicio-adopcion> <!-----TODOS LOS USUARIOS--->
            </template>

            <template v-if="menu==9">
                <registrar-usuarios></registrar-usuarios>
            </template>
            <template v-if="menu==10">
                <quienes-somos></quienes-somos>
            </template>

            
            
        @elseif (Auth::user()->rol == 2)<!---Cliente Rol 2-->
            @include('sidebarCliente') 
            <template v-if="menu==0">
                <inicio-general></inicio-general>  <!-----TODOS LOS USUARIOS--->
            </template>
            <template v-if="menu==1">
                 <informacion-general></informacion-general>  <!-----TODOS LOS USUARIOS--->
                
            </template>
            <template v-if="menu==2">
                <vizualizar-consulta></vizualizar-consulta>
            </template>
            <template v-if="menu==3">
                <inicio-adopcion></inicio-adopcion> <!-----TODOS LOS USUARIOS--->
            </template>
            <template v-if="menu==4">
                <registrar-adopcion-cliente></registrar-adopcion-cliente> 
            </template>
            <template v-if="menu==5">
                <edicion-usuarios></edicion-usuarios>
            </template>
            <template v-if="menu==6">
            <quienes-somos></quienes-somos>
            </template>
            
            

        @else
            @include('sidebarUsuario')<!---Usuario --- Rol 1-->
            <template v-if="menu==0">
                <inicio-general></inicio-general>  <!-----TODOS LOS USUARIOS--->
            </template>

            <template v-if="menu==1">
                <informacion-general></informacion-general> <!-----TODOS LOS USUARIOS--->
            </template>

            <template v-if="menu==2">
                <inicio-adopcion></inicio-adopcion> <!-----TODOS LOS USUARIOS--->
            </template>

            <template v-if="menu==3">
                <registrar-datos-user></registrar-datos-user> 
            </template>

            <template v-if="menu==4">
                <registrar-adopcion-user></registrar-adopcion-user> 
            </template>

            <template v-if="menu==5">
                <edicion-usuarios></edicion-usuarios>
            </template>

            <template v-if="menu==6">
                <quienes-somos></quienes-somos>
            </template>
        @endif
    @endif      
@endsection

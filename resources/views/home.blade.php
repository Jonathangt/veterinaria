@extends('layouts.app')

@section('content')


<div class="app-body">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif


    @if(Auth::check())
        @if (Auth::user()->Rol == 1)
            @include('sidebarAdministrador')           
            <template v-if="menu==0">
                <quienes-somos></quienes-somos>
            </template>
            <template v-if="menu==1">
                <quienes></quienes>
            </template>
            
        @else
            @include('sidebarUsuario')           
            <template v-if="menu==0">
                <quienes-somos></quienes-somos>
            </template>
            <template v-if="menu==1">
                <quienes></quienes>
            </template> 
        @endif
    @endif
    
      
@endsection

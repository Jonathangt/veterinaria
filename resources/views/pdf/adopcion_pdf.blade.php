<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @foreach ($adopcion as $v)
    <title>Información de {{$v->nombreMascota}}</title>
    <style>
        #red{
            color: #F0380A;
        }

        body {
            font-family: Arial, sans-serif; 
            font-size: 13px;
        }
    
        section{
            clear: left;
        }

        #imagen{
            width: 170px;
        }

        #logo{
            float: left;
            margin-top: 1%;
            margin-left: 2%;
            margin-right: 2%;
        } 

        #imagenAdpcion{
            float: right;
            margin-top: -25%;
            margin-left: 5%;
            margin-right: 2%;
        }     

       
        #encabezado{
            text-align: center;
            margin-top: -4%;
           /* margin-right: 2%;*/
            font-size: 15px;
        }


    </style>
    <body>
       
        <header>
            <div id="logo">
                <img src="img/About.png" alt="Dobaltoff" id="imagen">
                <div id="encabezado">
                    <b>VETERINARIA DOBALTOFF</b>
                    <br><span>Mucho Lote 2 (12,18 km), Guayaquil</span>
                    <br><span>Telefono: 0990423246</span>
                    <br><span>Horario de atención de 10:00am a  19:00pm</span>
                    <br><br><b id="red">TU ACCIÓN PUEDE CAMBIAR VIDAS, ADOPTA UN MASCOTA</b>
            </div>
            </div>
        </header>
        <br>
        <section>
            <div>
                <span><br><br><br><br>
                    <b><i style='font-size: 15px'>{{$v->nombreMascota}} </i></b><br><br>
                    <b>Fecha de Nacimiento:</b>  {{$v->fechaNacimiento}}<br>
                    <b>Edad:</b>  {{$v->edad}}<br>
                    <b>Especie:</b>  {{$v->especie}}<br>
                    <b>Raza:</b>  {{$v->raza}}<br>
                    
                    <b>Observación:</b> <p style='width:400px'>{{$v->observacion}}</p> <br>
                  
                </span>

                
                <div id="imagenAdpcion"> <br><br><br>
                        <img src="mascotas/{{$v->imagen}}" alt="Informacion" width="40%" height="40%">
                </div>

                <div>
                    <span><br>
                        <b>Contáctame</b><br>
                        <b>Celular:</b>  {{$v->celular}}<br>
                        <!-- <b>Télefono:</b>  {{$v->telefono}}<br> -->
                        <b>Email:</b>  {{$v->email}}<br>

                    </span>
                </div>
            </div>
        </section>
        @endforeach
</html>

<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Consulta</title>
    <style>
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

       
        #encabezado{
            text-align: center;
            margin-top: -4%;
           /* margin-right: 2%;*/
            font-size: 15px;
        }


    </style>
    <body>
        @foreach ($diagnostico as $v)
        <header>
            <div id="logo">
                <img src="img/About.png" alt="Dobaltoff" id="imagen">
                <div id="encabezado">
                    <b>VETERINARIA DOBALTOFF</b>
                    <br><span>Mucho Lote 2 (12,18 km), Guayaquil</span>
                    <br><span>Telefono: 0990423246</span>
                    <br><span>Horario de atención de 10:00am a  19:00pm</span>
            </div>
            </div>
        </header>
        <br>
        <section>
            <div>
                <span><br><br><br>
                    <b>Fecha y hora de consulta:</b> {{$v->fechaAtencion}} - {{$v->horaAtencion}}<br>
                    <b>Atendido por:</b>  {{$v->name}}<br><br>
                </span>

                <div>
                    <span><br>
                        <b>Cliente:</b> {{$v->apellidos}} {{$v->nombre}}<br>
                        <b>Cédula:</b>  {{$v->cedula}}<br><br>
                    </span>
                </div>

                <div>
                    <span><br>
                        <b>Mascota:</b> {{$v->nombreMascota}}<br>
                        <b>Sexo:</b>  {{$v->sexo}}<br>
                        <b>Raza:</b>  {{$v->raza}}<br>
                        <b>Esterelizado:</b>  {{$v->esterilizado}}<br>
                        <b>Procedimiento:</b>  {{$v->tipoProcedimiento}}<br>
                        <b>Modo de Obtención:</b>  {{$v->modoOptencion}}<br><br>
                        <b>Observación Consulta:</b>  {{$v->observacionDiagnostico}}<br>                      
                    </span>
                </div>

                <div>
                    <span><br>
                        <b>Medicamento:</b> {{$v->medicamento}}<br><br>
                        <b>Horario:</b>  {{$v->horario}}<br><br>
                        <b>Observación:</b>  {{$v->observacionReceta}}<br><br>
                    </span>
                </div>          
            </div>
        </section>
        @endforeach
</html>

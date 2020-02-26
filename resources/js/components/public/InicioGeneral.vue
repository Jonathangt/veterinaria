<template>
    <main class="main">
        <ol>        
        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                 <!--    <i class="icon-paper-clip"></i> ¿Quiénes somos? -->
                </div>
                <template>
                    <div class="card-body">


                         <div class="form-group row">
                            <div class="col-md-12">
                                <div class="form-group centerTabla"><br>
                                <!--    <h2>Veterinaria Dobaltoff</h2><br>-->
                                    <h5 >ÚNETE AL RESCATE PROTECCION Y BIENESTAR ANIMAL</h5>
                                    <div class="form-group">
                                        <img src="img/About.jpg" alt="Dobaltoff" width="300" height="200">
                                    </div>
                                </div>
                            </div>

                        </div><!--- fin form group-------->

                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="form-group centerTabla"><br>
                                <!--    <h2>Veterinaria Dobaltoff</h2><br>-->
                                    <h6 id="red">¿DESEA ADOPTAR O DAR EN ADOPCIÓN UNA MASCOTA? 
                                        <a href="/register">Registrese</a> ó 
                                        <a href="/login">Inicie Sesión</a></h6>
                                   
                                </div>
                            </div>

                        </div><!--- fin form group-------->


                        <!-------carousel de imagenes------->

                         <inicio-imagenes></inicio-imagenes>


            
                        <br>
                        <br>
                        <center>
                            <div class="col-md-12">
                            <video  width="400" height="400" controls>
                                <source src="video/VID-20200212-WA0018.mp4" type="video/mp4">
                                <source src="movie.ogg" type="video/ogg">
                                    Su navegador no soporta la etiqueta de vídeo.
                                </video>
                        </div>
                        </center>

                        <br><br>
                        <!--seccion footer-->
                        <h6><p id="red" class="centerTabla">TU ACCIÓN PUEDE CAMBIAR VIDAS, ADOPTA UN MASCOTA</p></h6> 

                        <div  class="centerTabla">
                            <p>Estamos ubicados en Mucho Lote 2 (12,18 km) Guayaquil   <i class="icon-phone"> 0990423246</i> </p>
                            <p>De Luenes a Viernes nuestro horario de atención desde: 10:00 am hasta las 19:00 pm</p>
                        </div>

                        <div class="centerTabla">
                            <ul class="navega">
                                <li><b>Consultas a domicilio🐾</b></li>
                                <li><b>Exámen de laboratorio🔬</b></li>
                                <li><b>Desgarrapatización🐕</b></li>
                            </ul>
                        </div>

                        <div class="centerTabla">
                            <ul class="navega">
                                
                                <li><b>Baños medicados 🚿 Baños en seco🐈</b></li>
                                <li><b>Cirugías📁</b></li>
                                <li><b>Tratamientos</b></li>
                                <li><b>Vacunas💉 Desparasita</b></li><br><br>
                            </ul>
                        </div>

                       
                           
                              <visualizar-donaciones></visualizar-donaciones>
                           
                        


                        <div class="centerTabla"><br>
                            <label for=""><i>Conoce más de nosotros</i></label><br>
                            <a target="_blank" href="https://www.facebook.com/vetdobaltoff/"> <button type="button" class="btn btn-facebook">Fa</button></a>
                            <a target="_blank" href="https://www.instagram.com/veterinariadobaltoff/"> <button type="button" class="btn btn-instagram">Fa</button></a>
                           <!--  <a target="_blank" href="https://www.google.es/"> <button type="button" class="btn btn-twitter">Fa</button></a> -->
                        </div>
                        <!--fin seccion footer-->

                   </div>    <!-- fin div card body -->
                    <br>
                </template>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
    </main>
</template>


<!-- End Bootstrap Carousel HEAD section -->


<style>

    #Comunicate{
         color:  #F08022 
    }

     ul.navega li {
        display: inline;
    }

   

  /*  .carousel-inner{
    height: 400px;
    }

    #imagenCarousel {
        width: 70%;
        height: 700%;
    }*/

    
    #labelContacto {
        display: inline-block !important;
        margin-bottom: .5rem !important;
    }

      
    #imagen{
        width: 340px;
        text-align: right;
    }

    #red{
         color: #F0380A;
    }

    
   
    #letra{
         color: #EA9A3B;
    }

    .centerTabla {
        text-align: center;
    }


</style> 

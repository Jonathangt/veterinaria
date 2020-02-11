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
                                    <h2>Veterinaria Dobaltoff</h2><br>
                                    <h6 id="letra">ÚNETE AL RESCATE PROTECCIóN Y BIENESTAR ANIMAL</h6>
                                    <div class="form-group">
                                        <img src="img/About.png" alt="Dobaltoff" id="imagen">
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="5"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="6"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">                            
                                <img  width="100" height="400" src="img/inicio/inicio_2.jpeg" alt="">
                            </div>
                            <div class="carousel-item active">                            
                                <img  width="100" height="400" src="img/inicio/inicio_4.jpeg" alt="">
                            </div>
                            <div class="carousel-item">
                                <img  width="800" height="400" src="img/inicio/inicio_5.jpeg" alt="">
                            </div>
                            <div class="carousel-item">
                                <img  width="800" height="400" src="img/inicio/inicio_6.jpeg" alt="">
                            </div>
                             <div class="carousel-item">
                                <img  width="800" height="400" src="img/inicio/inicio_7.jpeg" alt="">
                            </div>
                            <div class="carousel-item">
                                <img  width="800" height="400" src="img/inicio/inicio_8.jpeg" alt="">
                            </div>
                            <div class="carousel-item">
                                <img  width="800" height="400" src="img/inicio/inicio_9.jpeg" alt="">
                            </div>
                            <div class="carousel-item">
                                <img  width="800" height="400" src="img/inicio/inicio_10.jpeg" alt="">
                            </div>
                            <div class="carousel-item">
                                <img  width="800" height="400" src="img/inicio/inicio_11.png" alt="">
                            </div>
                            <div class="carousel-item">
                                <img  width="800" height="400" src="img/inicio/inicio_12.png" alt="">
                            </div>
                            <div class="carousel-item">
                                <img  width="800" height="400" src="img/inicio/Screenshot_55.png" alt="">
                            </div>
                            <div class="carousel-item">
                                <img  width="800" height="400" src="img/inicio/Screenshot_56.png" alt="">
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                        </div>



                        <br><br>
                        <!--seccion footer-->
                        <h6><p id="red" class="centerTabla">TU ACCIÓN PUEDE CAMBIAR VIDAS, ADOPTA UN MASCOTA</p></h6> 

                        <div  class="centerTabla">
                            <p>Estamos ubicados en Mucho Lote 2 (12,18 km) Guayaquil   <i class="icon-phone"> 0990423246</i> </p>
                            <p>De Luenes a Viernes nuestro horario de atención: 10:00 - 19:00</p>
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
                                <li><b>Vacunas💉 Desparasita</b></li>
                            </ul>
                        </div>


                        <div class="centerTabla"><br>
                            <label for=""><i>Conoce más de nosotros</i></label><br>
                            <a target="_blank" href="https://www.facebook.com/vetdobaltoff/"> <button type="button" class="btn btn-facebook">Fa</button></a>
                            <a target="_blank" href="https://www.instagram.com/veterinariadobaltoff/"> <button type="button" class="btn btn-instagram">Fa</button></a>
                            <a target="_blank" href="https://www.google.es/"> <button type="button" class="btn btn-twitter">Fa</button></a>
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
    .carousel-inner img {
        width: 100%;
        max-height: 560px;
    }

     ul.navega li {
        display: inline;
    }

      #Comunicate{
         color:  #F08022 
    }

   

    .carousel-inner{
    height: 400px;
    }

    #imagenCarousel {
        width: 70%;
        height: 700%;
    }

    
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

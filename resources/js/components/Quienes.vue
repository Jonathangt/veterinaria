<template>
    <main class="main">
        <ol>
            
        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="icon-paper-clip"></i> ¿Quiénes somos?
                </div>
                <template>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-8">
                                <div class="form-group centerTabla"><br>
                                    <h3><center>Veterinaria Dobaltoff</center> </h3><br>
                                    <P ALIGN="justify">
                                        Veterinaria <strong>Dobaltoff</strong> fundada al 12 Enero del 2019 por la 
                                        <strong>Dra. Carolina Hidalgo</strong> en la Ciudad de Guayaquil, creada con 
                                        gran esfuerzo con el fin de prestar de sus servicios las 24/7  
                                        y una atención personalizada para los amigos de cuatro  
                                       
                                    </P>
                                </div>
                            </div>
                              <div class="col-md-2">
                                <div class="form-group">
                                   <div>
                                            <img src="img/quienesSomos.jpg" alt="LogoUG" id="imagen">
                                    </div>
                                </div>
                            </div>
                        </div>  

                        <div>
                            <label for=""><i>Conoce más de nosotros</i></label><br>
                            <a href="https://www.google.es/" target="_blank"> <button id="btnFacebook" type="button" class="btn btn-primary">Facebook</button></a>
                            <a href="https://www.google.es/" target="_blank"> <button id="btnInstagram" type="button" class="btn btn-primary">Instagram</button></a>
                            <a href="https://www.google.es/" target="_blank"> <button id="btnTwitter" type="button" class="btn btn-primary">Twitter</button></a>

                        </div>
                                          
                    </div>
                    <br>
                </template>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
    </main>
</template>

<style>

    #btnFacebook{
        color: #fff;
        background-color: #4e71ba;
        border-color: #4e71ba;
    }



    #btnInstagram{
        color: #fff;
        background-color: rgb(253,29,29);
        border-color: rgb(253,29,29);
        }

  

    #btnTwitter{
        color: #fff;
        background-color: #00acee;
        border-color: #00acee;
    }

    
     #logo{
        float: left;
        margin-top: 1%;
        margin-left: 2%;
        margin-right: 2%;
        }

        #logo2{
        float: right;
        margin-top: 1%;
        margin-left: 2%;
        margin-right: 2%;
        }
        
        #imagen{
        width: 250px;
        text-align: right;
        }

           #datos{
        float: left;
        margin-top: 0%;
        margin-left: 2%;
        margin-right: 2%;
        /*text-align: justify;*/
        }
 
        #encabezado{
        text-align: center;
        margin-left: 10%;
        margin-right: 35%;
        font-size: 15px;
        
        }
          .centerTabla {
        text-align: left;
    }

 
</style> 
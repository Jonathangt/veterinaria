<template>
    <main class="main">
        <ol>        
        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="icon-heart"></i> Mascotas en Adopción
                </div>

                <template>
                    <div class="card-body">
                         <div class="col-md-12">
                            <div class="form-group">
                                <div> <br>
                                    <center><img src="img/About.jpg" alt="Dobaltoff" width="250" height="160"></center>
                                </div>
                            </div>
                            <h6><p id="red" class="centerTabla">TU ACCIÓN PUEDE CAMBIAR VIDAS, ADOPTA UN MASCOTA</p></h6>
                        </div>

                        <div  v-for="registro in arrayRegistros" :key="registro.id">
                                <div><br><br>
                                   <i> <h5 v-text="registro.nombreMascota"></h5></i>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <div id="bodyzz" class="form-group">
                                               <span>
                                                   <b>Fecha de Nacimiento:</b> <span v-text="registro.fechaNacimiento"></span>
                                               </span><br>
                                               <span>
                                                   <b>Edad:</b> <span v-text="registro.edad"></span>
                                               </span><br>
                                                <span>
                                                   <b>Especie:</b> <span v-text="registro.especie"></span>
                                               </span><br>
                                               <span>
                                                   <b>Raza:</b> <span v-text="registro.raza"></span>
                                               </span><br>
                                               <span>
                                                   <b>Observación:</b> <span v-text="registro.observacion"></span>
                                               </span><br><br>

                                               <h6>Contáctame</h6>

                                                <span>
                                                   <b>Celular:</b> <span v-text="registro.celular"></span><br>
                                               </span>

                                             <!--   <span>
                                                   <b>Télefono:</b> <span v-text="registro.telefono"></span>
                                               </span><br> -->
                                               <span>
                                                   <b>Correo:</b> <span v-text="registro.email"></span>
                                               </span><br>

                                                <div class="form-group row">
                                                    <div class="col-md-12"><br>
                                                        <button type="button" @click="imprimir(registro.id)" class="btn btn-primary">Imprimir</button>&nbsp;
                                                        <button type="button"  @click="adoptar(registro)" class="btn btn-primary">Adoptar</button>
                                                    </div>                                                   
                                                </div>
                                           
                                        </div>                                                                             
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group"><br>
                                              
                                        </div>                                                                             
                                    </div>


                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <div> <br>
                                                    <img :src="'/mascotas/'+registro.imagen" alt="Informacion" width="90%" height="90%">
                                                
                                            </div>
                                        </div>
                                    </div>

                                   
                                </div> <!---------fin group row--->
                                
                                 <div class="col-md-12">
                                    <div class="form-group">
                                   
                                        <hr>
                                    
                                    </div>
                                </div>

                                
                                 
                                  

                        </div> <!---fin array-->


                         <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1)">Sig</a>
                                </li>
                            </ul>
                        </nav>

                        <br><br><br>
                        
                        <label for=""><i>Conoce más de nosotros</i></label><br>
                        <a target="_blank" href="https://www.facebook.com/vetdobaltoff/"> <button type="button" class="btn btn-facebook">Fa</button></a>
                        <a target="_blank" href="https://www.instagram.com/veterinariadobaltoff/"> <button type="button" class="btn btn-instagram">Fa</button></a>
                        <!-- <a target="_blank" href="https://www.google.es/"> <button type="button" class="btn btn-twitter">Fa</button></a> -->

                    </div> <!----class="card-body">-->


                </template>
            </div>  <!-- Fi ncard --->
            <!-- Fin ejemplo de tabla Listado-->
        </div>
    </main>
</template>


<script>
    export default {
        data() {
            return {
                arrayRegistros: [],
                arraySwal: [],
                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                },
                template: 1,
                offset: 3,				
            }
        },
        computed: {
            isActived: function() {
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if (!this.pagination.to) {
                    return [];
                }

                var from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while (from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            },
            imagen(){
                return this.informacion.imagenMiniatura;
            }
        }, 
    
        methods: {
            listar(page) {
                let me = this;
                var url = '/adopcion/vizualizar-mascota?page=' + page;
                axios.get(url).then(function(response) {
                        var respuesta = response.data;
                        me.arrayRegistros = respuesta.adopcion.data;
                        me.pagination = respuesta.pagination;
                }).catch((error) =>{
                    swal({
                        title: 'Error al obtener los datos!!',
                        type:  'error',
                        text:  'No se pudo obtener los registros',
                    }) 
                    console.log(error);
                });
            },
                       
            cambiarPagina(page) {
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listar(page);
            }, 
            adoptar(registro){

                 swal({
                        width: '450px',
                        title: '¿Desea adoptar a' + ' ' + registro.nombreMascota + '?',
                        type:  'question',
                        html:  'Comuníquese con'+ ' ' + registro.nombre + ' ' + registro.apellidos+ 
                                ' al ' + registro.celular + ' para que adoptes a '+ registro.nombreMascota,
                    })

            },
            imprimir(id){
                window.open('http://localhost:8000/adopcion/pdf/'+ id + ',' + '_blank');//_blank para que se muestre en una nueva pestaña
            },
        },
        mounted() {
            this.listar(1);
        }
    }
</script>

<style>

    #bodyzz {
     font-size: 15px;
    }

    hr {
        height: -0.5px;
        background-color: red;
       /* margin-left: 25%;
        margin-right: 25%;*/
    }


    #red{
         color: #F0380A;
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
        width: 10%;
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
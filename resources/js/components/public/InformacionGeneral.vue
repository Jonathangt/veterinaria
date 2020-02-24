<template>
    <main class="main">
        <ol>        
        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="icon-paper-clip"></i> Información
                </div>

                <template>
                    <div class="card-body">
                        <div  v-for="registro in arrayRegistros" :key="registro.id">
                                <div><br>
                                    <center><h3 v-text="registro.tema"></h3></center><br>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-9">
                                         <div class="form-group"><br>
                                                <p v-text="registro.capacitador"></p>
                                            </div>

                                            <div class="form-group">
                                                <p v-text="registro.conoce"></p>
                                            </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div> <br>
                                                    <img :src="'/informacion/'+registro.imagen" alt="Informacion" width="70%" height="70%">
                                            </div>
                                        </div>
                                    </div>

                                     <div class="col-md-12">
                                          <div class="form-group">
                                            <div> <br>
                                                   
                                            </div>
                                        </div>
                                    </div>

                                </div> <!---------fin group row--->

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
                      <!--   <a target="_blank" href="https://www.google.es/"> <button type="button" class="btn btn-twitter">Fa</button></a> -->

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
                var url = '/informacion/mostrarInformacion?page=' + page;
                axios.get(url).then(function(response) {
                        var respuesta = response.data;
                        me.arrayRegistros = respuesta.informacion.data;
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
        },
        mounted() {
            this.listar(1);
        }
    }
</script>

<style>

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
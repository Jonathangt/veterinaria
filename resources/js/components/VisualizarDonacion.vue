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
                                    <h3><center>Veterinaria Dobaltoff</center> </h3><br>
                                    <center><h6 id="letra">ÚNETE AL RESCATE PROTECCIóN Y BIENESTAR ANIMAL</h6></center>
                                    <center> <img src="img/About.jpg" alt="Dobaltoff" id="imagen"></center>
                                </div>
                            </div>
                        </div>
                        
                       
                      <template>
                        <div>
                            <div class="blog-item" v-for="registro in arrayRegistros" :key="registro.id">
                                <p>Publicado por</p>
                                <p v-text="registro.name"></p>
                                <p>recaudacion </p>
                                <p v-text="registro.recaudacion"></p>
                                <p>lugar </p>
                                <p v-text="registro.lugar"></p>
                                <p>motivo </p>
                                <p v-text="registro.motivo"></p>
                                <p>telefono </p>
                                <p v-text="registro.telefono"></p>
                                <p>direccion </p>
                                <p v-text="registro.direccion"></p>
                                <p>email </p>
                                <p v-text="registro.email"></p>

                            </div>        
                        </div>
                    </template>
                                
                
                 
                    
                        <h6><p id="red" class="centerTabla">TU ACCIÓN PUEDE CAMBIAR VIDAS, ADOPTA UN MASCOTA</p></h6> 
                        <div class="centerTabla"><br>
                            <label for=""><i>Conoce más de nosotros</i></label><br>
                            <a target="_blank" href="https://www.facebook.com/vetdobaltoff/"> <button type="button" class="btn btn-facebook">Fa</button></a>
                            <a target="_blank" href="https://www.instagram.com/veterinariadobaltoff/"> <button type="button" class="btn btn-instagram">Fa</button></a>
                            <a target="_blank" href="https://www.google.es/"> <button type="button" class="btn btn-twitter">Fa</button></a>
                        </div>
                    </div>
                    <br>
                </template>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
    </main>
</template>




<script>
   
    export default {
        data() {
            return {
                name: '',
                email: '',
                motivo: '',
                recaudacion: '',
                lugar: '',
                telefono: '',
                direccion: '',
                idDonacion: 0,
                data: [],
                arrayRegistros: [],
                arrayMostrarDatos: [],
                errorMostrarMsj: [],
                errorValidacion: 0,
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
                criterio: 'motivo',
                buscar: '',
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
           
        }, 
    
        methods: {
            listar() {
                let me = this;
                var url = '/donacion/mostrar';
                axios.get(url).then(function(response) {
                        var respuesta = response.data;
                        me.arrayRegistros = respuesta.donacion.data;
                
                    })
                    .catch(function(error) {
                         console.log(me.getID);
                        console.log(error);
                    });
            },
           
           
          
           
                      
            cambiarPagina(page, buscar, criterio) {
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listar(page, buscar, criterio);
            }, 
           
        
        },
        mounted() {
            this.listar();
        }
    }
</script>

<style>
    
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
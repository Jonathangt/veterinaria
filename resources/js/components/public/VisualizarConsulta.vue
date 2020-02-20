<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol></ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="icon-chart"></i> Consulta
                </div>
                <!-- --------------------------------------------------------------------------------->
                <!--  PRINCIPAL-->
                <template v-if="template==1">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-11">
                                <div class="input-group"><!--Criterios de busqueda -->
                                    <select class="form-control col-md-2" v-model="criterio">
                                        <option value="apellidos">Apellido</option> 
                                        <option value="cedula">Cédula</option> 
                                    </select>

                                    <input type="text" v-model="buscar" @keyup.enter="listar(1,buscar,criterio)" class="form-control col-md-4" placeholder="Busqueda">
                                    <button type="submit" @click="listar(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive"> <!--Tabla pricipal donde se vizualiza los registros-->
                            <table class="table table-bordered table-striped table-sm ">
                                <thead>
                                    <tr>
                                        <th>Acciones</th>                                        
                                        <th>Cliente</th>
                                        <th>Cédula</th>
                                        <th>Mascota</th>
                                        <th>Fecha y hora de Atentión</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="registro in arrayRegistros" :key="registro.id">
                                        <td style="width:150px">
                                           <button type="button" @click="obtenerRegistro(registro.id)" class="btn btn-success btn-sm">
                                                <i class="icon-eye"></i>
                                            </button> &nbsp;
                                            <button type="button" @click="obtenerReceta(registro.id)" class="btn btn-info btn-sm">
                                                <i class="icon-doc"></i>
                                            </button> &nbsp;
                                        </td>
                                        <td v-text="registro.nombre + ' ' + registro.apellidos"></td>
                                        <td v-text="registro.cedula"></td>
                                        <td v-text="registro.nombreMascota"></td>
                                        <td v-text="registro.fechaAtencion + ' ' + registro.horaAtencion"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </template>
                <!-- FIN PRINCIPAL-->

              
               

                <!-----------------------------Tabla para visualizar el registro completo--->
                <template v-else-if="template==2">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="col-md-12">
                              <!--  <center><h5>VETERINARIA DOBALTOFF</h5></center>
                                <label for=""></label>-->
                                 <div class="col-md-12">
                                    <div class="form-group">
                                        <div> <br>
                                          <center>  <img src="img/About.jpg" alt="Dobaltoff" width="300" height="200"></center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                         
                            <center>
                                 <div class="table-responsive col-md-8">
                                <table class="table table-bordered table-striped table-sm">
                                <thead>
                                        <tr>
                                            <th colspan="2"><center>Detalle de la Consulta</center></th>
                                        </tr>
                                    </thead>
                                    <tbody v-for="mostrarDatos in arrayMostrarDatos" :key="mostrarDatos.id">
                                    <tr>
                                        <td style="width:230px"><b>Atendido Por</b></td>
                                        <td v-text="mostrarDatos.name"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Fecha y Hora</b></td>
                                        <td v-text="mostrarDatos.fechaAtencion + ' ' + mostrarDatos.horaAtencion"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Cliente</b></td>
                                        <td v-text="mostrarDatos.nombre + ' ' + mostrarDatos.apellidos"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Cédula</b></td>
                                        <td v-text="mostrarDatos.cedula"></td>
                                    </tr>
                                     <tr>
                                        <td><b>Email</b></td>
                                        <td v-text="mostrarDatos.email"></td>
                                    </tr>

                                    <tr>
                                        <td><b>Mascota</b></td>
                                        <td v-text="mostrarDatos.nombreMascota"></td>
                                    </tr>

                                    <tr>
                                        <td><b>Esterelizado</b></td>
                                        <td v-text="mostrarDatos.esterilizado"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Modo de Obtención</b></td>
                                        <td v-text="mostrarDatos.modoOptencion"></td>
                                    </tr>

                                    <tr>
                                        <td><b>Tipo de Procedimiento</b></td>
                                        <td v-text="mostrarDatos.tipoProcedimiento"></td>
                                    </tr>

                                    <tr>
                                        <td><b>Observación Consulta</b></td>
                                        <td v-text="mostrarDatos.observacionDiagnostico"></td>
                                    </tr>

                                    <tr>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td><b>Medicamento</b></td>
                                        <td v-text="mostrarDatos.medicamento"></td>
                                    </tr>

                                    <tr>
                                        <td><b>Horario</b></td>
                                        <td v-text="mostrarDatos.horario"></td>
                                    </tr>

                                    <tr>
                                        <td><b>Observación Receta</b></td>
                                        <td v-text="mostrarDatos.observacionReceta"></td>
                                    </tr>                                   
                                    </tbody>
                                </table>
                            </div>

                            </center>
                      
                        <div class="form-group row">
                            <div class="col-md-12"><br>
                                <button type="button" @click="cerrarTemplateRegistro()" class="btn btn-primary">Cerrar</button>
                            </div>
                        </div>
                    </div>
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
                arrayRegistros: [],
                arrayMostrarDatos: [],
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
                criterio: 'apellidos',
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
            listar(page, buscar, criterio) {
                let me = this;
                var url = '/diagnostico/index-consulta?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function(response) {
                        var respuesta = response.data;
                        me.arrayRegistros = respuesta.diagnostico.data;
                        me.pagination = respuesta.pagination;
                    })
                    .catch((error) =>{
                        swal({
                            title: 'Error al obtener los datos!!',
                            type:  'error',
                            text:  'No se pudo obtener los registros',
                        }) 
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
            cerrarTemplateRegistro() {
                let me = this;
                this.template = 1;
            
            },
            obtenerRegistro(id) {
                let me = this;//metodo para mostrar los datos
                this.template = 2;

                var url = '/diagnostico/mostrar-consulta?id=' + id;
                axios.get(url).then(function(response) {
                    var respuesta = response.data;
                    me.arrayMostrarDatos = respuesta.diagnostico;
                    })
                    .catch((error) => {
                        swal({
                            title: 'Error al obtener los datos!!',
                            type:  'error',
                            text:  'No se pudo obtener el registro',
                        }) 
                        console.log(error);   
                    });
            },
            obtenerReceta(id){
                window.open('http://localhost:8000/diagnostico/pdf/'+ id + ',' + '_blank');//_blank para que se muestre en una nueva pestaña
            },
        },
        mounted() {
            this.listar(1, this.buscar, this.criterio);
        }
    }
</script>

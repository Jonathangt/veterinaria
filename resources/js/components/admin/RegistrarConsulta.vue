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
                                    <div class="btn-group col-md-2">
                                        <button id='terms' type="button" @click="templateRegistrar()" class="btn btn-primary">
                                            <i class="icon-plus"></i>&nbsp;Registrar Consulta
                                        </button>
                                    </div>
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
                                        <td style="width:190px">
                                           <button type="button" @click="obtenerRegistro(registro.id)" class="btn btn-success btn-sm">
                                                <i class="icon-eye"></i>
                                            </button> &nbsp;
                                            <button type="button" @click="obtenerReceta(registro.id)" class="btn btn-info btn-sm">
                                                <i class="icon-doc"></i>
                                            </button> &nbsp;
                                            <button type="button" @click="editar(registro.id)" class="btn btn-warning btn-sm">
                                                <i class="icon-pencil"></i>
                                            </button>&nbsp;
                                              <button type="button" class="btn btn-danger btn-sm" @click="eliminar(registro.id)">
                                                <i class="icon-trash"></i>
                                            </button>  

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

                <!-- --------------------------------------------------------------------------------->
                <!-- Registro de datos-->
                <template v-else-if="template==0">
                    <div class="text-center"><br>
                        <label><b class="labelContacto"> Registro de Contulta</b></label>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div><br>
                                <center><img src="img/About.jpg" alt="Dobaltoff" width="250" height="160"></center>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-4">
                                <div class="form-group"><br>
                                    <label>Seleccione el Cliente(*)</label>
                                    <select v-model="idPersona"  @click="getMascota()" class="form-control col-md-12" onmousedown="if(this.options.length>10){this.size=5;}" onchange='this.size=0;' onblur="this.size=0;">
                                        <option v-for="registro in arrayPersona" :key="registro.id" :value="registro.id" v-text="registro.apellidos + ' ' + registro.nombre">
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group"><br>
                                    <label>Seleccione la Macota(*)</label>
                                    <select v-model="idMascota" class="form-control col-md-12">
                                        <!-- <option value="0">Seleccione</option> -->
                                        <option v-for="registro in arrayMascotas" :key="registro.id" :value="registro.id" v-text="registro.nombreMascota">
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group"><br>
                                    <label>Esterelizado(*)</label>
                                    <select v-model="esterilizado" class="form-control col-md-12">
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group"><br>
                                    <label>Tipo de Procedimiento(*)</label>
                                    <select v-model="tipoProcedimiento" class="form-control col-md-12">
                                        <option value="Implantacion">Implantación</option>
                                        <option value="Verificacion">Verificación</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group"><br>
                                    <label>Modo de Optención(*)</label>
                                    <select v-model="modoOptencion" class="form-control col-md-12">
                                        <option value="Comprado">Comprado</option>
                                        <option value="Regalo">Regalo</option>
                                        <option value="Nacido en casa">Nacido en casa</option>
                                        <option value="Adoptado">Adoptado</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Observación(*)</label>
                                    <textarea rows="4" cols="50" maxlength="200" class="form-control" v-model="observacionDiagnostico" placeholder="Observación de la consulta"> </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--fin card body-->

                    <div class="text-center">
                        <label><b class="labelContacto"> Registro de Receta</b></label>
                    </div>

                    <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-8">
                                <div class="form-group"><br>
                                    <label>Medicamento(*)</label>
                                    <input type="text" class="form-control" v-model="medicamento" placeholder="Medicamento" maxlength="200">
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Horario (*)</label>
                                    <input type="text" class="form-control" v-model="horario" placeholder="Horario" maxlength="50">
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Observación(*)</label>
                                    <textarea rows="4" cols="50" maxlength="200" class="form-control" v-model="observacionReceta" placeholder="Observación de la receta"> </textarea>
                                </div>
                            </div>
                        </div>
                        <!--fin row borde-->
                        <div><span>Los campos con (*) son obligatorios</span></div><br>
                        <div class="col-md-12">
                            <div v-show="errorValidacion" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsj" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="cerrarTemplateRegistro()" class="btn btn-primary">Cerrar</button>
                                <button type="submit" class="btn btn-primary" @click="registrar()">Registrar Consulta</button>
                            </div>
                        </div>
                    </div>
                    <!--fin 2do card body-->
                </template>
                <!-- Fin Registro de datos-->

                 <!-- --------------------------------------------------------------------------------->
                <!-- Edicion de datos-->
                <template v-else-if="template==3">
                    <div class="text-center"><br>
                        <label><b class="labelContacto"> Edición de la Contulta</b></label>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div><br>
                                <center><img src="img/About.jpg" alt="Dobaltoff" width="250" height="160"></center>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-4">
                                <div class="form-group"><br>
                                    <label>Seleccione el Cliente(*)</label>
                                    <select v-model="idPersona"  @click="getMascota()" class="form-control col-md-12" onmousedown="if(this.options.length>10){this.size=5;}" onchange='this.size=0;' onblur="this.size=0;">
                                        <option v-for="registro in arrayPersona" :key="registro.id" :value="registro.id" v-text="registro.apellidos + ' ' + registro.nombre">
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group"><br>
                                    <label>Seleccione la Macota(*)</label>
                                    <select v-model="idMascota" class="form-control col-md-12">
                                        <!-- <option value="0">Seleccione</option> -->
                                        <option v-for="registro in arrayMascotas" :key="registro.id" :value="registro.id" v-text="registro.nombreMascota">
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group"><br>
                                    <label>Esterelizado(*)</label>
                                    <select v-model="esterilizado" class="form-control col-md-12">
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group"><br>
                                    <label>Tipo de Procedimiento(*)</label>
                                    <select v-model="tipoProcedimiento" class="form-control col-md-12">
                                        <option value="Implantacion">Implantación</option>
                                        <option value="Verificacion">Verificación</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group"><br>
                                    <label>Modo de Optención(*)</label>
                                    <select v-model="modoOptencion" class="form-control col-md-12">
                                        <option value="Comprado">Comprado</option>
                                        <option value="Regalo">Regalo</option>
                                        <option value="Nacido en casa">Nacido en casa</option>
                                        <option value="Adoptado">Adoptado</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Observación(*)</label>
                                    <textarea rows="4" cols="50" maxlength="200" class="form-control" v-model="observacionDiagnostico" placeholder="Observación de la consulta"> </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--fin card body-->

                    <div class="text-center">
                        <label><b class="labelContacto"> Edicion de la Receta</b></label>
                    </div>

                    <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-8">
                                <div class="form-group"><br>
                                    <label>Medicamento(*)</label>
                                    <input type="text" class="form-control" v-model="medicamento" placeholder="Medicamento" maxlength="200">
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group"><br>
                                    <label>Horario (*)</label>
                                    <input type="text" class="form-control" v-model="horario" placeholder="Horario" maxlength="50">
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Observación(*)</label>
                                    <textarea rows="4" cols="50" maxlength="200" class="form-control" v-model="observacionReceta" placeholder="Observación de la receta"> </textarea>
                                </div>
                            </div>
                        </div>
                        <!--fin row borde-->
                        <div><span>Los campos con (*) son obligatorios</span></div><br>
                        <div class="col-md-12">
                            <div v-show="errorValidacion" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsj" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="cerrarTemplateRegistro()" class="btn btn-primary">Cerrar</button>
                                <button type="submit" class="btn btn-primary" @click="registrar()">Registrar Consulta</button>
                            </div>
                        </div>
                    </div>
                    <!--fin 2do card body-->
                </template>
                <!-- Fin Registro de datos-->

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
                idPersona: '',
                idMascota: '',
                esterilizado: '',
                tipoProcedimiento: '',
                recaudacion: '',
                lugar: '',
                modoOptencion: '',
                observacionDiagnostico: '',
                medicamento: '',
                horario: '',
                observacionReceta: '',
                id_diagnostico: 0,
                arrayPersona: [],
                arrayMascotas: [],
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
            getPersona() {
                let me = this;
                var url = '/diagnostico/select-cliente';
                axios.get(url).then(function(response) {
                    var respuesta = response.data;
                    me.arrayPersona = respuesta.personas;

                    })
                    .catch((error) =>{
                        swal({
                            title: 'Error al obtener los datos!!',
                            type:  'error',
                            text:  'No se pudo obtener el registro',
                        }) 
                        console.log(error);  
                    });
            },
            getMascota(idPersona) { 
                let me = this;                
                
                var url= '/diagnostico/select-mascotas?id=' + this.idPersona;
                
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayMascotas = respuesta.mascotas;
                
                }).catch((error) =>{
                    swal({
                        title: 'Error al obtener los datos!!',
                        type:  'error',
                        text:  'No se pudo obtener el registro',
                    }) 
                    console.log(error);  
                });
            },
            listar(page, buscar, criterio) {
                let me = this;
                var url = '/diagnostico?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
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
            registrar(){
                if (this.validarDatos()) {
                    return;
                }
                let me = this;

                axios.post('/diagnostico/registrar',{     
                    'idPersona' : this.idPersona,
                    'idMascota': this.idMascota,
                    'esterilizado' : this.esterilizado,
                    'tipoProcedimiento' : this.tipoProcedimiento,
                    'modoOptencion' : this.modoOptencion,
                    'observacionDiagnostico' : this.observacionDiagnostico,
                    'medicamento' : this.medicamento,
                    'horario' : this.horario,
                    'observacionReceta' : this.observacionReceta,
                }).then((response) => {
                    this.listar(1,'','apellidos');
                    this.cerrarTemplateRegistro();

                    swal({
                        title: 'Consulta Registrada!!',
                        type:  'success',
                        text:  'La información a sido guardada',
                    })

                }).catch((error) =>{
                    swal({
                        title: 'Consulta no registrada!!',
                        type:  'error',
                        text:  'No se ha guardado la información',
                    })
                    console.log(error);
                });
            },
            editar(id) {
                this.templateEditar();
                this.template=3; //abro el template para editar
                let me = this;
                var url = '/diagnostico/obtener?id=' + id;
                var arrayEditarDatos=[];
                axios.get(url).then(function(response) {
                    var respuesta= response.data;
                    arrayEditarDatos = respuesta.diagnostico;
                    me.id_diagnostico = arrayEditarDatos[0]['id'];
                    me.idPersona = arrayEditarDatos[0]['idPersona'];
                    me.idMascota = arrayEditarDatos[0]['idMascota'];
                    me.esterilizado = arrayEditarDatos[0]['esterilizado'];
                    me.tipoProcedimiento = arrayEditarDatos[0]['tipoProcedimiento'];
                    me.modoOptencion = arrayEditarDatos[0]['modoOptencion'];
                    me.observacionDiagnostico = arrayEditarDatos[0]['observacionDiagnostico'];
                    me.medicamento = arrayEditarDatos[0]['medicamento'];
                    me.horario = arrayEditarDatos[0]['horario'];
                    me.observacionReceta = arrayEditarDatos[0]['observacionReceta'];

                }).then( (response) =>{
                    this.getMascota(this.idPersona);
                }).catch((error) => {
                    swal({
                        title: 'Error al obtener los datos!!',
                        type:  'error',
                        text:  'No se pudo obtener el registro',
                    }) 
                    console.log(error); 
                   
                });
               
            },
            actualizar(){
                if (this.validarDatos()){
                    return;
                }
                
                let me = this;

                axios.put('/diagnostico/actualizar',{
                    'idPersona' : this.idPersona,
                    'idMascota': this.idMascota,
                    'esterilizado' : this.esterilizado,
                    'tipoProcedimiento' : this.tipoProcedimiento,
                    'modoOptencion' : this.modoOptencion,
                    'observacionDiagnostico' : this.observacionDiagnostico,
                    'medicamento' : this.medicamento,
                    'horario' : this.horario,
                    'observacionReceta' : this.observacionReceta,                    
                    'id': this.id_diagnostico
                }).then( (response) =>{
                    this.cerrarTemplateRegistro();
                    this.listar(1,'','apellidos');
                    
                    swal({
                        title: 'Consulta Actualizada!!',
                        type:  'success',
                        text:  'La información a sido actualizada',
                    })
                }).catch( (error) =>{
                    swal({
                        title: 'Error al actualizadar!!',
                        type:  'error',
                        text:  'La información no a sido actualizada',
                    }) 
                    console.log(error);
                }); 
            
            },         
            validarDatos() {//Validaciones para el registro de los datos
                this.errorValidacion = 0;
                this.errorMostrarMsj = [];
                if (!this.idPersona) this.errorMostrarMsj.push("Debe de seleccionar un cliente");
                if (!this.idMascota)  this.errorMostrarMsj.push("Debe de seleccionar una mascota");               
                if (!this.esterilizado) this.errorMostrarMsj.push("Debe de seleccionar si la mascota esta esterilizado (a)");
                if (!this.tipoProcedimiento) this.errorMostrarMsj.push("Debe de seleccionar una un tipo de procedimiento");
                if (!this.modoOptencion) this.errorMostrarMsj.push("Debe de seleccionar un modo de obtencion de la mascota");
                if (!this.observacionDiagnostico) this.errorMostrarMsj.push("Debe agregar la observación de la consulta");
                if (!this.medicamento) this.errorMostrarMsj.push("Debe agregar el medicamento de la receta");
                if (!this.horario) this.errorMostrarMsj.push("Debe agregar el horario de la receta");
                if (!this.observacionReceta) this.errorMostrarMsj.push("Debe agregar la observacion de la receta");

                if (this.errorMostrarMsj.length) this.errorValidacion = 1;
                return this.errorValidacion;
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
                me.idPersona = '';
                me.idMascota = '';    
                me.esterilizado = '';     
                me.tipoProcedimiento = '';
                me.modoOptencion = '';
                me.observacionDiagnostico = '';
                me.medicamento = '';
                me.horario = '';
                me.observacionReceta = '';
                me.errorMostrarMsj = '';

            },
            templateRegistrar() {
                this.getPersona();
                let me = this;
                this.template = 0;
                me.idPersona = '';
                me.idMascota = '';    
                me.esterilizado = '';     
                me.tipoProcedimiento = '';
                me.modoOptencion = '';
                me.observacionDiagnostico = '';
                me.medicamento = '';
                me.horario = '';
                me.observacionReceta = '';
                me.errorMostrarMsj = '';
            },
            templateEditar() {
                let me = this;
                this.template = 3;
                me.idPersona = '';
                me.idMascota = '';    
                me.esterilizado = '';     
                me.tipoProcedimiento = '';
                me.modoOptencion = '';
                me.observacionDiagnostico = '';
                me.medicamento = '';
                me.horario = '';
                me.observacionReceta = '';
                me.errorMostrarMsj = '';
                this.getPersona();
                
            },
            obtenerRegistro(id) {
                let me = this;//metodo para mostrar los datos
                this.template = 2;

                var url = '/diagnostico/obtener?id=' + id;
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
            eliminar(id){
                swal({
                    title: 'Esta seguro que desea eliminar el registro?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                    reverseButtons: true
                    }).then((result) => {
                    if (result.value) {
                        let me = this;
                        var url = '/diagnostico/delete/' +id;
                    axios.delete(url).then(function (response) {

                        me.listar(1,'','apellidos');
                        swal(
                        'Eliminado!',
                        'El registro ha sido eliminado con éxito.',
                        'success'
                        )
                    }).catch((error) =>{
                        swal(
                            'Error al eliminar!',
                            'El registro no ha sido eliminado.',
                            'error'
                        )
                        console.log(error);
                    });                
                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === swal.DismissReason.cancel
                    ) {
                        
                    }
                    }) 
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
<style>

    textarea{
        resize:none;

    }

    #select {
        padding: 0.75em 0.5em;
        font-size: 100%;
        border: 1px solid #ccc;
        width: 100%;
        height: 2.5em;
    }


    #labelContacto {
        display: inline-block !important;
        margin-bottom: .5rem !important;
    }


    
    .mostrar {
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    
    .div-error {
        display: flex;
        justify-content: center;
    }
    
    .text-error {
        color: red !important;
        font-weight: bold;
    }
    
    @media (min-width: 600px) {
        .btnagregar {
            margin-top: 2rem;
        }
    }
    

    .centerTabla {
        text-align: center;
    }

</style> 

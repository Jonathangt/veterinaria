<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol></ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="icon-heart"></i> Registro de mascotas para adopción
                </div>
                <!-- --------------------------------------------------------------------------------->
                <!--  PRINCIPAL-->
                <template v-if="template==1">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-11">
                                <div class="input-group"><!--Criterios de busqueda -->
                                    <select class="form-control col-md-2" v-model="criterio">
                                        <option value="apellidos">Apellido de la persona</option> 
                                        <option value="nombreMascota">Nombre de Mascota</option> 
                                    </select>

                                    <input type="text" v-model="buscar" @keyup.enter="listar(1,buscar,criterio)" class="form-control col-md-4" placeholder="Busqueda">
                                    
                                    <button type="submit" @click="listar(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                   
                                    <div class="btn-group col-md-2">
                                        <button id='terms' type="button" @click="templateRegistrar()" class="btn btn-primary">
                                            <i class="icon-plus"></i>&nbsp;Registrar Mascota
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
                                        <th>Nombres</th>
                                        <th>Mascota</th>
                                        <th>Fecha Nacimiento</th>
                                        <th>Edad</th>
                                        <th>Especie</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="registro in arrayRegistros" :key="registro.id">
                                        <td style="width:170px">
                                           <button type="button" @click="obtenerRegistro(registro.id)" class="btn btn-success btn-sm">
                                                <i class="icon-eye"></i>
                                            </button> &nbsp;
                                            <button type="button" @click="editar(registro.id)" class="btn btn-warning btn-sm">
                                                <i class="icon-pencil"></i>
                                            </button>&nbsp;
                                            
                                             <span v-if="registro.estado">
                                                <button type="button" class="btn btn-secondary btn-sm" @click="desactivar(registro.id)">
                                                <i class="icon-info"></i>
                                            </button>
                                            </span>
                                            <span v-else>
                                                <button type="button" class="btn btn-success btn-sm" @click="activar(registro.id)">
                                                <i class="icon-check"></i>
                                                </button>
                                            </span>

                                        </td>
                                        <td v-text="registro.nombre + ' ' + registro.apellidos"></td>
                                        <td v-text="registro.nombreMascota"></td>
                                        <td v-text="registro.fechaNacimiento"></td>
                                        <td v-text="registro.edad"></td>
                                        <td v-text="registro.especie"></td>
                                        <td>
                                        <div v-if="registro.estado">
                                           <td class="badge badge-success">EN ADOPCION</td>
                                        </div>
                                        <div v-else>
                                           <td class="badge badge-danger">ADOPTADO (A)</td>
                                        </div>
                                    </td>
                                    </tr>
                                </tbody>
                            </table>
                           <span><i>Nota: Cuando su mascota sea adoptada por favor desactivar el registro para que no se muestre en la página de adopción</i></span><br><br>
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
                         <Label><b class="labelContacto"> Registro de la mascota</b></Label>
                    </div>
                     <div class="col-md-12">
                        <div class="form-group">
                            <div> <br>
                                <center><img src="img/About.jpg" alt="Dobaltoff" width="250" height="160"></center>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row border">
                        <form enctype="multipart/form-data" class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group"><br>
                                            <Label>Seleccione su nombre(*)</Label>
                                            <select v-model="mascota.idPersona" class="form-control col-md-12">
                                                <option
                                                    v-for="registro in arrayPersona" :key="registro.id" :value="registro.id"
                                                    v-text="registro.apellidos + ' ' + registro.nombre">
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><br>
                                           <Label>Mascota(*)</Label> 
                                           <input type="text" class="form-control" v-model="mascota.nombreMascota" placeholder="Nombre Mascota" maxlength="20"> 
                                           <div v-if="errors && errors.nombreMascota" class="text-danger">{{ errors.nombreMascota[0] }}</div> 
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group"><br>
                                           <label>Fecha de Nacimiento(*)</label>
                                            <datepicker id="select" placeholder= "Fecha de nacimiento" v-model="mascota.fechaNacimiento" :language="es"></datepicker>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group"><br>
                                            <Label>Edad(*)</Label>
                                            <input type="text" class="form-control" v-model="mascota.edad" placeholder="Edad" maxlength="10"> 
                                            <div v-if="errors && errors.edad" class="text-danger">{{ errors.edad[0] }}</div> 
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group"><br>
                                            <Label>Especie(*)</Label>
                                            <input type="text" class="form-control" v-model="mascota.especie" placeholder="Especie" maxlength="20"> 
                                            <div v-if="errors && errors.especie" class="text-danger">{{ errors.especie[0] }}</div> 
                                        </div>
                                    </div>

                                
                                    <div class="col-md-4">
                                        <div class="form-group"><br>
                                            <Label>Raza(*)</Label>
                                            <input type="text" class="form-control" v-model="mascota.raza" placeholder="Raza" maxlength="20"> 
                                            <div v-if="errors && errors.raza" class="text-danger">{{ errors.raza[0] }}</div> 
                                        </div>
                                    </div>

                                     <div class="col-md-8">
                                        <div class="form-group"><br>                                           
                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <Label>Observación(*)</Label>
                                            <textarea rows="4" cols="50" maxlength="200" class="form-control"  v-model="mascota.observacion" placeholder="Observación"> </textarea> 
                                            <div v-if="errors && errors.observacion" class="text-danger">{{ errors.observacion[0] }}</div> 
                                        </div>
                                    </div>

                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <Label>Seleccione la imagen(*)</Label>
                                            <input type="file" @change="obtenerImagen" ref="file" accept=".jpg, .png, .jpeg" class="form-control file">
                                        </div>
                                    </div> 

                                     <div class="col-md-7">
                                        <div class="form-group"><br>                                           
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div> <br>
                                                <span type="hidden"><img :src="imagen" alt="Imagen a cargar" width="100%" height="100%"></span>
                                            </div>
                                        </div>
                                    </div>

                                </div><!--fin div row-->
                        </form>                                       
                        </div>
                    </div> <!--fin card body-->
                     <div class="card-body">            
                        <div><span >Los campos con (*) son obligatorios</span></div><br>
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
                                <button type="submit" class="btn btn-primary" @click="registrar()">Registrar Mascota</button>
                            </div>
                        </div>
                    </div><!--fin 2do card body-->
                </template>
                <!-- Fin Registro de datos-->

                 <!-- --------------------------------------------------------------------------------->
                <!-- Edicion de datos-->
                <template v-else-if="template==3">
                    <div class="text-center"><br>
                         <Label><b class="labelContacto"> Edición de datos de la mascota</b></Label>
                    </div>
                     <div class="col-md-12">
                        <div class="form-group">
                            <div> <br>
                                <center><img src="img/About.jpg" alt="Dobaltoff" width="250" height="160"></center>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row border">
                        <form enctype="multipart/form-data" class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group"><br>
                                            <Label>Seleccione su nombre(*)</Label>
                                            <select v-model="mascota.idPersona" class="form-control col-md-12">
                                                <option
                                                    v-for="registro in arrayPersona" :key="registro.id" :value="registro.id"
                                                    v-text="registro.apellidos + ' ' + registro.nombre">
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><br>
                                           <Label>Mascota(*)</Label> 
                                           <input type="text" class="form-control" v-model="mascota.nombreMascota" placeholder="Nombre Mascota" maxlength="20"> 
                                           <div v-if="errors && errors.nombreMascota" class="text-danger">{{ errors.nombreMascota[0] }}</div> 
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group"><br>
                                           <label>Fecha de Nacimiento(*)</label>
                                            <datepicker id="select" placeholder= "Fecha de nacimiento" v-model="mascota.fechaNacimiento" :language="es"></datepicker>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group"><br>
                                            <Label>Edad(*)</Label>
                                            <input type="text" class="form-control" v-model="mascota.edad" placeholder="Edad" maxlength="15"> 
                                            <div v-if="errors && errors.edad" class="text-danger">{{ errors.edad[0] }}</div> 
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group"><br>
                                            <Label>Especie(*)</Label>
                                            <input type="text" class="form-control" v-model="mascota.especie" placeholder="Especie" maxlength="20"> 
                                            <div v-if="errors && errors.especie" class="text-danger">{{ errors.especie[0] }}</div> 
                                        </div>
                                    </div>

                                
                                    <div class="col-md-4">
                                        <div class="form-group"><br>
                                            <Label>Raza(*)</Label>
                                            <input type="text" class="form-control" v-model="mascota.raza" placeholder="Raza" maxlength="20"> 
                                            <div v-if="errors && errors.raza" class="text-danger">{{ errors.raza[0] }}</div> 
                                        </div>
                                    </div>

                                     <div class="col-md-8">
                                        <div class="form-group"><br>                                           
                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <Label>Observación(*)</Label>
                                            <textarea rows="4" cols="50" maxlength="200" class="form-control"  v-model="mascota.observacion" placeholder="Observación"> </textarea> 
                                            <div v-if="errors && errors.observacion" class="text-danger">{{ errors.observacion[0] }}</div> 
                                        </div>
                                    </div>

                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <Label>Seleccione la imagen(*)</Label>
                                            <input type="file" @change="obtenerImagenEdit" ref="file" accept=".jpg, .png, .jpeg" class="form-control file">
                                        </div>
                                    </div> 

                                     <div class="col-md-7">
                                        <div class="form-group"><br>                                           
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div> <br>
                                                <span type="hidden"><img :src="imagen" alt="Imagen a cargar" width="100%" height="100%"></span>
                                            </div>
                                        </div>
                                    </div>

                                </div><!--fin div row-->
                        </form>                                       
                        </div>
                    </div> <!--fin card body-->
                     <div class="card-body">            
                        <div><span >Los campos con (*) son obligatorios</span></div><br>
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
                                <button type="submit" class="btn btn-primary" @click="actualizar()">Actualizar Mascota</button>
                            </div>
                        </div>
                    </div><!--fin 2do card body-->
                </template> 
                <!-- fin  Edicion de datos-->

                 <!-----------------------------Tabla para visualizar el registro completo--->
                <template v-else-if="template==2">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="col-md-12">
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
                                <div v-for="mostrarDatos in arrayMostrarDatos" :key="mostrarDatos.id">  
                                <table class="table table-bordered table-striped table-sm">
                                <thead>
                                        <tr>
                                            <th colspan="2"><center>Detalle de datos de la mascota</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>  
                                    <tr>
                                        <td style="width:230px"><b>Mascota</b></td>
                                        <td v-text="mostrarDatos.nombreMascota"></td>
                                    </tr>
                                      <tr>
                                        <td><b>Fecha Nacimiento</b></td>
                                        <td v-text="mostrarDatos.fechaNacimiento"></td>
                                    </tr>
                                     <tr>
                                        <td><b>Edad</b></td>
                                        <td v-text="mostrarDatos.edad"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Especie</b></td>
                                        <td v-text="mostrarDatos.especie"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Raza</b></td>
                                        <td v-text="mostrarDatos.raza"></td>
                                    </tr>                                  
                                    <tr>
                                        <td><b>Observacion</b></td>
                                        <td v-text="mostrarDatos.observacion"></td>
                                    </tr>

                                    <tr>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td><b>Nombre de la persona</b></td>
                                        <td v-text="mostrarDatos.nombre + ' ' + mostrarDatos.apellidos"></td>
                                    </tr>

                                     <tr>
                                        <td><b>Cédula</b></td>
                                        <td v-text="mostrarDatos.cedula"></td><br>
                                    </tr> 
                                    </tbody>
                                </table>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div> <br>
                                            <center><img :src="'/mascotas/'+mostrarDatos.imagen" alt="Informacion" width="50%" height="50%"></center>
                                        </div>
                                    </div>
                                </div>
                            </div><!--fin div for--->
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
    import Datepicker from 'vuejs-datepicker';
    import { es } from 'vuejs-datepicker/dist/locale'
    export default {
        data() {
            return {
                errors: {},
               
                nombreMascota: '',
                edad: '',
                especie: '',
                raza: '',
                observacion: '',
               

                mascota: {
                    idPersona: '',
                    nombreMascota: '',
                    fechaNacimiento: '',
                    edad: '',
                    especie: '',
                    raza: '',
                    observacion: '',
                    imagenMiniatura: '',
                    id:'',
                },
                imagenCargar: '',
                es: es,                   
                arrayPersona: [],
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
                name: '',
                file: '',  
            }
        },
        components: {
            Datepicker,
           //vSelect
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
                return this.mascota.imagenMiniatura;
            }
           
        }, 
    
        methods: {
            obtenerImagen(e){
               let me = this;
                me.file = e.target.files[0];//img en la posicion 0
                this.imagenCargar = me.file['name']; //agregamos la informacion
                this.cargarImagen(me.file);
               
                
                if (this.validarDatos()) {
                    return;
                }
        
            },
             obtenerImagenEdit(e){
               let me = this;
                me.file = e.target.files[0];//img en la posicion 0
                this.imagenCargar = me.file['name']; //agregamos la informacion
                this.cargarImagen(me.file);
               
                
                if (this.validarDatosEdit()) {
                    return;
                }
        
            },
            cargarImagen(file){
                let reader = new FileReader();
                reader.onload = (e) =>{
                    this.mascota.imagenMiniatura = e.target.result;
                }
                reader.readAsDataURL(file);
            },
            getPersona() {
                let me = this;
                var url = '/adopcion/select-datos';
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
            listar(page, buscar, criterio) {
                let me = this;
                var url = '/adopcion?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function(response) {
                        var respuesta = response.data;
                        me.arrayRegistros = respuesta.adopcion.data;
                        me.pagination = respuesta.pagination;
                })
                .catch(error =>{
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
                this.errors = {};
                axios.post('/adopcion/registrar', this.mascota )   
                
                .then(response=>  {
                    this.cerrarTemplateRegistro();
                    this.listar(1,'','apellidos');

                    swal({
                        title: 'Mascota Registrada!!',
                        type:  'success',
                        text:  'La información a sido guardada',
                    })
                }).catch(error =>{
                    const { status, errors } = error.response
                    const response = error.response
                     if (status === 500) {
                        console.log(response.data)
                    }else if (status === 422) {
                        this.errors = error.response.data.errors || {};
                        console.clear()
                    } else {
                        console.log(error)
                    }
                });
            
            },
            editar(id) {
                this.templateEditar();
                let me = this;
                var url = '/adopcion/obtener?id=' + id;
                var arrayEditarDatos=[];
                axios.get(url).then(function(response) {
                    var respuesta= response.data;
                    arrayEditarDatos = respuesta.adopcion;
                    me.mascota.id = arrayEditarDatos[0]['id'];
                    me.mascota.idPersona = arrayEditarDatos[0]['idPersona'];
                    me.mascota.nombreMascota = arrayEditarDatos[0]['nombreMascota'];
                    me.mascota.fechaNacimiento = arrayEditarDatos[0]['fechaNacimiento'];
                    me.mascota.edad = arrayEditarDatos[0]['edad'];
                    me.mascota.especie = arrayEditarDatos[0]['especie'];
                    me.mascota.raza = arrayEditarDatos[0]['raza'];
                    me.mascota.observacion = arrayEditarDatos[0]['observacion'];
                    me.mascota.imagenMiniatura = arrayEditarDatos[0]['imagen'];
                    me.mascota.imagenMiniatura = 'http://localhost:8000/mascotas/' + ''+me.mascota.imagenMiniatura;

                }).catch((error) =>  {
                    swal({
                        title: 'Error al obtener los datos!!',
                        type:  'error',
                        text:  'No se pudo obtener el registro',
                    }) 
                    console.log(error);   
                });

            },
            actualizar(){
                 if (this.validarDatosEdit()){
                    return;
                }
                this.errors = {};
                axios.put('/adopcion/actualizar', this.mascota)  
                   
                .then(response =>  {
                    this.cerrarTemplateRegistro();
                    this.listar(1,'','apellidos');

                    swal({
                        title: 'Mascota Actualizado!!',
                        type:  'success',
                        text:  'La información a sido actualizada',
                    })
                }).catch(error =>  {
                    const { status, errors } = error.response
                    const response = error.response
                     if (status === 500) {
                        console.log(response.data)
                    }else if (status === 422) {
                        this.errors = error.response.data.errors || {};
                        console.clear()
                    } else {
                        console.log(error)
                    }                
                }); 
            },  
            obtenerRegistro(id) {
                let me = this;//metodo para mostrar los datos
                this.template = 2;

                var url = '/adopcion/obtener?id=' + id;
                axios.get(url).then(function(response) {
                    var respuesta = response.data;
                    me.arrayMostrarDatos = respuesta.adopcion;
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
            validarDatos() {//Validaciones para el registro de los datos 
                this.errorValidacion = 0;
                this.errorMostrarMsj = [];
                if (!this.mascota.idPersona) this.errorMostrarMsj.push("Seleccione su nombre");
                if (!this.mascota.nombreMascota) this.errorMostrarMsj.push("El nombre de la mascota es requerido");
                if (!this.mascota.fechaNacimiento) this.errorMostrarMsj.push("La fecha de nacimiento de la mascota es requerido");
                if (!this.mascota.especie) this.errorMostrarMsj.push("La especie de la mascota es requerido");
                if (!this.mascota.raza) this.errorMostrarMsj.push("La raza de la mascota es requerido");
                if (!this.mascota.observacion) this.errorMostrarMsj.push("La observación de la mascota es requerido");
            

                if (!this.file) {
                    this.errorMostrarMsj.push("Seleccione una imagen de la mascota que desea dar en adopción");
                } else
                if(this.file['type'] != 'image/png' && this.file['type'] != 'image/jpg' && this.file['type'] != 'image/jpeg'){
                    this.errorMostrarMsj.push("Formato de archivo no permitido!");
                    this.file = '';
                }
        
                if (this.errorMostrarMsj.length) this.errorValidacion = 1;
                return this.errorValidacion;
            }, 
            validarDatosEdit() {//Validaciones para el registro de los datos 
                this.errorValidacion = 0;
                this.errorMostrarMsj = [];
                if (!this.mascota.idPersona) this.errorMostrarMsj.push("Seleccione su nombre");
                if (!this.mascota.nombreMascota) this.errorMostrarMsj.push("El nombre de la mascota es requerido");
                if (!this.mascota.fechaNacimiento) this.errorMostrarMsj.push("La fecha de nacimiento de la mascota es requerido");
                if (!this.mascota.especie) this.errorMostrarMsj.push("La especie de la mascota es requerido");
                if (!this.mascota.raza) this.errorMostrarMsj.push("La raza de la mascota es requerido");
                if (!this.mascota.observacion) this.errorMostrarMsj.push("La observación de la mascota es requerido");
            

                if (this.file) {
                    //this.errorMostrarMsj.push("Agregue una imagen de la mascota");
                    if(this.file['type'] != 'image/png' && this.file['type'] != 'image/jpg' && this.file['type'] != 'image/jpeg'){
                        this.errorMostrarMsj.push("Formato de archivo no permitido!");
                        //this.file = '';
                    }
                } else{
                    return;
                }
        
                if (this.errorMostrarMsj.length) this.errorValidacion = 1;
                return this.errorValidacion;
            }, 

            cambiarPagina(page, buscar, criterio) {
                //Actualiza la página actual
                this.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                this.listar(page, buscar, criterio);
            }, 
            cerrarTemplateRegistro() {           
                this.template = 1;
                this.mascota.idPersona = '';
                this.mascota.nombreMascota = '';    
                this.mascota.fechaNacimiento = '';          
                this.mascota.edad = '';
                this.mascota.especie = '';
                this.mascota.raza = ''; 
                this.mascota.observacion = ''; 
                this.file = ''; 
                this.errors= '';
                this.mascota.imagenMiniatura = ''; 
                this.errorMostrarMsj = '';      
            },
            templateRegistrar() {
                this.getPersona();
                this.template = 0;
                this.mascota.idPersona = '';
                this.mascota.nombreMascota = '';    
                this.mascota.fechaNacimiento = '';          
                this.mascota.edad = '';
                this.mascota.especie = '';
                this.mascota.raza = ''; 
                this.mascota.observacion = ''; 
                this.file = '';
                this.errors= '';
                this.mascota.imagenMiniatura = '';  
                this.errorMostrarMsj = '';
            },
            templateEditar() {
                this.getPersona();
                
                this.template = 3;
                this.mascota.idPersona = '';
                this.mascota.nombreMascota = '';    
                this.mascota.fechaNacimiento = '';          
                this.mascota.edad = '';
                this.mascota.especie = '';
                this.mascota.raza = ''; 
                this.mascota.observacion = ''; 
                this.file = ''; 
                this.errors= '';
                this.mascota.imagenMiniatura = ''; 
                this.errorMostrarMsj = '';
            },
            desactivar(id){
                swal({
                    title: 'Esta seguro de desactivar la mascota?',
                    type: 'warning',
                    text:  'No se mostrara la mascota en la sección de adoptar',
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

                        axios.put('/adopcion/desactivar',{
                            'id': id
                        }).then( (response) =>{
                            me.listar(1,'','name');
                            swal(
                            'Desactivado!',
                            'El registro ha sido desactivado con éxito.',
                            'success'
                            )
                        }).catch((error) =>{
                             swal({
                                title: 'No Desactivado!!',
                                type:  'error',
                                text:  'Ha ocurrido un error al desactivar el registro',
                            })
                            console.log(error);
                        });
                       
                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === swal.DismissReason.cancel
                    ) {
                        
                    }
                    }) 
            },
            activar(id){
                swal({
                    title: 'Esta seguro de activar la mascota para adopción?',
                    type: 'warning',
                    text:  'Se mostrara la mascota en la sección de adopcion',
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

                        axios.put('/adopcion/activar',{
                            'id': id
                        }).then( (response) =>{
                            me.listar(1,'','apellidos');
                            swal(
                            'Activado!',
                            'El registro ha sido activado con éxito.',
                            'success'
                            )
                        }).catch( (error) =>{
                            swal({
                                title: 'No Activado!!',
                                type:  'error',
                                text:  'Ha ocurrido un error al activar el registro',
                            })
                            console.log(error);
                        });
                        
                        
                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === swal.DismissReason.cancel
                    ) {
                        
                    }
                }) 
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


    .modal-content {
        width: 100% !important;
        position: absolute !important;
    }

     #imagen{
        width: 100px;
        height: 150px;

        text-align: right;
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
    
    /*#div1 {
        overflow:scroll;
        width:1900px;
    }
    #div1 table {
        width:1900px;
    }
    td {
        
        width: 300px;
        text-align: center;
    } */

    .centerTabla {
        text-align: center;
    }

    .swal2-title {
      font-size: 20px !important;
    }

    .swal2-content {
      font-size: 15px !important;
    }
</style> 

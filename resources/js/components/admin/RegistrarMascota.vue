<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol></ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="icon-chart"></i>  Administración de Mascotas 
                </div>
                <!-- --------------------------------------------------------------------------------->
                <!--  PRINCIPAL-->
                <template v-if="template==1">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-11">
                                <div class="input-group"><!--Criterios de busqueda -->
                                    <select class="form-control col-md-2" v-model="criterio">
                                        <option value="apellidos">Apellido del Cliente</option> 
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
                                        <th>Cliente</th>
                                        <th>Mascota</th>
                                        <th>Especie</th>
                                        <th>Raza</th>
                                        <th>Sexo</th>
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
                                              <button type="button" class="btn btn-danger btn-sm" @click="eliminar(registro.id)">
                                                <i class="icon-trash"></i>
                                            </button>  

                                        </td>
                                        <td v-text="registro.nombre + ' ' + registro.apellidos"></td>
                                        <td v-text="registro.nombreMascota"></td>
                                        <td v-text="registro.especie"></td>
                                        <td v-text="registro.raza"></td>
                                        <td v-text="registro.sexo"></td>
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
                            <div  class="col-md-4">
                                <div class="form-group"><br>
                                    <Label>Seleccione el Cliente(*)</Label>
                                    <select v-model="idCliente" class="form-control col-md-12"
                                     onmousedown="if(this.options.length>10){this.size=5;}"  onchange='this.size=0;' onblur="this.size=0;">
                                        <option
                                            v-for="registro in arrayPersona" :key="registro.id" :value="registro"
                                            v-text="registro.apellidos + ' ' + registro.nombre">
                                        </option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-group"><br>
                                    <Label>Nombre mascota(*)</Label>
                                    <input type="text" class="form-control" v-model="nombreMascota" placeholder="Mascota" maxlength="20"> 
                                </div>
                            </div>


                             <div class="col-md-4">
                                <div class="form-group"><br>
                                    <Label>Especie(*)</Label>
                                    <input type="text" class="form-control" v-model="especie" placeholder="Especie" maxlength="20"> 
                                </div>
                            </div>

                          
                            <div class="col-md-4">
                                <div class="form-group"><br>
                                    <Label>Raza(*)</Label>
                                    <input type="text" class="form-control" v-model="raza" placeholder="Raza" maxlength="20"> 
                                </div>
                            </div>

                        
                            <div class="col-md-4">
                                <div class="form-group"><br>
                                    <label>Fecha de Nacimiento(*)</label>
                                    <datepicker id="select" placeholder= "Fecha de nacimiento" v-model="fechaNacimiento" :language="es"></datepicker>
                                </div>
                            </div>

                            
                             <div  class="col-md-4">
                                <div class="form-group"><br>
                                    <Label>Edad(*)</Label>
                                    <input type="text" class="form-control" v-model="edad" placeholder="Edad" maxlength="15"> 
                                </div>
                            </div>

                             <div  class="col-md-4">
                                <div class="form-group"><br>
                                    <Label>Sexo(*)</Label>
                                    <select class="form-control" v-model="sexo">
                                        <option value="Macho">Macho</option>
                                        <option value="Hembra">Hembra</option>
                                    </select>
                                </div>
                            </div>
                        
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
                         <Label><b class="labelContacto"> Edicion de datos de la mascota</b></Label>
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
                             <div  class="col-md-4">
                                <div class="form-group"><br>
                                    <Label>Seleccione el Cliente(*)</Label>
                                    <select v-model="idCliente" class="form-control col-md-12"
                                     onmousedown="if(this.options.length>10){this.size=5;}"  onchange='this.size=0;' onblur="this.size=0;">
                                        <option
                                            v-for="registro in arrayPersona" :key="registro.id" :value="registro.id"
                                            v-text="registro.apellidos + ' ' + registro.nombre">
                                        </option>
                                    </select>
                                </div>
                            </div>
                    
                            <div class="col-md-4">
                                <div class="form-group"><br>
                                    <Label>Nombre mascota(*)</Label>
                                    <input type="text" class="form-control" v-model="nombreMascota" placeholder="Mascota" maxlength="20"> 
                                </div>
                            </div>


                             <div class="col-md-4">
                                <div class="form-group"><br>
                                    <Label>Especie(*)</Label>
                                    <input type="text" class="form-control" v-model="especie" placeholder="Especie" maxlength="20"> 
                                </div>
                            </div>

                      
                            <div class="col-md-4">
                                <div class="form-group"><br>
                                    <Label>Raza(*)</Label>
                                    <input type="text" class="form-control" v-model="raza" placeholder="Raza" maxlength="20"> 
                                </div>
                            </div>

                        
                            <div class="col-md-4">
                                <div class="form-group"><br>
                                    <label>Fecha de Nacimiento(*)</label>
                                    <datepicker id="select" placeholder= "Fecha de nacimiento" v-model="fechaNacimiento" :language="es"></datepicker>
                                </div>
                            </div>

                            
                             <div  class="col-md-4">
                                <div class="form-group"><br>
                                    <Label>Edad(*)</Label>
                                    <input type="text" class="form-control" v-model="edad" placeholder="Edad" maxlength="15"> 
                                </div>
                            </div>

                             <div  class="col-md-4">
                                <div class="form-group"><br>
                                    <Label>Sexo(*)</Label>
                                    <select class="form-control" v-model="sexo">
                                        <option value="Macho">Macho</option>
                                        <option value="Hembra">Hembra</option>
                                    </select>
                                </div>
                            </div>
                            
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
                                <button type="submit" class="btn btn-primary" @click="actualizar()">Actualizar mascota</button>
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
                                <table class="table table-bordered table-striped table-sm">
                                <thead>
                                        <tr>
                                            <th colspan="2"><center>Detalle de datos de la mascota</center></th>
                                        </tr>
                                    </thead>
                                    <tbody v-for="mostrarDatos in arrayMostrarDatos" :key="mostrarDatos.id">  
                                    <tr>
                                        <td style="width:230px"><b>Mascota</b></td>
                                        <td v-text="mostrarDatos.nombreMascota"></td>
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
                                        <td><b>Fecha Nacimiento</b></td>
                                        <td v-text="mostrarDatos.fechaNacimiento"></td>
                                    </tr>

                                    <tr>
                                        <td><b>Edad</b></td>
                                        <td v-text="mostrarDatos.edad"></td>
                                    </tr>

                                    <tr>
                                        <td><b>Sexo</b></td>
                                        <td v-text="mostrarDatos.sexo"></td>
                                    </tr>

                                    <tr>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td><b>Nombre del Cliente</b></td>
                                        <td v-text="mostrarDatos.nombre + ' ' + mostrarDatos.apellidos"></td>
                                    </tr>

                                     <tr>
                                        <td><b>Cédula</b></td>
                                        <td v-text="mostrarDatos.cedula"></td><br>
                                    </tr>

                                       <tr>
                                        <td><b>Dirección</b></td>
                                        <td v-text="mostrarDatos.direccion"></td>
                                    </tr>
                                       <tr>
                                        <td><b>Teléfono</b></td>
                                        <td v-text="mostrarDatos.telefono"></td>
                                    </tr>

                                     <tr>
                                        <td><b>Celular</b></td>
                                        <td v-text="mostrarDatos.celular"></td><br>
                                    </tr>
                                    <tr>
                                        <td><b>Email</b></td>
                                        <td v-text="mostrarDatos.email"></td><br>
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
    //import vSelect from 'vue-select';//Importacion de vue-select para filtar los estudiantes
    //import 'vue-select/dist/vue-select.css';

    import Datepicker from 'vuejs-datepicker';
    import { es } from 'vuejs-datepicker/dist/locale'
    export default {
        data() {
            return {
                es: es,
                idCliente: '',
                idMascota: '',
                nombreMascota: '',
                especie: '',
                raza: '',
                fechaNacimiento: '',
                edad: '',
                sexo: '',
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
           
        }, 
    
        methods: {
            getPersona() {
                let me = this;
                var url = '/clientes/select-cliente';
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
                var url = '/mascotass?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function(response) {
                        var respuesta = response.data;
                        me.arrayRegistros = respuesta.mascotas.data;
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
            
                axios.post('/mascotas/registrar',{     
                    idCliente: this.idCliente.id,
                    nombreMascota: this.nombreMascota,
                    especie: this.especie,
                    raza: this.raza,
                    fechaNacimiento: this.fechaNacimiento,
                    edad: this.edad,
                    sexo: this.sexo,

                }).then(response=>  {
                    this.cerrarTemplateRegistro();
                    this.listar(1,'','apellidos');

                    swal({
                        title: 'Mascota Registrada!!',
                        type:  'success',
                        text:  'La información a sido guardada',
                    })
                }).catch(error =>{
                    swal({
                        title: 'Mascota no registrada!!',
                        type:  'error',
                        text:  'La información no a sido guardada',
                    })
                    console.log(error);
                });
            
            },
            editar(id) {
                this.templateEditar();
                let me = this;
                var url = '/mascotas/obtener?id=' + id;
                var arrayEditarDatos=[];
                axios.get(url).then(function(response) {
                    var respuesta= response.data;
                    arrayEditarDatos = respuesta.mascotas;
                    me.idMascota = arrayEditarDatos[0]['id'];
                    me.idCliente = arrayEditarDatos[0]['idCliente'];
                    me.nombreMascota = arrayEditarDatos[0]['nombreMascota'];
                    me.especie = arrayEditarDatos[0]['especie'];
                    me.raza = arrayEditarDatos[0]['raza'];
                    me.fechaNacimiento = arrayEditarDatos[0]['fechaNacimiento'];
                    me.edad = arrayEditarDatos[0]['edad'];
                    me.sexo = arrayEditarDatos[0]['sexo'];

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
                 if (this.validarDatos()){
                    return;
                }

                axios.put('/mascotas/actualizar',{
                    idCliente: this.idCliente,
                    nombreMascota: this.nombreMascota,
                    especie: this.especie,
                    raza: this.raza,
                    fechaNacimiento: this.fechaNacimiento,
                    edad: this.edad,
                    sexo: this.sexo,
                    id: this.idMascota
                }).then(response =>  {
                    this.cerrarTemplateRegistro();
                    this.listar(1,'','apellidos');

                    swal({
                        title: 'Mascota Actualizado!!',
                        type:  'success',
                        text:  'La información a sido actualizada',
                    })
                }).catch(error =>  {
                    swal({
                        title: 'Error al actualizar!!',
                        type:  'error',
                        text:  'La información no a sido actualizada',
                    }) 
                    console.log(error);                 
                }); 
            },  
            obtenerRegistro(id) {
                let me = this;//metodo para mostrar los datos
                this.template = 2;

                var url = '/mascotas/obtener?id=' + id;
                axios.get(url).then(function(response) {
                    var respuesta = response.data;
                    me.arrayMostrarDatos = respuesta.mascotas;
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
                if (!this.idCliente) this.errorMostrarMsj.push("Seleccione el nombre del cliente");
                if (!this.nombreMascota) this.errorMostrarMsj.push("El nombre de la mascota es requerido");
                if (!this.especie) this.errorMostrarMsj.push("La especie de la mascota es requerido");
                if (!this.raza) this.errorMostrarMsj.push("La raza de la mascota es requerido");
                if (!this.fechaNacimiento) this.errorMostrarMsj.push("La fecha de nacimiento de la mascota es requerido");
                if (!this.edad) this.errorMostrarMsj.push("La edad de la mascota es requerido");
                if (!this.sexo) this.errorMostrarMsj.push("El sexo de la mascota es requerido");
        
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
                this.idCliente = '';
                this.nombreMascota = '';    
                this.especie = '';          
                this.raza = '';
                this.fechaNacimiento = '';
                this.edad = ''; 
                this.sexo = ''; 
                this.errorMostrarMsj = '';      
            },
            templateRegistrar() {
                this.getPersona();
                this.template = 0;
                this.idCliente = '';
                this.nombreMascota = '';    
                this.especie = '';          
                this.raza = '';
                this.fechaNacimiento = '';
                this.edad = ''; 
                this.sexo = '';
                this.errorMostrarMsj = '';
            },
            templateEditar() {
                this.getPersona();
                
                this.template = 3;
                this.idCliente = '';
                this.nombreMascota = '';    
                this.especie = '';          
                this.raza = '';
                this.fechaNacimiento = '';
                this.edad = ''; 
                this.sexo = '';
                this.errorMostrarMsj = '';
            },
            eliminar(id){
            // window.swal = require('sweetalert2') // added here
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
                    var url = '/mascotas/delete/' +id;
                   axios.delete(url).then(function (response) {

                    me.listar(1,'','apellidos');
                    swal(
                    'Eliminado!',
                    'El registro ha sido eliminado con éxito.',
                    'success'
                    )
                }).catch(function (error) {
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

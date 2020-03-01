<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol></ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="icon-user-follow"></i> Registro de personas que desean dar en adopción una mascota
                </div>
                <!-- --------------------------------------------------------------------------------->
                <!--  PRINCIPAL-->
                <template v-if="template==1">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-11">
                                <div class="input-group"><!--Criterios de busqueda -->
                                    <select class="form-control col-md-2" v-model="criterio">
                                        <option value="apellidos">Apellidos</option> 
                                        <option value="cedula">Cédula</option> 
                                    </select>

                                    <input type="text" v-model="buscar" @keyup.enter="listar(1,buscar,criterio)" class="form-control col-md-4" placeholder="Busqueda">
                                    
                                    <button type="submit" @click="listar(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                   
                                    <div class="btn-group col-md-2">
                                        <button id='terms' type="button" @click="templateRegistrar()" class="btn btn-primary">
                                            <i class="icon-plus"></i>&nbsp;Registrar persona
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
                                        <th>Nombre</th>
                                        <th>Cédula</th>
                                        <th>Dirección</th>
                                        <th>Teléfono</th>
                                        <th>Celular</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="registro in arrayRegistros" :key="registro.id">
                                        <td style="width:110px">

                                         <span v-if="registro.estado"> 
                                              <!------si el estado es 0 la persona es cliente y no se podra editar---->
                                              
                                         </span> 
                                         <span v-else> 
                                             <button type="button" @click="editar(registro.id)" class="btn btn-warning btn-sm">
                                                <i class="icon-pencil"></i>
                                            </button>&nbsp;

                                        <button type="button" class="btn btn-danger btn-sm" @click="eliminar(registro.id)">
                                            <i class="icon-trash"></i>
                                        </button>  
                                        </span>                         
                                            

                                      <!--    <span>
                                             <button type="button" @click="editar(registro.id)" class="btn btn-warning btn-sm">
                                                <i class="icon-pencil"></i>
                                            </button>&nbsp;

                                        <button type="button" class="btn btn-danger btn-sm" @click="eliminar(registro.id)">
                                            <i class="icon-trash"></i>
                                        </button>  
                                        </span>    -->                      
                                            
                                        </td>
                                        <td v-text="registro.nombre + ' ' + registro.apellidos"></td>
                                        <td v-text="registro.cedula"></td>
                                        <td v-text="registro.direccion"></td>
                                        <td v-text="registro.telefono"></td>
                                        <td v-text="registro.celular"></td>
                                        <td v-text="registro.email"></td>
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
                         <Label><b class="labelContacto"> Registro de Datos</b></Label>
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
                            <div class="col-md-4">
                                <div class="form-group"><br>
                                    <Label>Nombre(*)</Label>
                                    <input type="text" class="form-control" v-model="nombre" placeholder="Nombre" maxlength="14"> 
                                    <div v-if="errors && errors.nombre" class="text-danger">{{ errors.nombre[0] }}</div> 
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group"><br>
                                    <Label>Apellido(*)</Label>
                                    <input type="text" class="form-control" v-model="apellidos" placeholder="Apellidos" maxlength="40"> 
                                    <div v-if="errors && errors.apellidos" class="text-danger">{{ errors.apellidos[0] }}</div> 
                                </div>
                            </div>

                             <div class="col-md-4">
                                <div class="form-group"><br>
                                    <Label>Cédula(*)</Label>
                                    <input type="text" class="form-control" v-model="cedula" placeholder="Cédula" maxlength="10"> 
                                    <div v-if="errors && errors.cedula" class="text-danger">{{ errors.cedula[0] }}</div> 
                                </div>
                            </div>

                             <div class="col-md-4">
                                <div class="form-group"><br>
                                    <Label>Dirección(*)</Label>
                                    <input type="text" class="form-control" v-model="direccion" placeholder="Dirección" maxlength="70"> 
                                    <div v-if="errors && errors.direccion" class="text-danger">{{ errors.direccion[0] }}</div> 
                                </div>
                            </div>
                        

                             <div class="col-md-4">
                                <div  class="form-group"><br>
                                    <Label>Teléfono(*)</Label>
                                    <input type="text" class="form-control" v-model="telefono" placeholder="Teléfono" maxlength="10"> 
                                    <div v-if="errors && errors.telefono" class="text-danger">{{ errors.telefono[0] }}</div> 
                                </div>
                            </div>

                             <div  class="col-md-4">
                                <div class="form-group"><br>
                                    <Label>Celular(*)</Label>
                                    <input type="text" class="form-control" v-model="celular" placeholder="Celular" maxlength="10"> 
                                    <div v-if="errors && errors.celular" class="text-danger">{{ errors.celular[0] }}</div> 
                                </div>
                            </div> 

                             <div  class="col-md-4">
                                <div class="form-group"><br>
                                    <Label>Email(*)</Label>
                                    <input type="text" class="form-control" v-model="email" placeholder="Email" maxlength="40"> 
                                    <div v-if="errors && errors.email" class="text-danger">{{ errors.email[0] }}</div> 
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
                                <button type="submit" class="btn btn-primary" @click="registrar()">Registrar Datos</button>
                            </div>
                        </div>
                    </div><!--fin 2do card body-->
                </template>
                <!-- Fin Registro de datos-->

                 <!-- --------------------------------------------------------------------------------->
                <!-- Edicion de datos-->
                 <template v-else-if="template==3">
                     <div class="text-center"><br>
                         <Label><b class="labelContacto"> Edición del Datos</b></Label>
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
                            <div class="col-md-4">
                                <div class="form-group"><br>
                                    <Label>Nombre(*)</Label>
                                    <input type="text" class="form-control" v-model="nombre" placeholder="Nombre" maxlength="14"> 
                                    <div v-if="errors && errors.nombre" class="text-danger">{{ errors.nombre[0] }}</div> 
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group"><br>
                                    <Label>Apellido(*)</Label>
                                    <input type="text" class="form-control" v-model="apellidos" placeholder="Apellidos" maxlength="40"> 
                                    <div v-if="errors && errors.apellidos" class="text-danger">{{ errors.apellidos[0] }}</div> 
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group"><br>
                                    <Label>Cédula(*)</Label>
                                    <input type="text" class="form-control" v-model="cedula" placeholder="Cédula" maxlength="10"> 
                                    <div v-if="errors && errors.cedula" class="text-danger">{{ errors.cedula[0] }}</div> 
                                </div>
                            </div>
                          
                             <div class="col-md-4">
                                <div class="form-group"><br>
                                    <Label>Dirección(*)</Label>
                                    <input type="text" class="form-control" v-model="direccion" placeholder="Dirección" maxlength="70"> 
                                    <div v-if="errors && errors.direccion" class="text-danger">{{ errors.direccion[0] }}</div> 
                                </div>
                            </div>
                          

                            <div class="col-md-4">
                                <div  class="form-group"><br>
                                    <Label>Teléfono(*)</Label>
                                    <input type="text" class="form-control" v-model="telefono" placeholder="Teléfono" maxlength="10"> 
                                    <div v-if="errors && errors.telefono" class="text-danger">{{ errors.telefono[0] }}</div> 
                                </div>
                            </div>

                             <div  class="col-md-4">
                                <div class="form-group"><br>
                                    <Label>Celular(*)</Label>
                                    <input type="text" class="form-control" v-model="celular" placeholder="Celular" maxlength="10"> 
                                    <div v-if="errors && errors.celular" class="text-danger">{{ errors.celular[0] }}</div> 
                                </div>
                            </div>

                             <div  class="col-md-4">
                                <div class="form-group"><br>
                                    <Label>Email(*)</Label>
                                    <input type="text" class="form-control" v-model="email" placeholder="Email" maxlength="40"> 
                                    <div v-if="errors && errors.email" class="text-danger">{{ errors.email[0] }}</div> 
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
                                <button type="submit" class="btn btn-primary" @click="actualizar()">Actualizar Datos</button>
                            </div>
                        </div>
                    </div><!--fin 2do card body-->
                </template>
                 <!-- fin  Edicion de datos-->
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
      
    </main>
    
</template>



<script> 
    export default {
        data() {
            return {
                errors: {},
                idPersona: '',     
                nombre: '',
                apellidos: '',
                cedula: '',
                email: '', 
                direccion: '',
                telefono: '',
                celular: '',
                name:'', //se registrara para crear el usuario
                email:'', 
                rol:'',
                password:'',
                estado:'',
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
                let me = this
                var url = '/datos?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function(response) {
                        var respuesta = response.data;
                        me.arrayRegistros = respuesta.personas.data;
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
                this.errors = {};
                axios.post('/datos/registrar',{     
                    nombre: this.nombre,
                    apellidos: this.apellidos,
                    cedula: this.cedula,
                    direccion: this.direccion,
                    telefono: this.telefono,
                    celular: this.celular,
                    email: this.email,

                }).then(response=>  {
                    this.cerrarTemplateRegistro();
                    this.listar(1,'','apellidos');

                    swal({
                        title: 'Datos Registrado!!',
                        type:  'success',
                        text:  'La información a sido guardada',
                    })
                    console.clear()
                })
                .catch(error => {
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
                var url = '/datos/obtener?id=' + id;
                var arrayEditarDatos=[];
                axios.get(url).then(function(response) {
                    var respuesta= response.data;
                    arrayEditarDatos = respuesta.personas;
                    me.idPersona = arrayEditarDatos[0]['id'];
                    me.nombre = arrayEditarDatos[0]['nombre'];
                    me.apellidos = arrayEditarDatos[0]['apellidos'];
                    me.cedula = arrayEditarDatos[0]['cedula'];
                    me.direccion = arrayEditarDatos[0]['direccion'];
                    me.telefono = arrayEditarDatos[0]['telefono'];
                    me.celular = arrayEditarDatos[0]['celular'];
                    me.email = arrayEditarDatos[0]['email'];

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

                this.errors = {};

                axios.put('/datos/actualizar',{
                    nombre: this.nombre,
                    apellidos: this.apellidos,
                    cedula: this.cedula,
                    direccion: this.direccion,
                    telefono: this.telefono,
                    celular: this.celular,
                    email: this.email,
                    id: this.idPersona
                }).then(response =>  {
                    this.cerrarTemplateRegistro();
                    this.listar(1,'','apellidos');

                    swal({
                        title: 'Datos Actualizado!!',
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
            validarDatos() {//Validaciones para el registro de los datos 
                this.errorValidacion = 0;
                this.errorMostrarMsj = [];
                if (!this.nombre) this.errorMostrarMsj.push("El nombre de la persona es requerido");
                if (!this.apellidos) this.errorMostrarMsj.push("El apellido de la persona es requerido");
                if (!this.direccion) this.errorMostrarMsj.push("La direccion de la persona es requerido");
                if (!this.cedula) this.errorMostrarMsj.push("La cedula de la persona es requerido");
                if (!this.telefono) this.errorMostrarMsj.push("El telefono de la persona es requerido");
                if (!this.celular) this.errorMostrarMsj.push("El celular de la persona es requerido");
                if (!this.email) this.errorMostrarMsj.push("El email celular de la persona es requerido");
        
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
                this.nombre = '';
                this.apellidos = '';    
                this.cedula = '';          
                this.direccion = '';
                this.telefono = '';
                this.celular = '';  
                this.email = '';  
                this.errors= '';
                this.errorMostrarMsj = '';      
            },
            templateRegistrar() {
               
                this.template = 0;
                this.nombre = '';
                this.apellidos = '';    
                this.cedula = '';          
                this.direccion = '';
                this.telefono = '';
                this.celular = ''; 
                this.email = '';  
                this.errors= '';
                this.errorMostrarMsj = '';
            },
            templateEditar() {
                
                this.template = 3;
                this.nombre = '';
                this.apellidos = '';    
                this.cedula = '';          
                this.direccion = '';
                this.telefono = '';
                this.celular = ''; 
                this.email = '';  
                this.errors= '';
                this.errorMostrarMsj = '';
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
                        var url = '/datos/delete/' +id;
                    axios.delete(url).then(function (response) {

                        me.listar(1,'','apellidos');
                        swal(
                        'Eliminado!',
                        'El registro ha sido eliminado con éxito.',
                        'success'
                        )
                    }).catch((error) => {
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

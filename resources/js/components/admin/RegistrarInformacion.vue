<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol></ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="icon-chart"></i> Registro de Información para mostrar en el sitio web
                </div>
                <!-- --------------------------------------------------------------------------------->
                <!--  PRINCIPAL-->
                <template v-if="template==1">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-11">
                                <div class="input-group"><!--Criterios de busqueda -->
                                    <select class="form-control col-md-2" v-model="criterio">
                                        <option value="tema">Tema</option> 
                                        <option value="capacitador">Capacitador</option> 
                                    </select>

                                    <input type="text" v-model="buscar" @keyup.enter="listar(1,buscar,criterio)" class="form-control col-md-4" placeholder="Busqueda">
                                    
                                    <button type="submit" @click="listar(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                   
                                    <div class="btn-group col-md-2">
                                        <button id='terms' type="button" @click="templateRegistrar()" class="btn btn-primary">
                                            <i class="icon-plus"></i>&nbsp;Registrar Información
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
                                        <th>Tema</th>
                                        <th>Capacitador</th>
                                        <th>Conoce</th>
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
                                       <!-- <td v-text="persona.nombres + ' ' + persona.apellidos"></td>-->
                                        <td v-text="registro.tema"></td>
                                        <td v-text="registro.capacitador"></td>
                                        <td v-text="registro.conoce"></td>
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
                         <Label><b class="labelContacto"> Información a publicar</b></Label>
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
                            <form enctype="multipart/form-data"  class="col-md-12">

                                <div class="col-md-8">
                                    <div class="form-group"><br>
                                        <Label>Tema(*)</Label>
                                        <input type="text" class="form-control" v-model="informacion.tema" placeholder="Tema" maxlength="200"> 
                                    </div>
                                </div>
                            
                                <div class="col-md-8">
                                    <div class="form-group"><br>
                                        <Label>Capacitador(*)</Label>
                                        <input type="text" class="form-control" v-model="informacion.capacitador" placeholder="Capacitador" maxlength="200"> 
                                    </div>
                                </div>
                        
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <Label>Conoce(*)</Label>
                                        <textarea rows="4" cols="50" maxlength="200" class="form-control"  v-model="informacion.conoce" placeholder="Conoce"> </textarea> 
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <Label>Seleccione la imagen(*)</Label>
                                        <input type="file" @change="obtenerImagen" ref="file" accept=".jpg, .png, .jpeg" class="form-control file">
                                    </div>
                                </div> 

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div> <br>
                                            <span type="hidden"><img :src="imagen" alt="Imagen a cargar" width="100%" height="100%"></span>
                                        </div>
                                    </div>
                                </div>
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
                                <button type="submit" class="btn btn-primary" @click="registrar()">Registrar Información</button>
                            </div>
                        </div>
                    </div><!--fin 2do card body-->
                </template>
                <!-- Fin Registro de datos-->

                 <!-- --------------------------------------------------------------------------------->
                <!-- Edicion de datos-->
                 <template v-else-if="template==3">
                     <div class="text-center"><br>
                         <Label><b class="labelContacto"> Editar Información a publicar</b></Label>
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
                            <form enctype="multipart/form-data"  class="col-md-12">

                                <div class="col-md-8">
                                    <div class="form-group"><br>
                                        <Label>Tema(*)</Label>
                                        <input type="text" class="form-control" v-model="informacion.tema" placeholder="Tema" maxlength="200"> 
                                    </div>
                                </div>
                            
                                <div class="col-md-8">
                                    <div class="form-group"><br>
                                        <Label>Capacitador(*)</Label>
                                        <input type="text" class="form-control" v-model="informacion.capacitador" placeholder="Capacitador" maxlength="200"> 
                                    </div>
                                </div>
                        
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <Label>Conoce(*)</Label>
                                        <textarea rows="4" cols="50" maxlength="200" class="form-control"  v-model="informacion.conoce" placeholder="Conoce"> </textarea> 
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <Label>Seleccione la imagen(*)</Label>
                                        <input type="file" @change="obtenerImagenEdit" ref="file" accept=".jpg, .png, .jpeg" class="form-control file">
                                    </div>
                                </div> 


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div> <br>
                                            <span type="hidden"><img :src="imagen" alt="Imagen a cargar" width="100%" height="100%"></span>
                                        </div>
                                    </div>
                                </div>
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
                                <button type="submit" class="btn btn-primary" @click="actualizar()">Actualizar Información</button>
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
                                    <div v-for="mostrarDatos in arrayMostrarDatos" :key="mostrarDatos.id">  
                                        <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th colspan="2"><center>Detalle de la información</center></th>
                                            </tr>
                                        </thead>
                                        <tbody>  
                                            <tr>
                                                <td style="width:230px"><b>Usuario</b></td>
                                                <td v-text="mostrarDatos.name"></td>
                                            </tr>
                                            <tr>
                                                <td><b>Tema</b></td>
                                                <td v-text="mostrarDatos.tema"></td>
                                            </tr>
                                            <tr>
                                                <td><b>Capacitador</b></td>
                                                <td v-text="mostrarDatos.capacitador"></td>
                                            </tr>

                                            <tr>
                                                <td><b>Conoce</b></td>
                                                <td v-text="mostrarDatos.conoce"></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                        </table>
                                        <div class="col-md-12">
                                                <div class="form-group">
                                                    <div> <br>
                                                        <center><img :src="'/informacion/'+mostrarDatos.imagen" alt="Informacion" width="50%" height="50%"></center>
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
    export default {
        data() {
            return {
                informacion: {
                    tema: '',
                    capacitador: '',
                    conoce: '',
                    imagenCargar: '',
                    imagenMiniatura: '',
                    id: '',
                },
                name: '',
               
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
                criterio: 'tema',
                buscar: '',  
                file: '', 
       
				
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
            obtenerImagen(e){
             //  let me = this;
                this.file = e.target.files[0];//img en la posicion 0
                this.imagenCargar = this.file['name']; //agregamos la informacion
                this.cargarImagen(this.file);
               
                
                if (this.validarDatos()) {
                    return;
                }
            },
            obtenerImagenEdit(e){
             //  let me = this;
                this.file = e.target.files[0];//img en la posicion 0
                this.imagenCargar = this.file['name']; //agregamos la informacion
                this.cargarImagen(this.file);
               
                
                if (this.validarDatosEdit()) {
                    return;
                }
            },

            cargarImagen(file){
                let reader = new FileReader();
                reader.onload = (e) =>{
                    this.informacion.imagenMiniatura = e.target.result;
                }
                reader.readAsDataURL(file);
            },
            listar(page, buscar, criterio) {
                let me = this;
                var url = '/infom?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
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
            registrar(){
                if (this.validarDatos()) {
                    return;
                }
                let me = this;
        
                axios.post('/informacion/registrar', this.informacion )   
                  
                .then((response) => {
                    this.listar(1,'','conoce');
                    this.cerrarTemplateRegistro();

                    swal({
                        title: 'Información registrada!!',
                        type:  'success',
                        text:  'La información a sido publicada',
                    })

                }).catch((error) =>{
                    swal({
                        title: 'Información no registrada!!',
                        type:  'error',
                        text:  'La información no a sido publicada',
                    })
                    console.log(error);
                });
              
            },
           
            editar(id) {
                this.templateEditar();
                this.template=3; //abro el template para editar
                let me = this;
                var url = '/informacion/obtener?id=' + id;
                var arrayEditarDatos=[];
                var ruta = '/informacion/'
                axios.get(url).then(function(response) {
                    var respuesta= response.data;
                    arrayEditarDatos = respuesta.informacion;
                    me.informacion.id = arrayEditarDatos[0]['id'];
                    me.informacion.tema = arrayEditarDatos[0]['tema'];
                    me.informacion.capacitador = arrayEditarDatos[0]['capacitador'];
                    me.informacion.conoce = arrayEditarDatos[0]['conoce'];
                    me.informacion.imagenMiniatura = arrayEditarDatos[0]['imagen'];
                    me.informacion.imagenMiniatura = 'http://localhost:8000/informacion/' + ''+me.informacion.imagenMiniatura;
                
                }).catch((error) =>{
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
                
                let me = this;

                axios.put('/informacion/actualizar', me.informacion)   
                
                .then((response) => {
                    this.cerrarTemplateRegistro();
                    this.listar(1,'','conoce');
                    
                    swal({
                        title: 'Información Actualizada!!',
                        type:  'success',
                        text:  'La información a sido actualizada',
                    })
                }).catch( (error) =>{
                    swal({
                        title: 'Error al actualizar!!',
                        type:  'error',
                        text:  'La información no a sido actualizada',
                    }) 
                    console.log(error);
                }); 


            }, 
            validarDatos() {//Validaciones para el registro de los datos
                this.errorValidacion = 0;
                this.errorMostrarMsj = [];
                if (!this.informacion.tema) this.errorMostrarMsj.push("El tema de la informacion es requerido");
                if (!this.informacion.capacitador) this.errorMostrarMsj.push("El campo capacitador es requerido");
                if (!this.informacion.conoce) this.errorMostrarMsj.push("El campo conoce es requerido");

            

                if (!this.file) {
                        this.errorMostrarMsj.push("Seleccione una imagen para subir");
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
                if (!this.informacion.tema) this.errorMostrarMsj.push("El tema de la informacion es requerido");
                if (!this.informacion.capacitador) this.errorMostrarMsj.push("El campo capacitador es requerido");
                if (!this.informacion.conoce) this.errorMostrarMsj.push("El campo conoce es requerido");

               
               if(this.file) { 
                    if(this.file['type'] != 'image/png' && this.file['type'] != 'image/jpg' && this.file['type'] != 'image/jpeg')  {
                             this.errorMostrarMsj.push("Formato de archivo no permitido!"); 
                    } 
                }else{
                    return;
                }


                
                /*   if (!this.file) {
                    this.errorMostrarMsj.push("Seleccione una imagen para subir");
                } else
                if(this.file['type'] != 'image/png' && this.file['type'] != 'image/jpg' && this.file['type'] != 'image/jpeg'){
                    this.errorMostrarMsj.push("Formato de archivo no permitido!");
                    this.file = '';
                }*/
                
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
                me.informacion.tema = '';
                me.informacion.capacitador = '';              
                me.informacion.conoce = '';
                me.informacion.imagenMiniatura = '';
                me.informacion.imagenCargar = '';
                me.file = '';
                me.errorMostrarMsj = '';

            },
            templateRegistrar() {
                let me = this;
                this.template = 0;
                me.informacion.tema = '';
                me.informacion.capacitador = '';              
                me.informacion.conoce = '';
                me.informacion.imagenMiniatura = '';
                me.informacion.imagenCargar = '';
                me.file = '';
                me.errorMostrarMsj = '';
            },
            templateEditar() {
                let me = this;
                this.template = 3;
                me.informacion.tema = '';
                me.informacion.capacitador = '';              
                me.informacion.conoce = '';
                me.informacion.imagenMiniatura = '';
                me.informacion.imagenCargar = '';
                me.file = '';
                me.errorMostrarMsj = '';
            },
            obtenerRegistro(id) {
                let me = this;//metodo para mostrar los datos
                this.template = 2;

                var url = '/informacion/obtener?id=' + id;
                axios.get(url).then(function(response) {
                    var respuesta = response.data;
                    me.arrayMostrarDatos = respuesta.informacion;
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
                        var url = '/informacion/delete/' +id;
                    axios.delete(url).then(function (response) {

                        me.listar(1,'','name');
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
        },
        mounted() {
            this.listar(1, this.buscar, this.criterio);
        }
    }
</script>
<style>

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

    .swal2-title {
      font-size: 20px !important;
    }

    .swal2-content {
      font-size: 15px !important;
    }
</style> 

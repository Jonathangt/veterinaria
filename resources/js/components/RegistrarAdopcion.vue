<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol></ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="icon-chart"></i> Registro de Mascotas para adopción
                </div>
                <!-- --------------------------------------------------------------------------------->
                <!--  PRINCIPAL-->
                <template v-if="template==1">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-11">
                                <div class="input-group"><!--Criterios de busqueda y btn para descargar formato de excel-->
                                    <select class="form-control col-md-2" v-model="criterio">
                                        <option value="nombreMascota">Mascota</option> 
                                    </select>

                                    <input type="text" v-model="buscar" @keyup.enter="listar(1,buscar,criterio)" class="form-control col-md-4" placeholder="Busqueda">
                                    
                                    <button type="submit" @click="listar(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                   
                                    <div class="btn-group col-md-2">
                                        <button id='terms' type="button" @click="registrarDatos()" class="btn btn-secondary">
                                            <i class="icon-plus"></i>&nbsp;Registrar Datos
                                        </button>
                                        
                                    </div>

                                    <div class="btn-group col-md-2">
                                        <button type="button" @click="registrarMascota()" class="btn btn-secondary">
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
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Cedula</th>
                                        <th>Celular</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="registro in arrayRegistros" :key="registro.id">
                                        <td style="width:170px">
                                           <button type="button" @click="obtenerRegistro(registro.id)" class="btn btn-success btn-sm">
                                                <i class="icon-eye"></i>
                                            </button> &nbsp;
                                            
                                            <button type="button" @click="obtenerPDF(registro.id)" class="btn btn-info btn-sm">
                                                <i class="icon-doc"></i>
                                            </button> &nbsp;
                                            <button type="button" class="btn btn-danger btn-sm" @click="eliminar(registro.id)">
                                                <i class="icon-trash"></i>
                                            </button>                       
                                        </td>
                                       <!-- <td v-text="persona.nombres + ' ' + persona.apellidos"></td>-->
                                        <td v-text="registro.nombre  + ' ' + registro.apellidos"></td>
                                        <td v-text="registro.email"></td>
                                        <td v-text="registro.cedula"></td>
                                        <td v-text="registro.celular"></td>
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
                    <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <Label>Nombres(*)</Label>
                                    <input type="text" class="form-control" v-model="nombre" placeholder="Nombre" maxlength="40"> 
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <Label>Apellidos(*)</Label>
                                    <input type="text" class="form-control" v-model="apellidos" placeholder="Apellidos" maxlength="40"> 
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <Label>Cédula</Label>
                                    <input type="text" class="form-control" v-model="cedula" placeholder="Cédula" maxlength="10"> 
                                </div>
                            </div>

                    
                            <div class="col-md-4">
                                <div class="form-group">
                                    <Label>Teléfono</Label>
                                    <input type="text" class="form-control" v-model="telefono" placeholder="Teléfono" maxlength="10"> 
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <Label>Celular (*)</Label>
                                    <input type="text" class="form-control" v-model="celular" placeholder="Celular" maxlength="10"> 
                                </div>
                            </div> 

                            <div class="col-md-8">
                                <div class="form-group">
                                    <Label>Direccón</Label>
                                    <input type="text" class="form-control" v-model="direccion" placeholder="Dirección" maxlength="70"> 
                                </div>
                            </div>            
            
                        </div>
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
                                <button type="button" @click="cerrarTemplateRegistro()" class="btn btn-secondary">Cerrar</button>
                                <button type="submit" class="btn btn-primary" @click="RegistrarDatos()">Registrar mis datos</button>
                            </div>
                        </div>
                    </div>
                </template>
                <!-- Fin Registro de datos-->

                 <!-- --------------------------------------------------------------------------------->
                <!-- Registro de datos mascota-->
                <template v-else-if="template==3">
                    <div class="card-body">
                        <div class="form-group row border">

                            <div class="row col-md-8">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <Label>Nombre de la mascota(*)</Label>
                                        <input type="text" class="form-control" v-model="fechaNacimiento" placeholder="Nombre de la mascota" maxlength="20"> 
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <Label>Fecha Nacimiento</Label>
                                        <input type="date" class="form-control" v-model="fechaNacimiento" placeholder="Fecha nacimiento" maxlength="40"> 
                                    </div>
                                </div>
                            </div>

                            <div class="row col-md-8">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <Label>Edad</Label>
                                        <input type="text" class="form-control" v-model="fechaNacimiento" placeholder="Edad" maxlength="40"> 
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <Label>Especie</Label>
                                        <input type="text" class="form-control" v-model="fechaNacimiento" placeholder="Especie" maxlength="40"> 
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row col-md-8">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <Label>Raza</Label>
                                        <input type="text" class="form-control" v-model="fechaNacimiento" placeholder="Raza" maxlength="40"> 
                                    </div>
                                </div> 
                                 <div class="col-md-6">
                                    <div class="form-group">
                                        <Label>Imagen</Label>
                                        <input type="file" id="file" ref="file" v-on:change="handleFileUpload()" accept=".jpg, .png" class="form-control"> 
                                    </div>
                                </div>  

                            </div>


                             <div class="row col-md-8">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <Label>Observacion</Label>
                                        <textarea rows="4" class="form-control" cols="50" > </textarea> 
                                    </div>
                                </div>
                            </div>

                       </div>
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
                                <button type="button" @click="cerrarTemplateMascota()" class="btn btn-secondary">Cerrar</button>
                                <button type="submit" class="btn btn-primary" @click="RegistrarDatos()">Registrar mascota par adopción</button>
                            </div>
                        </div>
                    </div>                    
                </template>
                <!-- Fin Registro de datos mascota-->

                <!-----------------------------Tabla para visualizar las mallas registradas--->
                <!-- Ver Materias de Malla -->
                <template v-else-if="template==2">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="col-md-12">
                                <center><h5>Universidad de Guayaquil</h5></center>
                                <span v-for="carrera in arrayFacultadCarreraMalla" :key="carrera.id" :value="carrera.id">
                                    <center><h5 v-text="carrera.nombreFacultad"></h5></center>
                                    <center> 
                                        <span>Carrera de</span> 
                                        <span v-text="carrera.nombreCarrera"> </span>
                                    </center>
                                </span>
                            </div>

                                <div class="col-md-12">
                                    <center>
                                        <span>Pénsum Académico para Año Lectivo</span>      
                                        <span v-text="pAcademicoInicio"> </span>
                                        <span v-text="cicloLectivoInicio"> </span>
                                        <span> - </span>   
                                        <span v-text="pAcademicoFin"> </span>
                                        <span v-text="cicloLectivoFin"> </span>
                                    </center>
                                </div>
                            </div>
                        <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>                                           
                                            <th>#</th>
                                            <th>Nombre de Materias</th>
                                            <th>Código</th>
                                            <th>Nivel</th>
                                            <th>Pre-Requisitos</th>
                                            <th>Créditos</th>
                                            <th>C. Docente</th>
                                            <th>C. Práctico</th>
                                            <th>C. Autónomo</th>
                                            <th>Totales</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="malla_materias in arrayMallaMaterias" :key="malla_materias.id">   
                                        <td class="centerTabla" v-text="malla_materias.num"></td>
                                        <td v-text="malla_materias.nombre_materias"></td>                                           
                                        <td class="centerTabla" v-text="malla_materias.codigo"></td>
                                        <td class="centerTabla" v-text="malla_materias.nivel"></td>
                                        <td v-text="malla_materias.pre_requisitos"></td>
                                        <td class="centerTabla" v-text="malla_materias.creditos"></td>
                                        <td class="centerTabla" v-text="malla_materias.c_docente"></td>
                                        <td class="centerTabla" v-text="malla_materias.c_practico"></td>    
                                        <td class="centerTabla" v-text="malla_materias.c_autonomo"></td>      
                                        <td class="centerTabla" v-text="malla_materias.totales"></td>                          
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="cerrarTemplateRegistro()" class="btn btn-secondary">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </template>
                <!-- fin Materias de Malla -->
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>


      
    </main>
    
</template>



<script>
   
    export default {
        data() {
            return {
                nombre: '',
                apellidos: '',
                cedula: '',
                telefono: '',
                celular: '',
                direccion: '',
               
                pAcademicoInicio: '',
                cicloLectivoInicio: '',
                pAcademicoFin: '',
                cicloLectivoFin: '',
                arrayCarrera: [],
                arrayFacultadCarreraMalla: [],
                arrayRegistros: [],
                arrayMallaMaterias: [],
                errorMostrarMsj: [],
               
               
                errorValidacion: 0,
                e: '',
                file: '', // var para importar el excel     

                template: 1,
                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                },
                offset: 3,
                criterio: 'nombreMascota',
                buscar: '',
                getID: '',
                terms: false,
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
                var url = '/personas?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function(response) {
                        var respuesta = response.data;
                        me.arrayRegistros = respuesta.personas.data;
                        me.pagination = respuesta.pagination;

                       var getID =  me.arrayRegistros.id;
                      // this.obtenerID(getID);


                    })
                    .catch(function(error) {
                         console.log(me.getID);
                        console.log(error);
                    });
            },
           
            obtenerFacultadCarreraMalla(id) {
                let me = this;//metodo para mostrar los datos de la malla
                var url = '/mallacurricular/obtener-facultad-carrera?id=' + id;
                axios.get(url).then(function(response) {
                    var respuesta = response.data;
                    me.arrayFacultadCarreraMalla = respuesta.carrera;
                    })
                    .catch(function(error) {
                        console.log(error);
                    });

            },
            RegistrarDatos(){
                if (this.validarDatos()) {
                    return;
                }
                let me = this;
                axios.post('/personas/registrar',{     
                    'nombre': this.nombre,
                    'apellidos' : this.apellidos,
                    'cedula': this.cedula,
                    'direccion' : this.direccion,
                    'telefono' : this.telefono,
                    'celular' : this.celular,
                }).then(function (response) {
                     console.log('EXITO!!');    
                     //console.log(this.id);                
                }).catch(function (error) {
                    console.log('error de ingreso!!');
                    console.log(error);
                });


              this.listar(1,'','nombreMascota');
              this.cerrarTemplateRegistro();

              swal({
                    title: 'Registrado!!',
                    type:  'success',
                    text:  'Sus información ha sido agregada',
                })


            },
            handleFileUpload(){
                this.file = this.$refs.file.files[0];
            }, 
            validarDatos() {//Validaciones para el registro de los datos
                this.errorValidacion = 0;
                this.errorMostrarMsj = [];
                if (!this.nombre) this.errorMostrarMsj.push("Ingrese su nombre");
                if (!this.apellidos) this.errorMostrarMsj.push("Ingrese su apellidos");
                if (!this.celular) this.errorMostrarMsj.push("Ingrese su celular");
                if (this.errorMostrarMsj.length) this.errorValidacion = 1;
                return this.errorValidacion;
            },
           
            eliminar(id){
                swal({
                    title: 'Esta seguro que desea eliminar su registro?',
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
                        var url = '/personas/delete/' +id;
                    axios.delete(url).then(function (response) {

                        me.listar(1,'','nombreMascota');
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
            cambiarPagina(page, buscar, criterio) {
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listar(page, buscar, criterio);
            },  
            registrarDatos() {
                let me = this;
                /*  swal({
                    title: 'Descargar Formato!!',
                    type:  'info',
                    text:  'Para ingresar una malla curricular, deberá descargar el formato establecido en el sistema.',
                    //confirmButtonColor: '#24292E',
                })*/

            
                this.template = 0;
                me.pAcademicoInicio = '';
                me.cicloLectivoInicio = 0;               
                me.pAcademicoFin = '';
                me.cicloLectivoFin = 0;
                me.nombreCarrera = '';
                me.file = '';
            },
            registrarMascota() {
                let me = this;
                /*  swal({
                    title: 'Descargar Formato!!',
                    type:  'info',
                    text:  'Para ingresar una malla curricular, deberá descargar el formato establecido en el sistema.',
                    //confirmButtonColor: '#24292E',
                })*/

            
                this.template = 3;
                me.pAcademicoInicio = '';
                me.cicloLectivoInicio = 0;               
                me.pAcademicoFin = '';
                me.cicloLectivoFin = 0;
                me.nombreCarrera = '';
                me.file = '';
            },

            cerrarTemplateRegistro() {
                let me = this;
                this.template = 1;
                me.pAcademicoInicio = '';
                me.cicloLectivoInicio = 0;               
                me.pAcademicoFin = '';
                me.cicloLectivoFin = 0;
                me.nombreCarrera  = '';
                me.file = '';

            },
            cerrarTemplateMascota() {
                let me = this;
                this.template = 1;
                me.pAcademicoInicio = '';
                me.cicloLectivoInicio = 0;               
                me.pAcademicoFin = '';
                me.cicloLectivoFin = 0;
                me.nombreCarrera  = '';
                me.file = '';

            },
            obtenerRegistro(id) { //Metodo ok
                let me = this;

                this.obtenerFacultadCarreraMalla(id);

                me.template = 2;

                //Obtener la cabecera de la malla curricular
                var arrayCabeceraMalla=[];
                var url= '/mallamaterias/obtenerCabeceraMalla?id=' + id;
                
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    arrayCabeceraMalla = respuesta.cabecera_mallla;

                    me.carrera = arrayCabeceraMalla[0]['carrera'];
                    me.pAcademicoInicio=arrayCabeceraMalla[0]['pAcademicoInicio'];
                    me.cicloLectivoInicio=arrayCabeceraMalla[0]['cicloLectivoInicio'];
                    me.pAcademicoFin=arrayCabeceraMalla[0]['pAcademicoFin'];
                    me.cicloLectivoFin=arrayCabeceraMalla[0]['cicloLectivoFin'];
                    
                })
                .catch(function (error) {
                    console.log(error);
                });

                //Obtener las materias de ka malla segun el id
                var urld= '/mallamaterias/obtenerMalla?id=' + id;
                
                axios.get(urld).then(function (response) {
                    console.log(response);
                    var respuesta= response.data;
                    me.arrayMallaMaterias = respuesta.malla_materias;
                })
                .catch(function (error) {
                    console.log(error);
                });  
            }, 
            onClick() {
                axios({
                        url: 'formatoExcel/FormatoMallaCurricular.xlsx',
                        //method: 'GET',
                        responseType: 'blob',
                    }).then((response) => {
                        var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                        var fileLink = document.createElement('a');

                        fileLink.href = fileURL;
                        fileLink.setAttribute('download', 'FormatoMallaCurricular.xlsx');
                        document.body.appendChild(fileLink);

                        fileLink.click();
                    });
            }, 
            obtenerPDF(id){
                window.open('http://localhost:8000/mallamaterias/pdf/'+ id + ',' + '_blank');//_blank para que se muestre en una nueva pestaña
            },
            obtenerID(id) { //Metodo ok
                let me = this;
               
               
                //me.template = 1;

                //Obtener la cabecera de la malla curricular
                
                var url= '/personas/get_id?id=' + 1;
                
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayID = respuesta.obtenerID;
                    //desactivar boton
                })
                .catch(function (error) {
                    console.log(error);
                });


            }, 

        },
        mounted() {
            this.listar(1, this.buscar, this.criterio);
        }
    }
</script>
<style>
    .modal-content {
        width: 100% !important;
        position: absolute !important;
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

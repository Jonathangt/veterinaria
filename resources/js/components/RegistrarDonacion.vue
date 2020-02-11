<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol></ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="icon-chart"></i> Registro de donaciones del sistema
                </div>
                <!-- --------------------------------------------------------------------------------->
                <!--  PRINCIPAL-->
                <template v-if="template==1">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-11">
                                <div class="input-group"><!--Criterios de busqueda -->
                                    <select class="form-control col-md-2" v-model="criterio">
                                        <option value="motivo">Motivo</option> 
                                    </select>

                                    <input type="text" v-model="buscar" @keyup.enter="listar(1,buscar,criterio)" class="form-control col-md-4" placeholder="Busqueda">
                                    
                                    <button type="submit" @click="listar(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                   
                                    <div class="btn-group col-md-2">
                                        <button id='terms' type="button" @click="templateRegistrar()" class="btn btn-secondary">
                                            <i class="icon-plus"></i>&nbsp;Registrar Donación
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
                                        <th>Usuario</th>
                                        <th>Email</th>
                                        <th>Motivo</th>
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
                                             <template v-if="registro.estado">
                                                <button type="button" class="btn btn-danger btn-sm" @click="desactivar(registro.id)">
                                                    <i class="icon-trash"></i>
                                                </button>
                                            </template>
                                            <template v-else>
                                                <button type="button" class="btn btn-info btn-sm" @click="activar(registro.id)">
                                                    <i class="icon-check"></i>
                                                </button>
                                            </template>
                                        </td>
                                       <!-- <td v-text="persona.nombres + ' ' + persona.apellidos"></td>-->
                                        <td v-text="registro.name"></td>
                                        <td v-text="registro.email"></td>
                                        <td v-text="registro.motivo"></td>
                                        <td>
                                            <div v-if="registro.estado">
                                                <td class="badge badge-success centerTabla">Activa</td>
                                            </div>
                                            <div v-else>
                                                <td class="badge badge-danger centerTabla">Inactiva</td>
                                            </div>
                                        </td>
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
                    <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-8">
                                <div class="form-group"><br>
                                    <Label>Recaudacion(*)</Label>
                                    <input type="text" class="form-control" v-model="recaudacion" placeholder="Recaudacion" maxlength="200"> 
                                </div>

                                <div class="form-group">
                                    <Label>Lugar de recaudo(*)</Label>
                                    <input type="text" class="form-control" v-model="lugar" placeholder="Lugar" maxlength="200"> 
                                </div>
                            </div>

                             <div class="col-md-2">
                                <div class="form-group">
                                   <div> <br>
                                        <img src="img/About.jpg" alt="Dobaltoff" id="imagen">
                                    </div>
                                </div>
                            </div>
                           

                            <div class="col-md-8">
                                <div class="form-group">
                                    <Label>Motivo(*)</Label>
                                    <textarea rows="4" class="form-control"  v-model="motivo" placeholder="Para que se esta recaudando" cols="50" > </textarea> 
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <Label></Label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <Label>Fecha de Inicio(*)</Label>
                                 <!--    <input type="date" class="form-control" v-model="fechaInicio"> -->
                                 <datepicker id="select" placeholder= "Fecha de inico" v-model="fechaInicio" :language="es"></datepicker>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <Label>Fecha de Fin(*)</Label>
                               <!--     <input type="date" class="form-control" v-model="fechaFin"> -->
                                    
                                    <datepicker id="select" placeholder= "Fecha de finalización" v-model="fechaFin" :language="es"></datepicker>
                                </div>
                            </div>
                        </div>
                    </div> <!--fin card body-->

                    <div class="text-center">
                         <Label><b class="labelContacto"> Contacto del Responsable</b></Label>
                    </div>

                     <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-4">
                                <div class="form-group"><br>
                                   <Label>Teléfono(*)</Label>
                                        <input type="text" class="form-control" v-model="telefono" placeholder="Teléfono" maxlength="10"> 
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group"><br>
                                    <Label>Dirección (*)</Label>
                                    <input type="text" class="form-control" v-model="direccion" placeholder="Dirección" maxlength="100"> 
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group"><br>
                                    <Label>Email (*)</Label>
                                    <input type="text" class="form-control" v-model="email" placeholder="Dirección" maxlength="50"> 
                                </div>
                            </div>
                        </div> <!--fin row borde-->
            
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
                                <button type="submit" class="btn btn-primary" @click="registrar()">Registrar Donación</button>
                            </div>
                        </div>
                    </div><!--fin 2do card body-->
                </template>
                <!-- Fin Registro de datos-->

                 <!-- --------------------------------------------------------------------------------->
                <!-- Edicion de datos-->
                <template v-else-if="template==3">
                     <div class="text-center"><br>
                         <Label><b class="labelContacto"> Información a editar</b></Label>
                    </div>
                    <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-8">
                                <div class="form-group"><br>
                                    <Label>Recaudacion(*)</Label>
                                    <input type="text" class="form-control" v-model="recaudacion" placeholder="Recaudacion" maxlength="200"> 
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <Label>Lugar de recaudo(*)</Label>
                                    <input type="text" class="form-control" v-model="lugar" placeholder="Lugar" maxlength="200"> 
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <Label>Motivo</Label>
                                     <textarea rows="4" class="form-control"  v-model="motivo" placeholder="Para que se esta recaudando" cols="50" > </textarea> 
                                </div>
                            </div>
                        </div>
                    </div> <!--fin card body-->

                    <div class="text-center">
                         <Label><b class="labelContacto"> Contacto del Responsable</b></Label>
                    </div>

                     <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-4">
                                <div class="form-group"><br>
                                   <Label>Teléfono(*)</Label>
                                        <input type="text" class="form-control" v-model="telefono" placeholder="Teléfono" maxlength="10"> 
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group"><br>
                                    <Label>Dirección</Label>
                                    <input type="text" class="form-control" v-model="direccion" placeholder="Dirección" maxlength="200"> 
                                </div>
                            </div>
                        </div> <!--fin row borde-->
            
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
                                <button type="submit" class="btn btn-primary" @click="actualizar()">Actualiar Donación</button>
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
                                <center><h5>VETERINARIA DOBALTOFF</h5></center>
                                <label for=""></label>
                                <center><h6>Detalle de la Donación</h6></center>
                            </div>


                        </div>
                        <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>                                           
                                            <th>Usuario</th>
                                            <th>Email</th>
                                            <th>Recaudacion</th>
                                            <th>Lugar</th>
                                            <th>Motivo</th>
                                            <th>Teléfono</th>
                                            <th>Dirección</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="mostrarDatos in arrayMostrarDatos" :key="mostrarDatos.id">   
                                        <td v-text="mostrarDatos.name"></td>
                                        <td v-text="mostrarDatos.email"></td>                                           
                                        <td v-text="mostrarDatos.recaudacion"></td>
                                        <td v-text="mostrarDatos.lugar"></td>
                                        <td v-text="mostrarDatos.motivo"></td>
                                        <td v-text="mostrarDatos.telefono"></td>
                                        <td v-text="mostrarDatos.direccion"></td>
                                        <td>
                                            <div v-if="mostrarDatos.estado">
                                                <td class="badge badge-success centerTabla">Activa</td>
                                            </div>
                                            <div v-else>
                                                <td class="badge badge-danger centerTabla">Inactiva</td>
                                            </div>
                                        </td>                     
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
                es: es,
                date: new Date(2016, 9, 16),
                name: '',
                email: '',
                motivo: '',
                recaudacion: '',
                lugar: '',
                telefono: '',
                direccion: '',
                fechaInicio: '',
                fechaFin: '',
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
        components: {
            Datepicker
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
                var url = '/donacion?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function(response) {
                        var respuesta = response.data;
                        me.arrayRegistros = respuesta.donacion.data;
                        me.pagination = respuesta.pagination;

                    })
                    .catch(function(error) {
                         console.log(me.getID);
                        console.log(error);
                    });
            },
            /*desactivar(id){
                swal({
                    title: 'Esta seguro de desactivar la donación?',
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

                        axios.put('/donacion/desactivar',{
                            'id': id
                        }).then(function (response) {
                            me.listar(1,'','name');
                            swal(
                            'Desactivado!',
                            'El registro ha sido desactivado con éxito.',
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
            },*/
            /*activar(id){
                swal({
                    title: 'Esta seguro de activar esta donación?',
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

                        axios.put('/donacion/activar',{
                            'id': id
                        }).then(function (response) {
                            me.listar(1,'','name');
                            swal(
                            'Activado!',
                            'El registro ha sido activado con éxito.',
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
            },*/
            registrar(){
               /* if (this.validarDatos()) {
                    return;
                }*/
                let me = this;
                this.customFormatter(this.fechaInicio);
                 this.customFormatter(this.fechaFin);
                axios.post('/donacion/registrar',{     
                    'recaudacion': this.recaudacion,
                    'lugar' : this.lugar,
                    'motivo': this.motivo,
                    'telefono' : this.telefono,
                    'email' : this.direccion,
                    'direccion' : this.direccion,
                    'fechaInicio' : this.fechaInicio,
                    'fechaFin' : this.fechaFin,

                }).then(function (response) {
                     console.log('EXITO!!');    
                }).catch(function (error) {
                    console.log('error de ingreso!!');
                    console.log(error);
                });
              this.listar(1,'','motivo');
              this.cerrarTemplateRegistro();

              swal({
                    title: 'Donación Registrada!!',
                    type:  'success',
                    text:  'La información a sido publicada',
                })
            },
            customFormatter(date) {
                return moment(date).format('MMMM Do YYYY');
            },
            editar(id) {
                this.templateEditar();
                this.template=3; //abro el template para editar
                let me = this;//metodo para mostrar los datos de la malla
                var url = '/donacion/obtener?id=' + id;
                var arrayEditarDatos=[];
                axios.get(url).then(function(response) {
                    var respuesta= response.data;
                    arrayEditarDatos = respuesta.donacion;
                    me.idDonacion = arrayEditarDatos[0]['id'];
                    me.recaudacion = arrayEditarDatos[0]['recaudacion'];
                    me.lugar=arrayEditarDatos[0]['lugar'];
                    me.motivo=arrayEditarDatos[0]['motivo'];
                    me.telefono=arrayEditarDatos[0]['telefono'];
                    me.direccion=arrayEditarDatos[0]['direccion'];

                }).catch(function(error) {
                    console.log(error);
                });

            },
            actualizar(){
                 if (this.validarDatos()){
                    return;
                }
                
                let me = this;

                axios.put('/donacion/actualizar',{
                    'recaudacion': this.recaudacion,
                    'lugar': this.lugar,
                    'motivo': this.motivo,
                    'telefono': this.telefono,
                    'direccion': this.direccion,
                    'id': this.idDonacion
                }).then(function (response) {
                    me.cerrarModal();
                    me.listar(1,'','name');
                }).catch(function (error) {
                   
                    console.log(error);
                }); 

                this.listar(1,'','motivo');
                this.cerrarTemplateRegistro();

                swal({
                        title: 'Donación Editada!!',
                        type:  'success',
                        text:  'La información a sido actualizada',
                    })

            },         
            validarDatos() {//Validaciones para el registro de los datos
                this.errorValidacion = 0;
                this.errorMostrarMsj = [];
                if (!this.recaudacion) this.errorMostrarMsj.push("El campo recaudacion no puede estar vacio");
                if (!this.lugar) this.errorMostrarMsj.push("El campo lugar no puede estar vacio");
                if (!this.motivo) this.errorMostrarMsj.push("El campo motivo no puede estar vacio");
                if (!this.fechaInicio) this.errorMostrarMsj.push("Debe de elegir una fecha de inicio");
                if (!this.fechaFin) this.errorMostrarMsj.push("Debe de elegir una fecha de finalización");
                if (!this.telefono) this.errorMostrarMsj.push("El campo telefono no puede estar vacio");
                if (!this.direccion) this.errorMostrarMsj.push("El campo dirección no puede estar vacio");
                if (!this.email) this.errorMostrarMsj.push("El campo telefono no puede estar vacio");

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
                me.recaudacion = '';
                me.lugar = '';              
                me.motivo = '';
                me.telefono = '';
                me.direccion = '';

            },
            templateRegistrar() {
        
                this.template = 1;
                let me = this;
           
                this.template = 0;
                me.recaudacion = '';
                me.lugar = '';              
                me.motivo = '';
                me.telefono = '';
                me.direccion = '';
            },
            templateEditar() {
                let me = this;
           
                this.template = 3;
                me.recaudacion = '';
                me.lugar = '';              
                me.motivo = '';
                me.telefono = '';
                me.direccion = '';
            },
            obtenerRegistro(id) {
                let me = this;//metodo para mostrar los datos
                this.template = 2;

                var url = '/donacion/obtener?id=' + id;
                axios.get(url).then(function(response) {
                    var respuesta = response.data;
                    me.arrayMostrarDatos = respuesta.donacion;
                    })
                    .catch(function(error) {
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

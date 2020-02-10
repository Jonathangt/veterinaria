<template>
    <main class="main">
        <ol></ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="icon-user-follow"></i> Usuarios    <!---fa fa-align-justify ** icono-->                  
                    </div>
                    <div class="card-body">
                          <div class="form-group row">
                    <div class="col-md-9">
                            <div class="input-group"><!--Criterios de busqueda-->
                                <select class="form-control col-md-2" v-model="criterio" style="font-size: 12px">
                                    <option value="name">Usuario</option>
                                    <option value="email">Email</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listar(1,buscar,criterio)" class="form-control col-md-4" placeholder="Nombre a buscar">
                                <button type="submit" @click="listar(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                <div class="btn-group col-md-3">
                                    <button type="button" @click="abrirModal('usuario','registrar')" class="btn btn-secondary"><i class="icon-plus"></i>&nbsp;Nuevo</button>
                                </div>
                           </div>                         
                    </div>
                </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Acciones</th>
                                    <th>Usuario</th>
                                    <th>Email</th>
                                    <th>Estado</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="usuario in arrayUsuario" :key="usuario.id">
                                    <td style="width:125px"> 
                                        <span v-if="usuario.rol">
                                                <button type="button" @click="abrirModal('usuario','actualizar',usuario)" class="btn btn-warning btn-sm">
                                                <i class="icon-pencil"></i>
                                                </button>&nbsp;
                                        </span>
                                        <span v-else> </span>

                                   <!--     <span v-if="usuario.estado">
                                                <button type="button" class="btn btn-danger btn-sm" @click="desactivar(usuario.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </span>
                                        <span v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activar(usuario.id)">
                                            <i class="icon-check"></i>
                                            </button>
                                        </span>-->

                                        <button type="button" class="btn btn-danger btn-sm" @click="eliminar(usuario.id)">
                                                <i class="icon-trash"></i>
                                            </button>  


                                    </td>
                                    <td v-text="usuario.name"></td>
                                    <td v-text="usuario.email"></td>
                                    <td>
                                        <div v-if="usuario.estado">
                                            <td class="badge badge-success">Activo</td>
                                        </div>
                                        <div v-else>
                                            <td class="badge badge-danger">Inactivo</td>
                                        </div>
                                    </td>                                
                                </tr>                                
                            </tbody>
                        </table>
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
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal" style="font-size: 15px"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Usuario (*)</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="name" class="form-control" placeholder="Nombre" maxlength="15">                                         
                                    </div>
                                </div>                          
                          
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Email (*)</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="email" class="form-control" placeholder="Email" maxlength="40"> 
                                    </div>
                                </div>     
                                
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Password (*)</label>
                                    <div class="col-md-9">
                                        <input type="password" v-model="password" class="form-control" placeholder="Password de acceso">
                                    </div>
                                </div>

                                <div v-show="errorValidacion" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsj" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <span >Los campos con (*) son obligatorios</span>
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrar()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizar()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
        </main>
</template>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    export default {
        data (){
            return {
                idUser: 0,
                name : '',  
                email : '',             
                password : '', 
                arrayUsuario : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorValidacion : 0,
                errorMostrarMsj : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'name',
                buscar : ''
            }

        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             

            }
        },
        methods : {
            listar (page,buscar,criterio){
                let me=this;
                var url= '/users?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayUsuario = respuesta.usuario.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listar(page,buscar,criterio);
            },
            registrar(){
                if (this.validar()){
                    return;
                }
                
                let me = this;

                axios.post('/users/registrar',{
                    'name': this.name,
                    'email' : this.email,
                    'password' : this.password,

                }).then(function (response) {
                    me.cerrarModal();
                    me.listar(1,'','name');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizar(){
               if (this.validar()){
                    return;
                }
                
                let me = this;

                axios.put('/users/actualizar',{
                    'name': this.name,
                    'email' : this.email,
                    'password' : this.password,
                    'id': this.idUser,
                }).then(function (response) {
                    me.cerrarModal();
                    me.listar(1,'','name');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },            
            validar(){
                this.errorValidacion=0;
                this.errorMostrarMsj =[];

                if (!this.name) this.errorMostrarMsj.push("El nombre de uusuario no puede estar vacío");
                if (!this.email) this.errorMostrarMsj.push("El email no puede estar vacío");
                if (!this.password) this.errorMostrarMsj.push("El password no puede estar vacío");
                if (this.errorMostrarMsj.length) this.errorValidacion = 1;


                return this.errorValidacion;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.name='';
                this.email='';
                this.password='';
                this.errorValidacion=0;

            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "usuario":{
                        switch(accion){
                            case 'registrar':{
                                this.modal = 1;
                                this.tituloModal = 'Registrar Usuario';
                                this.name= '';
                                this.email='';
                                this.password='';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':{
                                this.modal=1;
                                this.tituloModal='Actualizar Usuario';
                                this.tipoAccion=2;
                                this.idUser=data['id'];//obtengo el id de la tabla uusario
                                this.name = data['name'];
                                this.email = data['email'];
                                this.password = data['password'];
                                break;
                            }
                        }
                    }
                }
            },
            eliminar(id){
                swal({
                    title: 'Esta seguro que desea eliminar este usuario?',
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
                        var url = '/users/delete/' +id;
                    axios.delete(url).then(function (response) {

                        me.listar(1,'','name');
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
            this.listar(1,this.buscar,this.criterio);
        }
    }
</script>
<style>    
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>
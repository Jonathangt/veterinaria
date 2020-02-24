<template>
    <main class="main">
        <ol></ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="icon-people"></i> Información de su usuario    <!---fa fa-align-justify ** icono-->                  
                    </div>

                    <div class="card-body">
                          <div class="form-group row">
                    <div class="col-md-9">
                                              
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
                                        <span>
                                              <button type="button" @click="abrirModal('usuario','actualizar',usuario)" class="btn btn-warning btn-sm">
                                                <i class="icon-pencil"></i>
                                                </button>&nbsp;
                                        </span>
                                       <span v-if="usuario.estado">
                                                <button type="button" class="btn btn-secondary btn-sm" @click="desactivar(usuario.id)">
                                                <i class="icon-info"></i>
                                            </button>
                                        </span>
                                        <span v-else>
                                            <button type="button" class="btn btn-success btn-sm" @click="activar(usuario.id)">
                                            <i class="icon-check"></i>
                                            </button>
                                        </span>
                                    </td>
                                    <td v-text="usuario.name"></td>
                                    <td v-text="usuario.email"></td>
                                    <td>
                                        <div v-if="usuario.estado">
                                            <td class="badge badge-success">Cuenta Activa</td>
                                        </div>
                                        <div v-else>
                                            <td class="badge badge-danger">Cuenta Desactivada</td>
                                        </div>
                                    </td>                                
                                </tr>                                
                            </tbody>
                        </table>
                       
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
                                        <input type="text" v-model="name" class="form-control" placeholder="Usuario" maxlength="15">                                         
                                    </div>
                                </div>                          
                          
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Email (*)</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="email" class="form-control" placeholder="Email" maxlength="30"> 
                                    </div>
                                </div>     
                                
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Password (*)</label>
                                    <div class="col-md-9">
                                        <input type="password" v-model="password" class="form-control" placeholder="Password" maxlength="20"> 
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
                            <button type="button" class="btn btn-primary" @click="cerrarModal()">Cerrar</button>
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
            }
        },
        
        methods : {
            listar (){
                let me=this;
                var url= '/indexUsuario';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayUsuario = respuesta.usuario.data;
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
            actualizar(){
               if (this.validar()){
                    return;
                }

                axios.put('/users/actualizarUsuario',{
                    name: this.name,
                    email : this.email,
                    password : this.password,
                    id: this.idUser,
                }).then(response => {
                    this.cerrarModal();
                    this.listar(1,'','name'); 
                    swal({
                        title: 'Usuario Actualizado!!',
                        type:  'success',
                        text:  'La información a sido guardada',
                    })

               }).catch(error => {
                    const { status, errors } = error.response
			        this.errorValidacion = 0
                    const response = error.response
                     if (status === 500) {
                        console.log(response.data)
                    }else if (status === 422) {
                        this.errorValidacion = 1
                        //this.errorMostrarMsj = errors.email.slice(0)
                        this.errorMostrarMsj.push(response.data.errors.email);
                        console.clear()
                    } else {
                        console.log(error)
                    }
                });

            },            
            validar(){
                this.errorValidacion=0;
                this.errorMostrarMsj =[];

               if (!this.name) this.errorMostrarMsj.push("Su nombre de usuario es requerido");
                if (!this.email) this.errorMostrarMsj.push("Su email es requerido");
                if (!this.password) this.errorMostrarMsj.push("Su password es requerido");
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
            desactivar(id){
                swal({
                    title: 'Esta seguro de desactivar su usuario?',
                    text:'Al cerrar sessión no podra volver a ingresar a su cuenta',
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

                        axios.put('/users/desactivar',{
                            'id': id
                        }).then( (response) =>{
                            me.listar(1,'','name');
                            swal(
                            'Desactivado!',
                            'Su usuario se ha desactivado con éxito.',
                            'success'
                            )
                        }).catch((error) =>{
                             swal({
                                title: 'No Desactivado!!',
                                type:  'error',
                                text:  'Ha ocurrido un error al desactivar su usuario',
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
                    title: 'Esta seguro de activar su usuario?',
                    //text:'Al cerrar sessión no podra volver a ingresar a su cuenta',
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

                        axios.put('/users/activar',{
                            'id': id
                        }).then( (response) =>{
                            me.listar(1,'','apellidos');
                            swal(
                            'Activado!',
                            'Su usuario  se ha activado con éxito.',
                            'success'
                            )
                        }).catch( (error) =>{
                            swal({
                                title: 'No Activado!!',
                                type:  'error',
                                text:  'Ha ocurrido un error al activar su usuario',
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
            this.listar();
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
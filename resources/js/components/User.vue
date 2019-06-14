<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                Generar Usuario

            </div>
            <div class="card-body">
                <button type="button"  @click="abrirModal('registrar')" class="btn btn-primary btn-sm my-3" data-toggle="modal" data-target="#exampleModalCenter">
                    Generar Usuario
                </button>
                <h3>Usuarios del sistema</h3>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Tipo Empleado</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="user in arrayUsers">
                        <td v-text="user.id"></td>
                        <td v-text="user.name"></td>
                        <td v-text="user.email"></td>
                        <td v-text="user.role.description"></td>

                        <td>
                            <button type="button"  @click="abrirModal('actualizar',user)" class="btn btn-info btn-sm my-3" data-toggle="modal" data-target="#exampleModalCenter">
                                actualizar
                            </button>
                            <button type="button" v-on:click="destroy(user.id)"  class="btn btn-danger btn-sm my-3">
                                eliminar
                            </button>
                        </td>

                    </tr>
                    </tbody>
                </table>

            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1"  role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">{{titleModal}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                           <div class="container">
                               <div v-show="errorUser==1" class="form-group row div-error">
                                   <div class="alert alert-danger">
                                       <div v-for="error in errorMostrarUser" :key="error" v-text="error">


                                       </div>
                                   </div>
                               </div>
                               <div class="row">
                                   <div class="col-md-5">
                                       <div class="form-group">
                                           <label>Nombre</label>
                                           <input class="form-control" v-model="name"/>

                                       </div>

                                   </div>
                                   <div class="col-md-7">
                                       <div class="form-group">
                                           <label>Email</label>
                                           <input class="form-control" v-model="email"/>

                                       </div>

                                   </div>

                               </div>
                               <div class="row">
                                   <div class="col-md-6">
                                       <div class="form-group">
                                           <label>Password</label>
                                           <input type="password" class="form-control" v-model="password"/>

                                       </div>

                                   </div>
                                   <div class="col-md-6">
                                       <div class="form-group">
                                           <label>Rol</label>
                                           <select class="form-control" v-model="role_id">

                                               <option v-for="role in arrayRoles" :key="role.id" :value="role.id" v-text="role.description"></option>
                                           </select>

                                       </div>

                                   </div>

                               </div>

                           </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" v-if="tipoAccion==1" @click="store()">Generar usuario</button>
                        <button type="button" class="btn btn-primary" v-if="tipoAccion==2" @click="update()">Actualizar usuario</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import Swal from 'sweetalert2'
    export default {
       data(){
           return {
               arrayUsers:[],
               arrayRoles:[],
               id:'',
               name:'',
               email:'',
               password:'',
               role_id:0,
               tipoAccion:'',
               titleModal:'',
               errorMostrarUser:[],
               errorUser:0

           }

           },
        methods: {
            listarUsers() {
                let me = this;
                var url = '/user/json';
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    // handle success

                    me.arrayUsers = respuesta.users;





                }).catch(function (error) {
                        // handle error

                        console.log(error);
                    });
            },
            selectRol(){
                var url='/user/selectRole';
                let me=this;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    // handle success

                    me.arrayRoles = respuesta.roles;





                }).catch(function (error) {
                    // handle error

                    console.log(error);
                });
            },
            abrirModal(accion, user) {
                if (accion == 'registrar') {
                    this.modal = 1;
                    this.id = null;
                    this.email = '';
                    this.name='';
                    this.role_id = 1;
                    this.password = '';
                    this.tipoAccion = 1;
                    this.titleModal='Registrar usuario'

                }
                if (accion == 'actualizar') {
                    this.id = user.id;
                    this.name=user.name;
                    this.email=user.email;
                    this.password=user.password;
                    this.role_id=user.role_id;
                    this.tipoAccion = 2;
                    this.titleModal='Actualizar usuario'
                }
               this.selectRol();

            },
            cerrarModal() {

                $(".modal").removeClass("in");
                $(".modal-backdrop").remove();
                $('body').removeClass('modal-open');
                $('body').css('padding-right', '');
                $(".modal").hide();


            },
            store(){
                let me=this;
                var url='user/store';

                if(!this.validarUser()){
                    axios.post(url,
                        {
                            'name':me.name,
                            'email':me.email,
                            'password':me.password,
                            'role_id':me.role_id


                        }).then(function(){
                        Swal.fire(
                            'buen trabajo!',
                            'usuario agregado correctamente!',
                            'success'
                        );
                        me.cerrarModal();
                        me.listarUsers();



                    }).catch(function(error){
                        Swal.fire({
                            title: 'Error!',
                            text: 'hubo un error',
                            type: 'error',
                            confirmButtonText: 'ok'
                        });
                        console.log(error);
                    })
                }


            },

            update(){

                let me=this;
                axios.put('/user/update',
                    {
                        'id':me.id,
                         'name':me.name,
                        'email':me.email,
                        'password':me.password,
                        'role_id':me.role_id,

                    }).then(function(){
                    Swal.fire(
                        'buen trabajo!',
                        'usuario actualizado correctamente!',
                        'success'
                    );
                    me.cerrarModal();
                    me.listarUsers();

                }).catch(function(error){
                    Swal.fire({
                        title: 'Error!',
                        text: 'hubo un error al eliminar el registro',
                        type: 'error',
                        confirmButtonText: 'ok'
                    });
                    console.log(error);
                })

            },
            destroy(id){

                let me=this;
                axios.post('/user/delete',
                    {
                        'id':id,


                    }).then(function(){
                    Swal.fire(
                        'buen trabajo!',
                        'usuario eliminado correctamente!',
                        'success'
                    );
                    me.cerrarModal();
                    me.listarUsers();

                }).catch(function(error){
                    Swal.fire({
                        title: 'Error!',
                        text: 'hubo un error al eliminar el registro',
                        type: 'error',
                        confirmButtonText: 'ok'
                    });
                    console.log(error);
                })
            },
            validarUser(){
                this.errorUser=0;
                this.errorMostrarUser=[];
                //si el nombre esta vacio, agrega el msj de error
                if(this.role_id==0){
                    this.errorMostrarUser.push("Seleccione una categoria");
                }
                if(this.name==''){
                    this.errorMostrarUser.push("El nombre no puede estar vacio");
                }
                if(this.email==''){
                    this.errorMostrarUser.push("El email no puede estar vacio");
                }
                if(this.password==''){
                    this.errorMostrarUser.push("El password no puede estar vacio");
                }
                if(this.errorMostrarUser.length){
                    this.errorUser=1;
                }
                return this.errorUser;
            },
        },
        mounted(){
            this.listarUsers();

        }
       }

</script>

<style scoped>

</style>
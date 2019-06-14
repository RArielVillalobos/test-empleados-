<template>
  <div class="container">
    <div class="card">
      <div class="card-header">
        Reportes

      </div>

      <div class="card-body">
        <button v-if="isAdmin=='false'"  type="button"  @click="abrirModal('registrar')" class="btn btn-primary btn-sm my-3" data-toggle="modal" data-target="#exampleModalCenter">
          Generar reporte
        </button>
        <h3 v-if="isAdmin=='false'">Mis reportes</h3>
        <h3 v-else>Reportes</h3>
        <table class="table table-bordered">
          <thead>
          <tr>
            <th>Fecha</th>
            <th>Descripción</th>
            <th v-if="isAdmin=='true'">Empleado que lo realizo</th>

            <th>Acciones</th>
          </tr>
          </thead>
          <tbody>
            <tr v-for="report in arrayReports">
              <td v-text="report.date"></td>
              <td v-text="report.description"></td>
              <td v-if="isAdmin=='true'" v-text="report.employee.user.name"></td>
              <td>
                <button type="button"  @click="abrirModal('actualizar',report)" class="btn btn-info btn-sm my-3" data-toggle="modal" data-target="#exampleModalCenter">
                actualizar
                 </button>
                <button type="button" v-on:click="destroy(report)"  class="btn btn-danger btn-sm my-3">
                  eliminar
                </button>
              </td>

            </tr>
          </tbody>
        </table>
        <nav>
          <ul class="pagination">
            <li class="page-item" v-if="pagination.curret_page>1">
              <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page-1)">Ant</a>
            </li>
            <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page === isActived ?'active' :'']">
              <a class="page-link" href="#" @click.prevent="cambiarPagina(page)" v-text="page"></a>
            </li>

            <li class="page-item" v-if="pagination.current_page<pagination.last_page">
              <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1)">Sig</a>
            </li>
          </ul>
        </nav>
      </div>
  </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1"  role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="display: none;">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Generar Reporte</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="container">
                <div v-show="errorReport==1" class="form-group row div-error">
                  <div class="alert alert-danger">
                    <div v-for="error in errorMostrarReport" :key="error" v-text="error">


                    </div>
                  </div>
                </div>
                <div class="row">

                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Descripción</label>
                        <textarea class="form-control" v-model="description">


                        </textarea>

                      </div>

                    </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <input type="date" v-model="date" class="form-control">

                    </div>

                  </div>

                </div>

              </div>
          </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" v-if="tipoAccion==1" @click="store()">Generar reporte</button>
            <button type="button" class="btn btn-primary" v-if="tipoAccion==2" @click="update()">Actualizar reporte</button>
          </div>
        </div>
      </div>
    </div>

  </div>


</template>


<script>

  import Swal from 'sweetalert2'
  export default {
      props:[
          'admin'
      ],
      data(){
          return {
            errorReport:0,
            errorMostrarReport:[],
            tipoAccion:'',
            id:'',
            description:'',
            date:'',
            arrayReports:[],
            isAdmin:this.admin,
            pagination:{
                  'total':0,
                  'current_page':0,
                  'per_page':0,
                  'last_page':0,
                  'from':0,
                  'to':0
              },
              offset:3,

             modal:0,
          }
      },
      computed: {
          isActived: function () {
              return this.pagination.current_page;
          },
          pagesNumber: function () {
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
          }
      },
      methods:{
          listarReports(page) {
              let me = this;
              var url='/report/json?page='+page;
              axios.get(url).then(function (response) {
                  var respuesta=response.data;
                  // handle success
                  me.arrayReports = respuesta.reports.data;
                  me.pagination=respuesta.pagination;

              })
                  .catch(function (error) {
                      // handle error

                      console.log(error);
                  });
          },
          cambiarPagina(page){
              let me=this;
              //Actualiza la pagina Actual
              me.pagination.current_page=page;
              //Envia la peticion para visualizar la data de esa pagina
              me.listarReports(page);
          },
          abrirModal(accion,report){
              if(accion=='registrar'){
                  this.modal=1;
                  this.id=null;
                  this.description='';
                  this.date='';
                  this.tipoAccion=1;

              }
              if(accion=='actualizar'){
                  this.id=report.id;
                  this.description=report.description;
                  this.date=report.date;
                  this.tipoAccion=2;
              }
          },
          cerrarModal(){

              $(".modal").removeClass("in");
              $(".modal-backdrop").remove();
              $('body').removeClass('modal-open');
              $('body').css('padding-right', '');
              $(".modal").hide();


          },
          store(){
              let me=this;
              var url='report/store';

              if(!me.validarReport()){
                  axios.post(url,
                      {
                          'description':this.description,
                          'date':this.date,

                      }).then(function(){
                      Swal.fire(
                          'buen trabajo!',
                          'reporte agregado correctamente!',
                          'success'
                      );
                      me.cerrarModal();
                      me.listarReports(1);



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
          validarReport(){
              this.errorReport=0;
              this.errorMostrarReport=[];
              //si el nombre esta vacio, agrega el msj de error

              if(this.description==''){
                  this.errorMostrarReport.push("La descripcion no puede estar vacia");
              }
              if(this.date==''){
                  this.errorMostrarReport.push("La fecha no puede estar vacia");
              }
              if(this.errorMostrarReport.length){
                  this.errorReport=1;
              }

              return this.errorReport;
          },
          update(){
              let me=this;
              axios.put('/report/update',
                  {
                      'id':this.id,
                      'description':this.description,
                      'date':this.date,


                  }).then(function(){
                  Swal.fire(
                      'buen trabajo!',
                      'reporte actualizado correctamente!',
                      'success'
                  );
                  me.cerrarModal();
                  me.listarReports(1);

              }).catch(function(error){
                  Swal.fire({
                      title: 'Error!',
                      text: 'hubo un error al actualizar',
                      type: 'error',
                      confirmButtonText: 'ok'
                  });
                  console.log(error);
              })

          },
          destroy(report){
              let me=this;
              axios.post('/report/destroy',
                  {
                      'id':report.id,



                  }).then(function(){
                  Swal.fire(
                      'buen trabajo!',
                      'reporte eliminado correctamente!',
                      'success'
                  );
                  me.cerrarModal();
                  me.listarReports(1);

              }).catch(function(error){
                  Swal.fire({
                      title: 'Error!',
                      text: 'hubo un error al eliminar el registro',
                      type: 'error',
                      confirmButtonText: 'ok'
                  });
                  console.log(error);
              })

          }

      },
      mounted(){
          this.listarReports(1);


      }
  }
  $('#myModal').modal('show');


</script>


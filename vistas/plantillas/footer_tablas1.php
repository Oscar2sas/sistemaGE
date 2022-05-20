  </div>
  <!--End Row-->
	
  <!--start overlay-->
		  <div class="overlay toggle-menu"></div>
	<!--end overlay-->
		
    </div>
    <!-- End container-fluid-->
    </div>
    <!--End content-wrapper-->
</div>
<!--End wrapper-->

 <!-- Bootstrap core JavaScript-->
  <script src="public/assets/js/jquery.min.js"></script>
  <script src="public/assets/js/popper.min.js"></script>
  <script src="public/assets/js/bootstrap.min.js"></script>
	
 <!-- simplebar js -->
  <script src="public/assets/plugins/simplebar/js/simplebar.js"></script>
  <!-- sidebar-menu js -->
  <script src="public/assets/js/sidebar-menu.js"></script>
  <!-- Custom scripts -->
  <script src="public/assets/js/app-script.js"></script>
  <!-- Chart js -->
  
  <script src="public/assets/plugins/Chart.js/Chart.min.js"></script>
 
  <!-- Index js -->
  <script src="public/assets/js/index.js"></script> 

  <!-- dataTables js -->
  
  <link rel="stylesheet" type="text/css" href="public/DataTables/datatables.min.css"/>
  <script type="text/javascript" src="public/DataTables/datatables.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#tabla_JS').DataTable( {         
          "language": {        
              "decimal": ",",
              "emptyTable":     "No existen datos en la Lista",
              "info":           "Mostrando _START_ a _END_ de _TOTAL_",
              "infoEmpty":      "Mostrando 0 a 0 de 0",
              "infoFiltered":   "(filtrado de _MAX_ totales)",
              "infoPostFix":    "",
              "thousands":      ".",
              "lengthMenu":     "Mostrar _MENU_",
              "loadingRecords": "Cargando...",
              "processing":     "Procesando...",
              "search":         "Buscar:",
              "zeroRecords":    "No se encontraron registros",
              "paginate": {
                  "first":      "Primer",
                  "last":       "Ultimo",
                  "next":       "Siguiente",
                  "previous":   "Anterior"
              },
              "aria": {
                  "sortAscending":  ": Activar para ordenar en forma ascendente",
                  "sortDescending": ": Activar para ordenar en forma descendente",
              }
          }
        } );
    } );
  </script>

</body>
</html>
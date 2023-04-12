
    
<div class="ui hidden divider"></div>
<div class="ui hidden divider"></div>
<div class="ui very relax container m-a-70-m-b-70 ">

  <!-- fILTROS-->
  <?php echo isset($filter) && !empty($filter) ? $filter : "filtro vacio"; ?>
  <!-- MODAL ADD -->
  <?php echo isset($modal_add) && !empty($modal_add) ? $modal_add : ""; ?>
  <!-- MODAL EDIT -->
  <?php echo isset($modal_edit) && !empty($modal_edit) ? $modal_edit : ""; ?>

  <!-- registros-->
  <div id="tbl_customer" class="container" style="height: 5000px; overflow: auto;">
    <!-- Tabla ajax -->
  </div>  


  <!-- fin -->
  <!-- <div class="ui secondary segment"> 
     <div class="ui form">
        <h4 class="ui dividing header"> Registro Clientes </h4> 
          <div class="equal width  fields">
            
            <div class="field">
              <label>Cedula</label>
              <input type="number" id="c_cliente" placeholder="Cedula" required onkeypress="return valideKey(event);" >
            </div>

            <div class="field">
              <label>Primer Nombre</label>
              <input placeholder="Primer Nombre" id="nom_cliente" type="text" required onkeypress="return lettersOnly(event);"> 
            </div>

            <div class="field">
              <label>Segundo Nombre</label>
              <input placeholder="Segundo Nombre" id="nom2_cliente" type="text" onkeypress="return lettersOnly(event);">
            </div>

            <div class="field">
            <label>Primer Apellido</label>
            <input placeholder="Primer Apellido" id="ap_cliente" type="text" required onkeypress="return lettersOnly(event);">
            </div>
            <div class="field">
            <label>Segundo Apellido</label>
            <input placeholder="Segundo Apellido" id="ap2_cliente" type="text" required onkeypress="return lettersOnly(event);">
            </div>
          </div>
          <input class="ui green button" type="submit" id="btn_new_cliente" value="Guardar">
          <a class="ui blue button" href="?opcion=List_Cliente"><i class="search icon"></i><label>Buscar</label></a>
          <input onclick="cancelar();" class="ui  button" type="submit" id="btn_cancelar" value="Cancelar" >

     </div>
   </div> -->

  
  <div class="ui divider"></div>
</div>

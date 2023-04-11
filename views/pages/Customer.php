
    
<div class="ui hidden divider"></div>
<div class="ui hidden divider"></div>
<div class="ui very relax container m-a-70-m-b-70 ">

 <!-- Formulario clientes -->
 <?php if(isset($_GET['edit'])){?>

 <div class="ui secondary segment">  
    <div class="ui form">
          <h4 class="ui dividing header"> Registro Clientes </h4> 
          <input type="hidden" id="id_cliente" value="<?php  print $datoE[0]->id_cliente; ?>">
            <div class="equal width  fields">
          
              <div class="field">
                <label>Cedula</label>
                <input type="number" id="c_cliente" placeholder="Cedula" value="<?php print $datoE[0]->cedula; ?>" onkeypress="return valideKey(event);" >
              </div>

              <div class="field">
                <label>Primer Nombre</label>
                <input placeholder="Primer Nombre" id="nom_cliente" type="text" value="<?php print $datoE[0]->nombre_1; ?>"> 
              </div>

              <div class="field">
                <label>Segundo Nombre</label>
                <input placeholder="Segundo Nombre" id="nom2_cliente" type="text" value="<?php print $datoE[0]->nombre_2; ?>">
              </div>

              <div class="field">
              <label>Primer Apellido</label>
              <input placeholder="Primer Apellido" id="ap_cliente" type="text" value="<?php print $datoE[0]->apellido_1; ?>">
              </div>
              <div class="field">
              <label>Segundo Apellido</label>
              <input placeholder="Segundo Apellido" id="ap2_cliente" type="text" value="<?php print $datoE[0]->apellido_2; ?>">
              </div>
            </div>
            <input class="ui green button" type="submit" id="btn_mod_cliente" value="Modificar">
            <input onclick="cancelar();" class="ui  button" type="submit" id="btn_cancelar" value="Cancelar" >

    </div>
 </div>      

<!-- fin -->

<?php }else{?>
  <div class="ui secondary segment"> 
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
   </div>

<!-- fin formulario -->

 <?php }?>

 <?php  echo isset($frm) && !empty($frm) ? $frm: "tabla vacia"; ?>

<div class="ui divider"></div>

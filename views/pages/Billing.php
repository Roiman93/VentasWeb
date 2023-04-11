  <div class="ui hidden divider"></div>
  <div class="ui hidden divider"></div>

  <!-- Formulario clientes -->
  <div class="ui very relax container m-a-70-m-b-70 ">
      <!-- botones guardar y cancelar -->
      <div class="ui small right floated   icon buttons">
          <button id="btn_save" type="button" class="positive ui  button" data-content="Guardar"
              data-position="top center"><i class="save icon"></i></button>
          <button id="btn_cancel" class="negative ui  button"
              data-content="Cancelar operación" data-position="top center"><i class="cancel icon"></i></button>
      </div>

      <!-- indica el prefijo y numero de factura actual -->
      <h2 class="ui header">
          <i class="file alternate icon"></i>
          <div class="content">Factura Numero:
            <input id="txt_prej" type="hidden" value=" <?php echo isset($prefj->prefijo) && !empty($prefj->prefijo) ? $prefj->prefijo : ""; ?>">
            <input id="txt_prej_num" type="hidden" value="<?php echo isset($prefj->n_actual) && !empty($prefj->n_actual) ? $prefj->n_actual : ""; ?>">
              <div class="sub header">
                  <?php  echo isset($prefj->prefijo) && !empty($prefj->prefijo) ? $prefj->prefijo . "" . $prefj->n_actual : "Configure Resolucion"; ?>
              </div>
          </div>
      </h2>

      <!-- datos de los clientes -->
      <div class="ui secondary segment">
          <div id="cliente_frm" class="ui form">
              <h4 class="ui dividing header"><i class="address card icon"></i>Datos del cliente</h4>
               <input type="hidden" id="idcliente" placeholder="id">
              <div class="equal width  fields">
                  <input type="hidden" id="id_cliente">

                  <div class="field">
                      <label>Cedula</label>
                      <input type="text" data-type="number" id="c_cliente" placeholder="Cedula" required 
                          onkeypress="return valideKey(event);">
                  </div>

                  <div class="field">
                      <label>Primer Nombre</label>
                      <input type="text" data-type="text" placeholder="Primer Nombre" id="nom_cliente" required onkeypress="return lettersOnly(event);">
                  </div>

                  <div class="field">
                      <label>Segundo Nombre</label>
                      <input type="text" data-type="text"  placeholder="Segundo Nombre" id="nom2_cliente" onkeypress="return lettersOnly(event);">
                  </div>

                  <div class="field">
                      <label>Primer Apellido</label>
                      <input type="text" data-type="text"  placeholder="Primer Apellido" id="ap_cliente"  required onkeypress="return lettersOnly(event);">
                  </div>

                  <div class="field">
                      <label>Segundo Apellido</label>
                      <input type="text" data-type="text"  placeholder="Segundo Apellido" id="ap2_cliente" required onkeypress="return lettersOnly(event);">
                  </div>

              </div>
              <input class="ui green button" type="submit" id="btn_new_cliente" value="Nuevo cliente"
                  style="display:none;">
              <input class="ui button" type="submit" id="btn_cancel_cliente" value="Cancelar" style="display:none;">
          </div>

      </div>




      <!-- tabla de facturacion -->
      <section>
          <table class="ui very compact  small  table" id="tbl_venta">
              <thead>
                  <tr class="ui inverted table">
                      <th width="100px">
                          <h5 class=" ui header" style="color:#ffff" scope="col">Codigo</h5>
                      <th>
                          <h5 class=" ui header" style="color:#ffff" scope="col">Descripcion</h5>
                      </th>
                      <th>
                          <h5 class=" ui header" style="color:#ffff" scope="col">Existencia</h5>
                      </th>
                      <th class="">
                          <h5 class=" ui header" style="color:#ffff" scope="col">Cantidad</h5>
                      </th>
                      <th class=" aligned">
                          <h5 class=" ui header" style="color:#ffff" scope="col">Precio</h5>
                      </th>
                      <th class=" aligned">
                          <h5 class=" ui header" style="color:#ffff" scope="col">Precio Total</h5>
                      <th>
                          <h5 class=" ui header" style="color:#ffff" scope="col">Accion</h5>
                      </th>
                  </tr>

                  <!-- busqueda de productos -->
                  <tr>
                      <td>
                          <div class="ui input focus">
                              <input type="text" name="txt_cod_producto" id="txt_cod_producto" placeholder="Buscar..."
                                  disabled>
                          </div>
                      </td>

                      <td style="display:none;" id="id"></td>
                      <td id="txt_descripcion">-</td>
                      <td id="txt_existencia">-</td>

                      <td class="">

                          <div class="ui  input">
                              <input type="text" name="txt_cant_producto" id="txt_cant_producto"
                                  placeholder="Cantidad..." disabled>
                          </div>
                      </td>

                      <input type="hidden" name="" id="txt_id" value="<?php echo $_SESSION["id"]; ?>">
                      <input type="hidden" name="" id="txt_token" value="<?php echo md5(
                          $_SESSION["id"]
                      ); ?>">
                      <input type="hidden" name="" id="txt_usuario" value="<?php isset(
                          $_SESSION["admin"]
                      )
                          ? "1"
                          : "2"; ?>">

                      <td id="txt_precio" class=" aligned">0.00</td>
                      <td id="txt_precio_total" class=" aligned">0.00</td>
                      <td> <a href="#" id="add_product" class="link_add"><i class="plus square icon"></i>Agregar</a>
                      </td>
                  </tr>
                  <!-- fin -->

              </thead>
          </table>
      </section>
      <!-- detalle de factura -->
      <div id="detalle_venta" class="container" style="height: 250px; overflow: auto;">
          <!-- Tabla ajax -->
      </div>

      <!-- Tabla resumen factura -->
      <div class="ui right floated inverted stackable segment">
          <div class="ui inverted relaxed divided list">
              <div class="item">
                  <div class="content">
                      <div class="header">Subtotal: $<span id="txt_subtotal"></span>
                      </div>

                  </div>
              </div>
              <div class="item">
                  <div class="content">
                      <div class="header">Iva: $<span id="txt_iva"></span>
                      </div>

                  </div>
              </div>
              <div class="item">
                  <div class="content">
                      <div class="header">Total: $<spam id="txt_total"></spam>
                      </div>

                  </div>
              </div>
          </div>
      </div>
      <div class="ui hidden divider"></div>
      <div class="ui hidden divider"></div>

  </div>

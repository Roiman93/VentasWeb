  <div class="ui hidden divider"></div>
  <div class="ui hidden divider"></div>
  <div class="ui hidden divider"></div>
  <!-- Formulario clientes -->
  <div class="ui very relax container m-a-70-m-b-70 ">
      <!-- indica el prefico y numerode factura actual -->
      <h2 class="ui header">
          <i class="file alternate icon"></i>
          <div class="content">Factura Numero:
              <div class="sub header">
                  <?php if (empty($prefj[0]->prefijo)) {
                      print "Configure Resolucion";
                  } else {
                      print $prefj[0]->prefijo . "" . $prefj[0]->n_actual;
                  } ?>
              </div>
          </div>
      </h2>

      <div class="ui secondary segment">
          <div class="ui form">
              <h4 class="ui dividing header"><i class="address card icon"></i>Datos del cliente</h4>
              <div class="equal width  fields">

                  <div class="field">
                      <label>Cedula</label>
                      <input type="number" id="c_cliente" placeholder="Cedula" required
                          onkeypress="return valideKey(event);">
                  </div>

                  <div class="field">
                      <label>Primer Nombre</label>
                      <input placeholder="Primer Nombre" id="nom_cliente" type="text" required
                          onkeypress="return lettersOnly(event);">
                  </div>

                  <div class="field">
                      <label>Segundo Nombre</label>
                      <input placeholder="Segundo Nombre" id="nom2_cliente" type="text"
                          onkeypress="return lettersOnly(event);">
                  </div>

                  <div class="field">
                      <label>Primer Apellido</label>
                      <input placeholder="Primer Apellido" id="ap_cliente" type="text" required
                          onkeypress="return lettersOnly(event);">
                  </div>
                  <div class="field">
                      <label>Segundo Apellido</label>
                      <input placeholder="Segundo Apellido" id="ap2_cliente" type="text" required
                          onkeypress="return lettersOnly(event);">
                  </div>
              </div>
              <input class="ui green button" type="submit" id="btn_new_cliente" value="Nuevo cliente"
                  style="display:none;">
              <input class="ui button" type="submit" id="btn_cancel_cliente" value="Cancelar" style="display:none;">
          </div>

          <!-- + -->
          <input type="hidden" id="idcliente" placeholder="id">

      </div>

      <!-- botones flotantes -->
      <div class="ui left floated green tertiary  compact segment">
          <h3 class="ui centered header">Acciones</h3>
          <div class="ui small basic icon buttons">

              <button id="btn_facturar_venta" style="display:none;" class="ui  button ">Guardar <i
                      class="save green icon"></i></button>
              <button id="cancelar" onclick="validarCancelarVenta();" class="ui button">Cancelar <i
                      class="window red close icon"></i></button>

          </div>
      </div>

      <!-- tabla de facturacion -->
      <selection>
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

                      <input type="hidden" name="" id="txt_id" value="<?php echo md5(
                          $_SESSION["id"]
                      ); ?>">
                      <input type="hidden" name="" id="txt_usuario" value="<?php isset(
                          $_SESSION["admin"]
                      )
                          ? "1"
                          : "2"; ?>">

                      <td id="txt_precio" class=" aligned">0.00</td>
                      <td id="txt_precio_total" class=" aligned">0.00</td>
                      <td> <a href="#" id="add_product_venta" class="link_add" style="display:none;"><i
                                  class="plus square icon"></i> Agregar</a></td>
                  </tr>
                  <!-- fin -->

                  <!-- tabla detalle factura -->
                  <tr class="ui inverted table">

                      <th>
                          <h5 class=" ui header" style="color:#ffff" scope="col">Codigo</h5>
                      </th>
                      <th colspan="2">
                          <h5 class=" ui header" style="color:#ffff" scope="col">Descripcion</h5>
                      </th>
                      <th class=" aligned">
                          <h5 class=" ui header" style="color:#ffff" scope="col">Cantidad</h5>
                      </th>
                      <th class=" aligned">
                          <h5 class=" ui header" style="color:#ffff" scope="col">Precio</h5>
                      </th>
                      <th class="aligned">
                          <h5 class=" ui header" style="color:#ffff" scope="col">Precio Total</h5>
                      </th>
                      <th>
                          <h5 class=" ui header" style="color:#ffff" scope="col">Accion</h5>
                      </th>
                  </tr>
                  <!-- fin -->

              </thead>

              <tbody id="detalle_venta">
                  <!-- Tabla ajax -->
              </tbody>
              <!-- fin -->

              <!-- Tabla resumen factura -->
              <tfoot id="detalle_totales">
                  <!-- Tabla ajax -->
              </tfoot>
          </table>
      </selection>
      <!-- fin -->



  </div>

  <script type="text/javascript" src="build/js/Configuracion.js"></script>
  <script type="text/javascript" src="build/js/Funciones_Facturacion.js"></script>
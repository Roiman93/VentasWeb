<div class="ui hidden divider"></div>
<div class="ui hidden divider"></div>
<div class="ui very relax container m-a-70-m-b-70 ">

  <!-- fILTROS-->
  <?php echo isset($filter) && !empty($filter) ? $filter : "filtro vacio"; ?>
  <!-- MODAL ADD -->
  <?php echo isset($modal_add) && !empty($modal_add) ? $modal_add : ""; ?>
  <!-- MODAL EDIT -->
  <?php echo isset($modal_edit) && !empty($modal_edit) ? $modal_edit : ""; ?>
  <!-- tabla -->

  <!--  Registros -->
  <div id="registros" class="container" style="height: 500px; overflow: auto;">
  <!-- Tabla ajax -->
  </div>

  <div class="ui divider"></div>
</div>


<!-- <div class="ui fluid search selection dropdown">
  <input type="hidden" name="gender">
  <i class="dropdown icon"></i>
  <div class="default text">Género</div>
  <div class="menu">
    <div class="item" data-value="1">Masculino</div>
    <div class="item" data-value="2">Femenino</div>
    <div class="item" data-value="3">Otro</div>
  </div>
</div>

<script>
  $('.ui.dropdown').dropdown({
    search: true
  });
</script> -->
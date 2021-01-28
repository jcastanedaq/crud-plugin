<?php

/**
  * Proporcionar una vista de área de administración para el plugin
  *
  * Este archivo se utiliza para marcar los aspectos de administración del plugin.
  *
  * @link http://misitioweb.com
  * @since desde 1.0.0
  *
  * @package Beziercode_blank
  * @subpackage Beziercode_blank/admin/parcials
  */
/* Este archivo debe consistir principalmente en HTML con un poco de PHP. */

?>

<div id="add_cp_table" class="modal">
    <div class="modal-content">
      <form>
        <div class="row">
            <div class="input-field col s6">
                <input id="nombre" type="text" class="validate">
                <label for="nombre">Nombre de la tabla</label>
            </div>
            
        </div>
        <div class="row">
        <div class="input-field col s6">
                <button id="crear-table" class="btn waves-effect waves-light" type="button" name="accion"> Crear <i class="material-icons right">add</i></button>
            </div>
        </div>
      </form>
    </div>
  </div>

<div class="had-container">
    <!-- titulo de la pagina -->
    <div class="row">
        <div class="col s12">
            <h5><?php echo esc_html(get_admin_page_title()); ?></h5>
        </div>
    </div>
<!-- boton crear nueva tabla de datos -->
    <div class="row">
    <div class="col s4">
        <a href="" class="addcptable btn btn-floating pulse"><i class="material-icons">add</i></a>
        <span style="font-size:19px; margin-top:5px;">Crear nueva tabla de datos</span>
    </div>
    </div>

    <!-- Elementos de la tabla -->
    <div class="row">
    <div class="col s4">
    <table class="bordered responsive-table">
        <thead>
          <tr>
              <th>Name</th>
              <th>ShortCode</th>
              <th></th>
              <th></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Mi primera tabla</td>
            <td>[cpdatos id="3"]</td>
            <td>
                <span class="btn btn-floating waves-effect waves-light">    
                    <i class="tiny material-icons">mode_edit</i>
                </span>
            </td>
            <td>
                <span class="btn btn-floating waves-effect waves-light red darken-1">
                    <i class="tiny material-icons">close</i>
                </span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    </div>
    
</div>
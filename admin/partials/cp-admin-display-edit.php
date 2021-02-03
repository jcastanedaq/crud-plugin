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
$id = $_GET['id'];
$sql = $this->db->prepare("SELECT data FROM ".CP_TABLE." WHERE id = %d", $id);
$result = $this->db->get_var($sql);



?>
<div id="addUpdate" class="modal">
    <div class="modal-content">
        <div class="precargador">
            <div class="preloader-wrapper big active">
                <div class="spinner-layer spinner-blue">
                    <div class="circle-clipper left">
                    <div class="circle"></div>
                    </div><div class="gap-patch">
                    <div class="circle"></div>
                    </div><div class="circle-clipper right">
                    <div class="circle"></div>
                    </div>
                </div>

                <div class="spinner-layer spinner-red">
                    <div class="circle-clipper left">
                    <div class="circle"></div>
                    </div><div class="gap-patch">
                    <div class="circle"></div>
                    </div><div class="circle-clipper right">
                    <div class="circle"></div>
                    </div>
                </div>

                <div class="spinner-layer spinner-yellow">
                    <div class="circle-clipper left">
                    <div class="circle"></div>
                    </div><div class="gap-patch">
                    <div class="circle"></div>
                    </div><div class="circle-clipper right">
                    <div class="circle"></div>
                    </div>
                </div>

                <div class="spinner-layer spinner-green">
                    <div class="circle-clipper left">
                    <div class="circle"></div>
                    </div><div class="gap-patch">
                    <div class="circle"></div>
                    </div><div class="circle-clipper right">
                    <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>
        <h4></h4>
        <form method="post" class="col s12 formuData">
        <div class="row">
            <input id="idTable" type="hidden" name="idTable" value="<?php echo $id; ?>">
            <div class="input-field col s4">
                <input id="nombres" type="text" class="validate">
                <label for="nombres">Nombres</label>
            </div>
            <div class="input-field col s4">
                <input id="apellidos" type="text" class="validate">
                <label for="apellidos">Apellidos</label>
            </div>
            <div class="input-field col s4">
                <input id="email" type="text" class="validate">
                <label for="email">Email</label>
            </div>
            
        </div>
        <div class="row">
            <div class="file-field input-field col s10">
                <div class="btn" id="selectimg">
                    <span>Seleccionar imagen<i class="material-icons right">file_upload</i></span>
                    <input type="file">
                </div>
                <div class="file-path-wrapper">
                    <input id="selectimgval" class="file-path validate" type="text">
                </div>
            </div>
            <div class="col s2">
                <div class="marcoimg">
                    <img src="" alt="">
                </div>
            </div>
        </div>
        <div class="row">
        <div class="input-field col s6">
                <button id="agregar" class="btn waves-effect waves-light" type="button" name="accion"> Agregar <i class="material-icons right">add</i></button>
                <button data-id="" id="actualizar" class="btn waves-effect waves-light" type="button" name="accion"> Actualizar <i class="material-icons right">cached</i></button>
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
    <a class="btn btn-floating blue waves-effect wave-light blue" href="?page=cp_data"><i class="material-icons">arrow_back</i></a>
    <div class="col s4">
        <a href="" class="addItem btn btn-floating pulse"><i class="material-icons">add</i></a>
        <span style="font-size:19px; margin-top:5px;">Agregar usuario</span>
    </div>
    </div>

    <!-- Elementos de la tabla -->
    <div class="row">
    <div class="col s4">
    <table class="bordered responsive-table">
        <thead>
          <tr>
              <th></th>
              <th>Nombres</th>
              <th>Apellidos</th>
              <th>Email</th>
              <th></th>
              <th></th>
          </tr>
        </thead>
        <tbody>
            
            <?php
                echo $this->crud_json->read_items($result);
            ?>
          
        </tbody>
      </table>
    </div>
    </div>
    
</div>
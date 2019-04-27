<?php

$taxonomy     = 'product_cat';
$orderby      = 'name';
$show_count   = 0;      // 1 for yes, 0 for no
$pad_counts   = 0;      // 1 for yes, 0 for no
$hierarchical = 1;      // 1 for yes, 0 for no
$title        = '';
$empty        = 0;

$args = array(
  'taxonomy'     => $taxonomy,
  'orderby'      => $orderby,
  'show_count'   => $show_count,
  'pad_counts'   => $pad_counts,
  'hierarchical' => $hierarchical,
  'title_li'     => $title,
  'hide_empty'   => $empty
);

$categories = get_categories( $args );
$category_names = [];

foreach ($categories as $cat) {
  if($cat->category_parent == 0) {
    $category_id = $cat->term_id;
    $category_names[] = $cat->name;
  }
}

?>

<div class="wppb-carta">
  <div class="wppb-carta-header">
    <h2>Registrar barra de progreso</h2>
  </div>
  <div class="wppb-carta-body">
    <form id="wppb-create-form" method="POST" action="">
      <div class="wppb-create-form-wrap">
        <div class="form-group">
          <label for="name">Nombre</label>
          <input type="text" name="name" id="name">
        </div>

        <div class="form-group">
          <label for="category">Categoría</label>
          <select name="category" id="category">
            <?php
              foreach( $category_names as $cat ){
                echo '<option value="' . $cat . '">' . $cat . '</option>';
              }
            ?>
          </select>
        </div>

        <div class="form-group">
          <label for="color">Color</label>
          <input type="color" name="color" id="color">
        </div>

        <div class="form-group">
          <label for="goal">Objetivo</label>
          <input type="number" name="goal" id="goal">
        </div>

        <div class="form-group">
          <button type="number" id="guardarBarra" style="margin-top: 20px;">Guardar</button>
        </div>

        <div class="locked-overlay">
          <div class="spinner"></div>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Edit progress bars form -->
<div class="wppb-carta edit-progress-bar-form">
  <div class="wppb-carta-header">
    <h2 style="display: inline-block;">Actualizar barra de progreso</h2>
    <span id="edit-progress-bar-id"></span>
  </div>
  <div class="wppb-carta-body">
    <form id="wppb-update-form" method="POST" action="">
      <div class="wppb-create-form-wrap">

        <div class="form-group">
          <label for="name">Nombre</label>
          <input type="text" name="name" id="edit_name">
        </div>

        <div class="form-group">
          <label for="category">Categoría</label>
          <select name="category" id="edit_category">
            <?php
              foreach( $category_names as $cat ){
                echo '<option value="' . $cat . '">' . $cat . '</option>';
              }
            ?>
          </select>
        </div>

        <div class="form-group">
          <label for="color">Color</label>
          <input type="color" name="color" id="edit_color">
        </div>

        <div class="form-group">
          <label for="goal">Objetivo</label>
          <input type="number" name="goal" id="edit_goal">
        </div>

        <div class="form-group">
          <button type="number" id="actualizarBarra" style="margin-top: 20px;">Actualizar</button>
        </div>

        <input type="hidden" name="id" id="edit_id" readonly>

        <div class="locked-overlay">
          <div class="spinner"></div>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="wppb-carta">
  <div class="wppb-carta-header">
    <h2>Todas las barras de progreso</h2>
  </div>
  <div class="wppb-carta-body">
    <table id="wppb-admin-table" class="wppb-admin-table">
      <thead>
        <th>Nombre</th>
        <th>Categoría</th>
        <th>Objetivo</th>
        <th>Color</th>
        <th>Código</th>
        <th>Opcs</th>
      </thead>
      <tbody>

      </tbody>
    </table>
  </div>
</div>

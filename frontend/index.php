<?php
// index.php - vista principal del cliente
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>CRUD Pacientes</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="<?php echo $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']; ?>/assets/style.css?v=<?php echo time(); ?>">
</head>
<body>
  <div class="container" role="main">
    <div class="header">
      <div class="brand">

        <div>
          <div class="title">Gestor Interno de Pacientes</div>
        </div>
        

      </div>

    </div>

    <div class="center">
      <div class="grid" style="width:50%">
        <a class="card-action" href="create.php">
          <h3>➕ Registrar Paciente</h3>
          <p>Agregar un nuevo paciente</p>
        </a>
      </div>
      <div class="grid" style="width:50%">
        <a class="card-action" href="list.php">
          <h3>📋 Ver Pacientes</h3>
          <p>Listado de pacientes — editar, eliminar los - registros</p>
        </a>
      </div>
    
    <div class="footer">
      <div>JESUS CLAVIJO PROGRAMA CRUD DERECHOS DE AUTOR</div>
      <div><small>RECONTRA XD</small></div>
    </div>
  </div>
</body>
</html>

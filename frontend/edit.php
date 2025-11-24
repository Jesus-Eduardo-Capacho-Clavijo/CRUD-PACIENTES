<?php
// edit.php - formulario de edición que precarga datos del SOAP
declare(strict_types=1);
require_once __DIR__ . '/../backend/soap_client.php';

$wsdl = 'http://localhost/pacientes_soap/backend/pacientes.wsdl';
$client = new PacientesSoapClient($wsdl);

// ID recibido por GET
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header("Location: list.php?error=invalid_id");
    exit;
}

$patient = null;
$error = null;

try {
    $res = $client->getPatient($id);

    // Normalizar respuesta: puede venir como stdClass o array
    if (is_object($res) || is_array($res)) {
        $arr = json_decode(json_encode($res), true);
        if (isset($arr['return'])) {
            $patient = (array)$arr['return'];
        } else {
            $patient = $arr;
        }
    }

} catch (Throwable $e) {
    $error = $e->getMessage();
}

if (!$patient || empty($patient['id'])) {
    header("Location: list.php?error=notfound");
    exit;
}

function esc($v) {
    return htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8');
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Editar Paciente #<?= esc($patient['id']) ?></title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="../assets/style.css?v=<?php echo time(); ?>">
</head>
<body>
  <div class="container">

    <div class="header">
      <div class="brand">
       
        <div>
          <div class="title">Editar Paciente #<?= esc($patient['id']) ?></div>
          <div class="subtitle">Modificar datos</div>
        </div>
      
    </div>
        
      </div>
      <div class="actions">
        <a class="btn btn-ghost" href="index.php">Inicio</a>
        <a class="btn btn-ghost" href="list.php">Ver Pacientes</a>
      </div>

      
      
    
    <div class="form">
      <form action="update.php" method="post">

        <input type="hidden" name="id" value="<?= esc($patient['id']) ?>">

        <div class="row">
          <div class="field">
            <label>Nombre</label>
            <input type="text" name="nombre" required value="<?= esc($patient['nombre'] ?? '') ?>">
          </div>
          <div class="field">
            <label>Apellido</label>
            <input type="text" name="apellido" required value="<?= esc($patient['apellido'] ?? '') ?>">
          </div>
        </div>

        <div class="row">
          <div class="field">
            <label>Documento</label>
            <input type="text" name="documento" required value="<?= esc($patient['documento'] ?? '') ?>">
          </div>
          <div class="field">
            <label>Edad</label>
            <input type="number" name="edad" required min="0" value="<?= esc($patient['edad'] ?? '') ?>">
          </div>
        </div>

        <div class="row">
          <div class="field">
            <label>Sexo</label>
            <select name="sexo" required>
              <option value="M" <?= (($patient['sexo'] ?? '') === 'M') ? 'selected' : '' ?>>M</option>
              <option value="F" <?= (($patient['sexo'] ?? '') === 'F') ? 'selected' : '' ?>>F</option>
              <option value="O" <?= (($patient['sexo'] ?? '') === 'O') ? 'selected' : '' ?>>Otro</option>
            </select>
          </div>
          <div class="field">
            <label>Teléfono</label>
            <input type="text" name="telefono" value="<?= esc($patient['telefono'] ?? '') ?>">
          </div>
        </div>

        <div class="field">
          <label>Dirección</label>
          <input type="text" name="direccion" value="<?= esc($patient['direccion'] ?? '') ?>">
        </div>

        <div class="field">
          <label>Fecha Registro</label>
          <input type="date" name="fecha_registro" value="<?= esc($patient['fecha_registro'] ?? '') ?>">
        </div>

        <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:8px">
          <a class="btn btn-ghost" href="list.php">Cancelar</a>
          <button class="btn btn-primary" type="submit">Actualizar Paciente</button>
        </div>

      </form>
    </div>

  </div>
</body>
</html>

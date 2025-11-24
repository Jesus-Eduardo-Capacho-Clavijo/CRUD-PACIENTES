<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Registrar Paciente</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="../assets/style.css?v=<?php echo time(); ?>">
</head>
<body>
  <div class="container">
    <div class="header">
      <div class="brand">
        
        <div>
          <div class="title">Registrar Paciente</div>
          <div class="subtitle">Complete los datos del nuevo paciente</div>
        </div>
      </div>
      
    </div>
    <div class="actions">
        <a class="btn btn-ghost" href="index.php">Inicio</a>
        <a class="btn btn-ghost" href="list.php">Ver Pacientes</a>
      </div>

    <?php if (!empty($_GET['error'])): ?>
        <div class="centered-note" style="color:red; background: #ffe6e6; padding: 12px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #ffcccc;">
            <strong>Error:</strong> <?= htmlspecialchars(urldecode($_GET['error'])) ?>
        </div>
    <?php endif; ?>

    <div class="form">
      <form action="store.php" method="post">
        <div class="row">
          <div class="field">
            <label>Nombre *</label>
            <input type="text" name="nombre" required maxlength="50" value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">
          </div>
          <div class="field">
            <label>Apellido *</label>
            <input type="text" name="apellido" required maxlength="50" value="<?= htmlspecialchars($_POST['apellido'] ?? '') ?>">
          </div>
        </div>

        <div class="row">
          <div class="field">
            <label>Documento *</label>
            <input type="text" name="documento" required maxlength="20" value="<?= htmlspecialchars($_POST['documento'] ?? '') ?>">
          </div>
          <div class="field">
            <label>Edad *</label>
            <input type="number" name="edad" required min="0" max="150" value="<?= htmlspecialchars($_POST['edad'] ?? '') ?>">
          </div>
        </div>

        <div class="row">
          <div class="field">
            <label>Sexo *</label>
            <select name="sexo" required>
              <option value="">Seleccionar</option>
              <option value="M" <?= (($_POST['sexo'] ?? '') === 'M') ? 'selected' : '' ?>>Masculino</option>
              <option value="F" <?= (($_POST['sexo'] ?? '') === 'F') ? 'selected' : '' ?>>Femenino</option>
              <option value="O" <?= (($_POST['sexo'] ?? '') === 'O') ? 'selected' : '' ?>>Otro</option>
            </select>
          </div>
          <div class="field">
            <label>Teléfono</label>
            <input type="text" name="telefono" maxlength="15" value="<?= htmlspecialchars($_POST['telefono'] ?? '') ?>">
          </div>
        </div>

        <div class="field">
          <label>Dirección</label>
          <input type="text" name="direccion" maxlength="100" value="<?= htmlspecialchars($_POST['direccion'] ?? '') ?>">
        </div>

        <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:8px">
          <a class="btn btn-ghost" href="list.php">Cancelar</a>
          <button class="btn btn-primary" type="submit">Guardar Paciente</button>
        </div>
      </form>
    </div>

  </div>
</body>
</html>
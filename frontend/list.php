<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

// 🚀 Corrección clave: deshabilitar caché WSDL
ini_set("soap.wsdl_cache_enabled", "0");
ini_set("soap.wsdl_cache_ttl", "0");

require_once __DIR__ . '/../backend/soap_client.php';

$wsdl = 'http://localhost/pacientes_soap/backend/pacientes.wsdl';
$client = new PacientesSoapClient($wsdl);

$error = "";
$patients = [];

try {
    // Obtener datos del servicio SOAP
    $result = $client->getPatients();

    // Convertir respuesta en array
    $data = json_decode(json_encode($result), true);

    // Extraer lista de pacientes según estructura del servidor
    if (isset($data['paciente'])) {
        $patients = $data['paciente'];
    } elseif (isset($data['return']['paciente'])) {
        $patients = $data['return']['paciente'];
    } elseif (isset($data['return'])) {
        $patients = $data['return'];
    } else {
        $patients = $data;
    }

    // Normalizar: si es un solo paciente, conviértelo en array
    if (!empty($patients) && isset($patients['id'])) {
        $patients = [$patients];
    }

    if (!is_array($patients)) {
        $patients = [];
    }

} catch (Throwable $e) {
    $patients = [];
    $error = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Listado de Pacientes</title>
<link rel="stylesheet" href="../assets/style.css?v=<?php echo time(); ?>">
</head>
<body>

<div class="container">

     <div class="header">
        <div class="brand">
            
            <div>
                <div class="title">Listado de Pacientes</div>
                <div class="subtitle">Gestión completa de registros médicos</div>
            </div>
        </div>

        <div class="actions">
            <a href="index.php"><button class="btn btn-ghost">Inicio</button></a>
            <a href="create.php"><button class="btn btn-primary">Registrar Paciente</button></a>
        </div>
    </div>

    <?php if (!empty($_GET['success'])): ?>
        <div class="centered-note" style="color:green; background:#e6ffe6; padding:12px; border-radius:8px; margin-bottom:20px;">
            ✔ <?= htmlspecialchars($_GET['success']) ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($_GET['error'])): ?>
        <div class="centered-note" style="color:red; background:#ffe6e6; padding:12px; border-radius:8px; margin-bottom:20px;">
            Error: <?= htmlspecialchars($_GET['error']) ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="centered-note" style="color:red; background:#ffe6e6; padding:12px; border-radius:8px; margin-bottom:20px;">
            Error del sistema: <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Documento</th>
                <th>Edad</th>
                <th>Sexo</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Fecha Registro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($patients)): ?>
            <?php foreach ($patients as $p): ?>
                <?php $p = (array)$p; ?>
                <tr>
                    <td><?= htmlspecialchars($p['id'] ?? '') ?></td>
                    <td><?= htmlspecialchars($p['nombre'] ?? '') ?></td>
                    <td><?= htmlspecialchars($p['apellido'] ?? '') ?></td>
                    <td><?= htmlspecialchars($p['documento'] ?? '') ?></td>
                    <td><?= htmlspecialchars($p['edad'] ?? '') ?></td>
                    <td><?= htmlspecialchars($p['sexo'] ?? '') ?></td>
                    <td><?= htmlspecialchars($p['telefono'] ?? '') ?></td>
                    <td><?= htmlspecialchars($p['direccion'] ?? '') ?></td>
                    <td><?= htmlspecialchars($p['fecha_registro'] ?? '') ?></td>
                    <td class="actions-row">
                        <a href="edit.php?id=<?= urlencode($p['id']) ?>">
                            <button class="btn btn-ghost">Editar</button>
                        </a>
                        <a href="delete.php?documento=<?= urlencode($p['documento']) ?>" 
                        onclick="return confirm('¿Está seguro de eliminar este paciente?')">
                            <button class="btn btn-danger">Eliminar</button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="10" style="text-align:center; color:#777; padding:20px;">
                    No hay pacientes registrados. 
                    <a href="create.php" style="color:#4CAF50;">Registrar uno nuevo</a>
                </td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

</div>

</body>
</html>

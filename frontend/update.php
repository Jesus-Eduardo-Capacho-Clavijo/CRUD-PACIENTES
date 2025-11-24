<?php
require_once __DIR__ . '/../backend/soap_client.php';

if (empty($_POST['id']) || empty($_POST['nombre']) || empty($_POST['apellido']) || empty($_POST['documento'])) {
    header("Location: list.php?error=Faltan datos obligatorios");
    exit;
}

try {
    $wsdl = 'http://localhost/pacientes_soap/backend/pacientes.wsdl';
    $client = new PacientesSoapClient($wsdl);

    $data = [
        "id" => (int)$_POST['id'],
        "nombre" => trim($_POST['nombre']),
        "apellido" => trim($_POST['apellido']),
        "documento" => trim($_POST['documento']),
        "edad" => (int)$_POST['edad'],
        "sexo" => $_POST['sexo'],
        "telefono" => trim($_POST['telefono']),
        "direccion" => trim($_POST['direccion']),
        "fecha_registro" => $_POST['fecha_registro']
    ];

    // 🔥 CORREGIDO: enviar los datos directos
    $ok = $client->updatePatient($data);

    if ($ok) {
        header("Location: list.php?success=Paciente actualizado correctamente");
        exit;
    }

    header("Location: edit.php?id=" . $data['id'] . "&error=No se pudo actualizar");

} catch (Throwable $e) {
    header("Location: edit.php?id=" . $_POST['id'] . "&error=" . urlencode($e->getMessage()));
}
exit;
?>

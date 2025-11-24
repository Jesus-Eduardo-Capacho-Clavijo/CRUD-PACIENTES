<?php
require_once __DIR__ . '/../backend/soap_client.php';

if (!isset($_GET['documento'])) {
    header("Location: list.php?error=Documento inválido");
    exit;
}

try {
    $wsdl = "http://localhost/pacientes_soap/backend/pacientes.wsdl";
    $client = new PacientesSoapClient($wsdl);

    // 🔥 CORRECCIÓN: Usar documento en lugar de ID
    $documento = (string)$_GET['documento'];
$ok = $client->deletePatient($documento);


    if ($ok) {
        header("Location: list.php?success=Paciente eliminado correctamente");
        exit;
    }

    header("Location: list.php?error=No se pudo eliminar el paciente");
    exit;

} catch (Throwable $e) {
    header("Location: list.php?error=" . urlencode($e->getMessage()));
    exit;
}
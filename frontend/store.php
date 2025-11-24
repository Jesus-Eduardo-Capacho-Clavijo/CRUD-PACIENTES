<?php
require_once __DIR__ . "/../backend/soap_client.php";

if (empty($_POST["nombre"]) || empty($_POST["apellido"]) || empty($_POST["documento"])) {
    header("Location: create.php?error=Faltan datos");
    exit;
}
$edad = intval($_POST["edad"]);
if ($edad < 0 || $edad > 150) {
    header("Location: create.php?error=Edad inválida (debe ser 0-150)");
    exit;
}

if (!in_array($_POST["sexo"], ['M', 'F', 'O'])) {
    header("Location: create.php?error=Sexo inválido");
    exit;
}
try {
    $client = new PacientesSoapClient("http://localhost/pacientes_soap/backend/pacientes.wsdl");

    $data = [
        "nombre" => trim($_POST["nombre"]),
        "apellido" => trim($_POST["apellido"]),
        "documento" => trim($_POST["documento"]),
        "edad" => intval($_POST["edad"]),
        "sexo" => $_POST["sexo"],
        "telefono" => trim($_POST["telefono"]),
        "direccion" => trim($_POST["direccion"]),
        "fecha_registro" => date("Y-m-d")
    ];

    $id = $client->createPatient($data);

    if ($id > 0) {
        header("Location: list.php?success=Paciente creado con ID $id");
    } else {
        header("Location: create.php?error=No se pudo crear");
    }

} catch (Throwable $e) {
    header("Location: create.php?error=" . urlencode($e->getMessage()));
}
exit;

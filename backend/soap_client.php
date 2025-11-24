<?php
declare(strict_types=1);

class PacientesSoapClient {

    private SoapClient $client;

    public function __construct(string $wsdlUrl) {

        // 🔥 Corrección importante: evitar WSDL en caché
        $this->client = new SoapClient($wsdlUrl, [
            'trace' => 1,
            'exceptions' => true,
            'cache_wsdl' => WSDL_CACHE_NONE  // <--- necesario
        ]);
    }

    /**
     * Convierte respuesta SOAP a array limpio
     */
    private function unwrap($r) {
        $a = json_decode(json_encode($r), true);
        return $a["return"] ?? $a;
    }

    /**
     * Listar todos los pacientes
     */
    public function getPatients(): array {
        $res = $this->client->getPatients();
        return $this->unwrap($res)["paciente"] ?? [];
    }

    /**
     * 🔥 CORREGIDO: getPatient debe mandar SOLO el ID al servidor
     */
    public function getPatient(int $id): ?array {
        $res = $this->client->getPatient($id);
        return $this->unwrap($res);
    }

    /**
     * Crear paciente
     */
    public function createPatient(array $d): int {

        $params = [
            "nombre" => $d["nombre"],
            "apellido" => $d["apellido"],
            "documento" => $d["documento"],
            "edad" => $d["edad"],
            "sexo" => $d["sexo"],
            "telefono" => $d["telefono"],
            "direccion" => $d["direccion"],
            "fecha_registro" => $d["fecha_registro"],
        ];

        $res = $this->client->createPatient($params);
        return intval($this->unwrap($res));
    }

    /**
     * Actualizar paciente
     */
    public function updatePatient(array $d): bool {

        $params = [
            "id" => $d["id"],
            "nombre" => $d["nombre"],
            "apellido" => $d["apellido"],
            "documento" => $d["documento"],
            "edad" => $d["edad"],
            "sexo" => $d["sexo"],
            "telefono" => $d["telefono"],
            "direccion" => $d["direccion"],
            "fecha_registro" => $d["fecha_registro"]
        ];

        $res = $this->client->updatePatient($params);
        return boolval($this->unwrap($res));
    }

    /**
     * 🔥 CORREGIDO: deletePatient debe enviar solo el ID
     */
    public function deletePatient(string $documento): bool {

    // Enviar directamente el string, NO ARRAY
    $res = $this->client->__soapCall("deletePatient", [$documento]);

    return boolval($this->unwrap($res));
}




}

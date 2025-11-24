<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

$xmlFile = __DIR__ . "/pacientes.xml";

/**
 * Clase CRUD para pacientes
 */
class PacientesService
{
    private string $xmlFile;

    public function __construct($xmlFile)
    {
        $this->xmlFile = $xmlFile;

        if (!file_exists($xmlFile)) {
            file_put_contents($xmlFile,
                "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<pacientes></pacientes>");
        }
    }

    private function loadXML()
    {
        $xml = simplexml_load_file($this->xmlFile);
        if ($xml === false) {
            file_put_contents($this->xmlFile,
                "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<pacientes></pacientes>");
            $xml = simplexml_load_file($this->xmlFile);
        }
        return $xml;
    }

    private function saveXML($xml)
    {
        $dom = new DOMDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($xml->asXML());
        return $dom->save($this->xmlFile);
    }

    /**
     * LISTAR PACIENTES
     */
    public function getPatients()
    {
        $xml = $this->loadXML();
        $list = [];

        foreach ($xml->paciente as $p) {
            $list[] = [
                "id"             => (int)$p->id,
                "nombre"         => (string)$p->nombre,
                "apellido"       => (string)$p->apellido,
                "documento"      => (string)$p->documento,
                "edad"           => (int)$p->edad,
                "sexo"           => (string)$p->sexo,
                "telefono"       => (string)$p->telefono,
                "direccion"      => (string)$p->direccion,
                "fecha_registro" => (string)$p->fecha_registro
            ];
        }

        return ["paciente" => $list];
    }

    /**
     * OBTENER PACIENTE POR ID
     */
    public function getPatient($params)
        {
            if (is_array($params) && isset($params['id'])) {
            $id = (int)$params['id'];
        } elseif (is_object($params) && isset($params->id)) {
            $id = (int)$params->id;
        } elseif (is_numeric($params)) {
            $id = (int)$params;
        } else {
            return null;
        }

        $xml = $this->loadXML();

        foreach ($xml->paciente as $p) {
            if ((int)$p->id === $id) {
                return [
                    "id"             => (int)$p->id,
                    "nombre"         => (string)$p->nombre,
                    "apellido"       => (string)$p->apellido,
                    "documento"      => (string)$p->documento,
                    "edad"           => (int)$p->edad,
                    "sexo"           => (string)$p->sexo,
                    "telefono"       => (string)$p->telefono,
                    "direccion"      => (string)$p->direccion,
                    "fecha_registro" => (string)$p->fecha_registro
                ];
            }
        }

        return null;
    }

    /**
     * CREAR PACIENTE
     */
    public function createPatient($params)
    {
        try {
            $data = is_object($params) ? $params : (object)$params;

            $xml = $this->loadXML();

            // Generar ID automáticamente
            $newId = 1;
            if (count($xml->paciente) > 0) {
                $lastId = 0;
                foreach ($xml->paciente as $p) {
                    $idActual = (int)$p->id;
                    if ($idActual > $lastId) {
                        $lastId = $idActual;
                    }
                }
                $newId = $lastId + 1;
            }

            $paciente = $xml->addChild('paciente');
            $paciente->addChild('id', $newId);
            $paciente->addChild('nombre', (string)$data->nombre);
            $paciente->addChild('apellido', (string)$data->apellido);
            $paciente->addChild('documento', (string)$data->documento);
            $paciente->addChild('edad', (int)$data->edad);
            $paciente->addChild('sexo', (string)$data->sexo);
            $paciente->addChild('telefono', (string)($data->telefono ?? ''));
            $paciente->addChild('direccion', (string)($data->direccion ?? ''));
            $paciente->addChild('fecha_registro', (string)$data->fecha_registro);

            return $this->saveXML($xml) ? $newId : 0;

        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * ACTUALIZAR
     */
    public function updatePatient($params)
    {
        try {
            $data = is_object($params) ? $params : (object)$params;

            $xml = $this->loadXML();
            $found = false;

            foreach ($xml->paciente as $p) {
                if ((int)$p->id === (int)$data->id) {

                    $p->nombre = (string)$data->nombre;
                    $p->apellido = (string)$data->apellido;
                    $p->documento = (string)$data->documento;
                    $p->edad = (int)$data->edad;
                    $p->sexo = (string)$data->sexo;
                    $p->telefono = (string)($data->telefono ?? '');
                    $p->direccion = (string)($data->direccion ?? '');
                    $p->fecha_registro = (string)$data->fecha_registro;
                    $found = true;
                    break;
                }
            }

            return $found ? $this->saveXML($xml) : false;

        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * ELIMINAR
     */
/**
 * ELIMINAR
 */
public function deletePatient($params)
{
    try {
        error_log("deletePatient() params: " . print_r($params, true));

        // extraer documento
        if (is_array($params) && isset($params['documento'])) {
    $documento = (string)$params['documento'];
} elseif (is_object($params) && isset($params->documento)) {
    $documento = (string)$params->documento;
} else {
    $documento = (string)$params;
}
error_log("Documento FINAL extraído: " . $documento);



        error_log("Documento recibido: $documento");

        if (trim($documento) === "") {
            error_log("Documento vacío");
            return false;
        }

        $xml = $this->loadXML();
        $found = false;

        foreach ($xml->paciente as $p) {

            $docActual = (string)$p->documento;
            error_log("Comparando: '$docActual' == '$documento'");

            if ($docActual === $documento) {

                $dom = dom_import_simplexml($p);
                $dom->parentNode->removeChild($dom);

                error_log("Eliminado OK");
                $found = true;
                break;
            }
        }

        if ($found) {
            $save = $this->saveXML($xml);
            error_log("Guardado XML: " . ($save ? "true" : "false"));
            return $save;
        }

        error_log("No se encontró paciente con documento $documento");
        return false;

    } catch (Exception $e) {
        error_log("Error deletePatient: " . $e->getMessage());
        return false;
    }
}
}

// Servidor SOAP
try {
    $server = new SoapServer(__DIR__ . "/pacientes.wsdl", [
        'cache_wsdl' => WSDL_CACHE_NONE
    ]);

    $server->setClass("PacientesService", $xmlFile);
    $server->handle();

} catch (Exception $e) {
    echo "Error en servidor SOAP: " . $e->getMessage();
}
?>


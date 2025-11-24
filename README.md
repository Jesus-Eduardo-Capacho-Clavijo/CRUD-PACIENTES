# 🏥 CRUD de Pacientes - Sistema de Gestión Médica

## 📋 Descripción
Sistema completo de gestión de pacientes desarrollado con **PHP SOAP** que permite realizar operaciones CRUD (Crear, Leer, Actualizar, Eliminar) sobre registros médicos.

## 🚀 Características
- ✅ **CRUD Completo** de pacientes
- 🔄 **Servicio SOAP** para integración
- 🎨 **Interfaz moderna** con diseño pastel verde
- 💾 **Almacenamiento en XML**
- 📱 **Responsive design**

## 🛠️ Tecnologías Utilizadas
- **PHP 8.1+**
- **SOAP Web Services**
- **XML** para persistencia de datos
- **HTML5 + CSS3**
- **JavaScript**

## 📁 Estructura del Proyecto

<img width="337" height="278" alt="image" src="https://github.com/user-attachments/assets/954fbb80-fdee-4123-9fe7-1efd5d5cee49" />


## 🔧 Instalación y Configuración

### Requisitos
- Servidor web (Apache, Nginx)
- PHP 8.1 o superior
- Extensión SOAP habilitada en PHP

### Pasos de instalación
1. **Clonar el repositorio:**
   ```bash
   git clone https://github.com/Jesus-Eduardo-Capacho-Clavijo/CRUD-PACIENTES.git

## Instalación y Configuración

### Requisitos
- Servidor web (Apache, Nginx)
- PHP 8.1 o superior
- Extensión SOAP habilitada en PHP

### Pasos de instalación
1. **Clonar el repositorio:**
   ```bash
   git clone https://github.com/Jesus-Eduardo-Capacho-Clavijo/CRUD-PACIENTES.git
Configurar el servidor web:

Apuntar el document root a la carpeta frontend/

Asegurar permisos de escritura en backend/pacientes.xml

Verificar configuración PHP:

bash
php -m | grep soap
Acceder a la aplicación:

text
http://localhost/pacientesCRUDClavijo/frontend/

## Funcionalidades

### Gestión de Pacientes
- Registrar nuevos pacientes
- Visualizar listado completo
- Editar información existente
- Eliminar registros médicos

### Campos del Paciente
- Nombre y apellido
- Número de documento
- Edad y sexo
- Teléfono y dirección
- Fecha de registro

## Servicio SOAP

### Endpoints disponibles
- getPatients() - Listar todos los pacientes
- getPatient(id) - Obtener paciente por ID
- createPatient(data) - Crear nuevo paciente
- updatePatient(data) - Actualizar paciente
- deletePatient(documento) - Eliminar por documento

### WSDL
http://localhost/pacientesCRUDClavijo/backend/pacientes.wsdl

text

## Diseño
- Paleta de colores: Verde pastel (#8fcbbf)
- Interfaz: Limpia y minimalista
- Responsive: Adaptable a dispositivos móviles
- UX: Navegación intuitiva

## Autores
- Jesus Eduardo Capacho Clavijo - Desarrollo y documentación

## Licencia
Este proyecto es de uso académico para la asignatura de Desarrollo Web.

## Reportar Problemas
Si encuentras algún error, por favor abre un issue en el repositorio.

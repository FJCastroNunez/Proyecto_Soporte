🛠️ Proyecto Soporte – Sistema de Gestión de Tickets
📌 Descripción general

Este proyecto corresponde a un sistema web de gestión de tickets de soporte, diseñado para registrar, clasificar y dar seguimiento a solicitudes, reclamos y consultas de usuarios.

El sistema permite centralizar la atención de incidencias, mejorando la organización interna, la trazabilidad de los casos y la comunicación entre usuarios y personal de soporte.

🎯 Problema que resuelve

En muchos entornos (empresas, instituciones o equipos de TI), las solicitudes de soporte se gestionan de forma informal (correo, WhatsApp o verbalmente), lo que genera:

Pérdida de información

Falta de seguimiento de los casos

Dificultad para priorizar problemas

Nula trazabilidad del historial

👉 Este proyecto soluciona ese problema mediante un sistema estructurado de tickets, donde cada caso queda registrado, clasificado y asociado a un estado.

🧩 Funcionalidades principales
🎫 Gestión de tickets

Creación de tickets de soporte

Clasificación por tipo de problema

Estados del ticket (abierto, en proceso, cerrado)

Historial de mensajes asociados al ticket

Registro del usuario que crea y gestiona el ticket

👥 Usuarios

Gestión de usuarios

Asociación de tickets a usuarios

Control de acciones según rol

🗂️ Seguimiento

Registro de mensajes o comentarios

Visualización del historial completo del ticket

Identificación clara del estado del caso

🛠️ Tecnologías utilizadas
Backend

Java

Spring Boot

Spring Data JPA

Base de datos

MySQL

Otros

Arquitectura en capas

API REST

Manejo de entidades y relaciones

Validaciones de datos

🧱 Arquitectura del sistema

El proyecto sigue una arquitectura en capas, separando responsabilidades:

Controller: expone los endpoints REST

Service: contiene la lógica de negocio

Repository: acceso a datos mediante JPA

Model / Entity: representación de las tablas de la base de datos

Este enfoque permite:

Código mantenible

Escalabilidad

Facilidad para agregar nuevas funcionalidades

📂 Estructura general del proyecto

    Proyecto_Soporte
    ├── controller
    ├── service
    ├── repository
    ├── model
    ├── dto
    ├── config
    └── application.properties
▶️ Ejecución del proyecto
Requisitos

Java 17+

Maven

MySQL

Pasos generales

Clonar el repositorio: git clone https://github.com/FJCastroNunez/Proyecto_Soporte.git
Configurar la conexión a la base de datos en application.properties

Ejecutar el proyecto desde el IDE o con: mvn spring-boot:run

🔐 Seguridad y validaciones

Validación de datos de entrada

Control de estados del ticket

Asociación correcta entre usuarios y tickets

Manejo de errores a nivel de servicio

📚 Aprendizajes del proyecto

Diseño de APIs REST con Spring Boot

Modelado de entidades y relaciones

Separación de responsabilidades en backend

Gestión de estados de procesos

Desarrollo de sistemas orientados a soporte técnico

🚀 Estado del proyecto

🟢 Funcional
📌 Posibles mejoras futuras:

Autenticación y autorización

Roles más detallados

Integración con frontend

Reportes y métricas de tickets

👩‍💻 Autora

Francisca Castro
Analista Programadora Computacional
Estudiante de Ingeniería en Informática

📎 GitHub: https://github.com/FJCastroNunez

💼 Nota para reclutadores

Este proyecto demuestra mi capacidad para:

Desarrollar backend con Java y Spring Boot

Diseñar APIs REST estructuradas

Modelar sistemas basados en procesos reales

Trabajar con bases de datos relacionales

Implementar lógica de negocio clara y mantenible

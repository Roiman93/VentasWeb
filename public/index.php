<?php
/**
 * @format
 */

require_once __DIR__ . "/../includes/app.php";

use Controllers\AdminController;
use Controllers\APIController;
use Controllers\CitaController;
use Controllers\LoginController;
use Controllers\ServicioController;
use Controllers\BillingController;
use Controllers\CustomerController;
use Controllers\APIProductController;
use Controllers\APIBillingConroller;
use MVC\Router;
$router = new Router();

// Iniciar Sesión
$router->get("/", [LoginController::class, "login"]);
$router->post("/", [LoginController::class, "login"]);
$router->get("/logout", [LoginController::class, "logout"]);

// Recuperar Password
$router->get("/olvide", [LoginController::class, "olvide"]);
$router->post("/olvide", [LoginController::class, "olvide"]);
$router->get("/recuperar", [LoginController::class, "recuperar"]);
$router->post("/recuperar", [LoginController::class, "recuperar"]);

// Crear Cuenta
$router->get("/crear-cuenta", [LoginController::class, "crear"]);
$router->post("/crear-cuenta", [LoginController::class, "crear"]);

// Confirmar cuenta
$router->get("/confirmar-cuenta", [LoginController::class, "confirmar"]);
$router->get("/mensaje", [LoginController::class, "mensaje"]);

// AREA PRIVADA
$router->get("/cita", [CitaController::class, "index"]);
$router->get("/admin", [AdminController::class, "index"]);

// API de Citas
$router->get("/api/servicios", [APIController::class, "index"]);
$router->post("/api/citas", [APIController::class, "guardar"]);
$router->post("/api/eliminar", [APIController::class, "eliminar"]);

// CRUD de Servicios
$router->get("/servicios", [ServicioController::class, "index"]);
$router->get("/servicios/crear", [ServicioController::class, "crear"]);
$router->post("/servicios/crear", [ServicioController::class, "crear"]);
$router->get("/servicios/actualizar", [ServicioController::class, "actualizar"]);
$router->post("/servicios/actualizar", [ServicioController::class, "actualizar"]);
$router->post("/servicios/eliminar", [ServicioController::class, "eliminar"]);

/* cliente */
$router->get("/cliente", [CustomerController::class, "index"]);
$router->post("/cliente/seach", [CustomerController::class, "seach_filter"]);
$router->post("/api/cliente", [CustomerController::class, "get_cliente"]);
$router->post("/get_cliente", [CustomerController::class, "find"]);
$router->post("/add_cliente", [CustomerController::class, "add_customer"]);
$router->post("/upd_cliente", [CustomerController::class, "upd_customer"]);
$router->post("/api/cliente_delete", [CustomerController::class, "eliminar"]);

// facturacion
$router->get("/ventas", [BillingController::class, "index"]);
$router->post("/api/get_stock_producto", [APIBillingConroller::class, "seach_product"]);
$router->post("/api/get_add_detalle_producto", [APIBillingConroller::class, "add_detalle"]);
$router->post("/api/delete_detalle_producto", [APIBillingConroller::class, "delete_detalle"]);
$router->post("/api/cancel_process", [APIBillingConroller::class, "cancel_billing"]);
$router->post("/api/detalle", [APIBillingConroller::class, "seach_detalle"]);
$router->post("/api/process", [APIBillingConroller::class, "add"]);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();

<?php

namespace App\Swagger;

/**
 * @OA\Info(
 *   title="DP Core API",
 *   version="1.0.0",
 *   description="Documentación API completa para endpoints de autenticación"
 * )
 *
 * @OA\Server(
 *   url="https://dp-core-production.up.railway.app",
 *   description="Servidor publicado en Railway"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Laravel Sanctum Bearer Token"
 * )
 *
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     title="Usuario",
 *     description="Esquema del modelo Usuario",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID del usuario",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Nombre del usuario",
 *         example="Juan Pérez"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="Email del usuario",
 *         example="juan@example.com"
 *     ),
 *     @OA\Property(
 *         property="email_verified_at",
 *         type="string",
 *         format="date-time",
 *         nullable=true,
 *         description="Fecha de verificación del email",
 *         example=null
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Fecha de creación",
 *         example="2025-11-09T15:30:45.000000Z"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Fecha de actualización",
 *         example="2025-11-09T15:30:45.000000Z"
 *     )
 * )
 */
class SwaggerAnnotations 
{
    // Clase para contener anotaciones OpenAPI globales
}


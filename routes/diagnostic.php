<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

Route::get('/health', function () {
    return response()->json([
        'status' => 'OK',
        'timestamp' => now(),
        'php_version' => phpversion(),
        'laravel_version' => app()->version(),
    ]);
});

Route::get('/debug', function () {
    try {
        // Test database connection
        $dbStatus = 'connected';
        DB::connection()->getPdo();
        $tables = DB::select('SELECT table_name FROM information_schema.tables WHERE table_schema = ?', [config('database.connections.pgsql.database')]);
    } catch (Exception $e) {
        $dbStatus = 'failed: ' . $e->getMessage();
        $tables = [];
    }

    // Check Swagger files
    $swaggerJsonExists = file_exists(storage_path('api-docs/api-docs.json'));
    $swaggerJsonContent = $swaggerJsonExists ? 'exists' : 'missing';
    
    if ($swaggerJsonExists) {
        $jsonContent = file_get_contents(storage_path('api-docs/api-docs.json'));
        $swaggerData = json_decode($jsonContent, true);
        $swaggerJsonContent = $swaggerData ? 'valid JSON' : 'invalid JSON';
    }

    return response()->json([
        'app_name' => config('app.name'),
        'app_env' => config('app.env'),
        'app_debug' => config('app.debug'),
        'app_url' => config('app.url'),
        'database_status' => $dbStatus,
        'tables_count' => count($tables),
        'storage_writable' => is_writable(storage_path()),
        'cache_writable' => is_writable(storage_path('framework/cache')),
        'logs_writable' => is_writable(storage_path('logs')),
        'swagger_json_status' => $swaggerJsonContent,
        'swagger_config' => [
            'route' => config('l5-swagger.documentations.default.routes.api'),
            'generate_always' => config('l5-swagger.documentations.default.generate_always'),
            'host' => config('l5-swagger.documentations.default.constants.L5_SWAGGER_CONST_HOST'),
        ]
    ]);
});
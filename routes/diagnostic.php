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
    ]);
});
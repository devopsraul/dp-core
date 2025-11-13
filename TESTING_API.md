# Pruebas de la API de Autenticación

## Servidor corriendo en: http://localhost:8000

### 1. Test de Registro de Usuario
```bash
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "name": "Juan Pérez",
    "email": "juan@test.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

### 2. Test de Login
```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "email": "juan@test.com",
    "password": "password123"
  }'
```

### 3. Test de Usuario Autenticado (usar el token del login)
```bash
curl -X GET http://localhost:8000/api/auth/me \
  -H "Authorization: Bearer TU_TOKEN_AQUI" \
  -H "Accept: application/json"
```

### 4. Test de Logout
```bash
curl -X POST http://localhost:8000/api/auth/logout \
  -H "Authorization: Bearer TU_TOKEN_AQUI" \
  -H "Accept: application/json"
```

## Usando PowerShell para probar:

### Registro:
```powershell
Invoke-RestMethod -Uri "http://localhost:8000/api/auth/register" -Method POST -ContentType "application/json" -Body '{"name":"Test User","email":"test@example.com","password":"password123","password_confirmation":"password123"}'
```

### Login:
```powershell
$response = Invoke-RestMethod -Uri "http://localhost:8000/api/auth/login" -Method POST -ContentType "application/json" -Body '{"email":"test@example.com","password":"password123"}'
$token = $response.data.access_token
```

### Usuario autenticado:
```powershell
Invoke-RestMethod -Uri "http://localhost:8000/api/auth/me" -Headers @{"Authorization"="Bearer $token"} -ContentType "application/json"
```
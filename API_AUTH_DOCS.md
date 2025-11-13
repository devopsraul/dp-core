# API de Autenticación - Documentación

## Endpoints Disponibles

### 1. Registro de Usuario
**POST** `/api/auth/register`

**Body (JSON):**
```json
{
    "name": "Juan Pérez",
    "email": "juan@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

**Respuesta Exitosa (201):**
```json
{
    "success": true,
    "message": "Usuario registrado exitosamente",
    "data": {
        "user": {
            "id": 1,
            "name": "Juan Pérez",
            "email": "juan@example.com",
            "created_at": "2025-11-09T...",
            "updated_at": "2025-11-09T..."
        },
        "access_token": "1|abcd1234...",
        "token_type": "Bearer"
    }
}
```

### 2. Iniciar Sesión
**POST** `/api/auth/login`

**Body (JSON):**
```json
{
    "email": "juan@example.com",
    "password": "password123"
}
```

**Respuesta Exitosa (200):**
```json
{
    "success": true,
    "message": "Login exitoso",
    "data": {
        "user": {
            "id": 1,
            "name": "Juan Pérez",
            "email": "juan@example.com",
            "created_at": "2025-11-09T...",
            "updated_at": "2025-11-09T..."
        },
        "access_token": "2|efgh5678...",
        "token_type": "Bearer"
    }
}
```

### 3. Obtener Información del Usuario Autenticado
**GET** `/api/auth/me`

**Headers:**
```
Authorization: Bearer {token}
```

**Respuesta Exitosa (200):**
```json
{
    "success": true,
    "data": {
        "user": {
            "id": 1,
            "name": "Juan Pérez",
            "email": "juan@example.com",
            "created_at": "2025-11-09T...",
            "updated_at": "2025-11-09T..."
        }
    }
}
```

### 4. Cerrar Sesión
**POST** `/api/auth/logout`

**Headers:**
```
Authorization: Bearer {token}
```

**Respuesta Exitosa (200):**
```json
{
    "success": true,
    "message": "Logout exitoso"
}
```

### 5. Cerrar Sesión en Todos los Dispositivos
**POST** `/api/auth/logout-all`

**Headers:**
```
Authorization: Bearer {token}
```

**Respuesta Exitosa (200):**
```json
{
    "success": true,
    "message": "Logout exitoso en todos los dispositivos"
}
```

### 6. Actualizar Perfil
**PUT** `/api/auth/profile`

**Headers:**
```
Authorization: Bearer {token}
```

**Body (JSON):**
```json
{
    "name": "Juan Carlos Pérez",
    "email": "juan.carlos@example.com"
}
```

### 7. Cambiar Contraseña
**PUT** `/api/auth/change-password`

**Headers:**
```
Authorization: Bearer {token}
```

**Body (JSON):**
```json
{
    "current_password": "password123",
    "password": "newpassword456",
    "password_confirmation": "newpassword456"
}
```

## Manejo de Errores

### Error de Validación (422):
```json
{
    "success": false,
    "message": "Errores de validación",
    "errors": {
        "email": ["El email es requerido."],
        "password": ["La contraseña debe tener al menos 8 caracteres."]
    }
}
```

### Error de Autenticación (401):
```json
{
    "success": false,
    "message": "Credenciales incorrectas"
}
```

### Token No Válido (401):
```json
{
    "message": "Unauthenticated."
}
```

## Características de Seguridad

1. **Tokens con Expiración**: Los tokens expiran en 24 horas
2. **Revocación de Tokens**: Al hacer login, se revocan todos los tokens anteriores
3. **Logout Seguro**: Posibilidad de cerrar sesión en dispositivo actual o en todos
4. **Validaciones Robustas**: Validación de email, contraseñas seguras
5. **Hash de Contraseñas**: Las contraseñas se almacenan hasheadas con bcrypt
6. **Middleware de Autenticación**: Protección de rutas con Sanctum

## Uso con Frontend

### JavaScript/Fetch Example:
```javascript
// Login
const response = await fetch('/api/auth/login', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    },
    body: JSON.stringify({
        email: 'juan@example.com',
        password: 'password123'
    })
});

const data = await response.json();
const token = data.data.access_token;

// Usar token en requests posteriores
const userResponse = await fetch('/api/auth/me', {
    headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
    }
});
```

### Axios Example:
```javascript
// Configurar interceptor para incluir token automáticamente
axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

// O configurar por request
const response = await axios.get('/api/auth/me', {
    headers: {
        'Authorization': `Bearer ${token}`
    }
});
```
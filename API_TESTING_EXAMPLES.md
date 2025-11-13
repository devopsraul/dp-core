# 🧪 **Pruebas del RESTful API - Autenticación**

## **Servidor Local**
```
URL Base: http://127.0.0.1:8000/api
```

## **1. 📝 Registro de Usuario**

### **Endpoint:** `POST /api/auth/register`

### **Request:**
```json
POST http://127.0.0.1:8000/api/auth/register
Content-Type: application/json

{
    "name": "Juan Pérez",
    "email": "juan@example.com", 
    "password": "password123",
    "password_confirmation": "password123"
}
```

### **Response Exitoso (201):**
```json
{
    "success": true,
    "message": "Usuario registrado exitosamente",
    "data": {
        "user": {
            "id": 1,
            "name": "Juan Pérez",
            "email": "juan@example.com",
            "email_verified_at": null,
            "created_at": "2025-11-09T15:30:45.000000Z",
            "updated_at": "2025-11-09T15:30:45.000000Z"
        },
        "access_token": "1|abc123def456...",
        "token_type": "Bearer"
    }
}
```

---

## **2. 🔑 Login**

### **Endpoint:** `POST /api/auth/login`

### **Request:**
```json
POST http://127.0.0.1:8000/api/auth/login
Content-Type: application/json

{
    "email": "juan@example.com",
    "password": "password123"
}
```

### **Response Exitoso (200):**
```json
{
    "success": true,
    "message": "Login exitoso",
    "data": {
        "user": {
            "id": 1,
            "name": "Juan Pérez",
            "email": "juan@example.com",
            "email_verified_at": null,
            "created_at": "2025-11-09T15:30:45.000000Z",
            "updated_at": "2025-11-09T15:30:45.000000Z"
        },
        "access_token": "2|xyz789abc123...",
        "token_type": "Bearer"
    }
}
```

### **Response Error (401):**
```json
{
    "success": false,
    "message": "Credenciales incorrectas"
}
```

---

## **3. 👤 Obtener Usuario Actual**

### **Endpoint:** `GET /api/auth/me`

### **Request:**
```json
GET http://127.0.0.1:8000/api/auth/me
Authorization: Bearer 2|xyz789abc123...
Accept: application/json
```

### **Response Exitoso (200):**
```json
{
    "success": true,
    "data": {
        "user": {
            "id": 1,
            "name": "Juan Pérez",
            "email": "juan@example.com",
            "email_verified_at": null,
            "created_at": "2025-11-09T15:30:45.000000Z",
            "updated_at": "2025-11-09T15:30:45.000000Z"
        }
    }
}
```

---

## **4. 🔄 Actualizar Perfil**

### **Endpoint:** `PUT /api/auth/profile`

### **Request:**
```json
PUT http://127.0.0.1:8000/api/auth/profile
Authorization: Bearer 2|xyz789abc123...
Content-Type: application/json

{
    "name": "Juan Carlos Pérez",
    "email": "juancarlos@example.com"
}
```

### **Response Exitoso (200):**
```json
{
    "success": true,
    "message": "Perfil actualizado exitosamente",
    "data": {
        "user": {
            "id": 1,
            "name": "Juan Carlos Pérez", 
            "email": "juancarlos@example.com",
            "email_verified_at": null,
            "created_at": "2025-11-09T15:30:45.000000Z",
            "updated_at": "2025-11-09T15:35:22.000000Z"
        }
    }
}
```

---

## **5. 🔐 Cambiar Contraseña**

### **Endpoint:** `PUT /api/auth/change-password`

### **Request:**
```json
PUT http://127.0.0.1:8000/api/auth/change-password
Authorization: Bearer 2|xyz789abc123...
Content-Type: application/json

{
    "current_password": "password123",
    "password": "newpassword456",
    "password_confirmation": "newpassword456"
}
```

### **Response Exitoso (200):**
```json
{
    "success": true,
    "message": "Contraseña cambiada exitosamente. Por favor, inicia sesión nuevamente."
}
```

---

## **6. 🚪 Logout**

### **Endpoint:** `POST /api/auth/logout`

### **Request:**
```json
POST http://127.0.0.1:8000/api/auth/logout
Authorization: Bearer 2|xyz789abc123...
Accept: application/json
```

### **Response Exitoso (200):**
```json
{
    "success": true,
    "message": "Logout exitoso"
}
```

---

## **7. 🚪🔄 Logout en Todos los Dispositivos**

### **Endpoint:** `POST /api/auth/logout-all`

### **Request:**
```json
POST http://127.0.0.1:8000/api/auth/logout-all
Authorization: Bearer 2|xyz789abc123...
Accept: application/json
```

### **Response Exitoso (200):**
```json
{
    "success": true,
    "message": "Logout exitoso en todos los dispositivos"
}
```

---

## **Códigos de Error Comunes**

- **401 Unauthorized:** Token inválido o credenciales incorrectas
- **422 Unprocessable Entity:** Errores de validación
- **404 Not Found:** Endpoint no encontrado
- **500 Internal Server Error:** Error del servidor

---

## **Herramientas para Probar**

1. **Postman** - Interfaz gráfica
2. **cURL** - Línea de comandos  
3. **Insomnia** - Cliente REST
4. **Thunder Client** - Extensión de VS Code

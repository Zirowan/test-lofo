# API Documentation - ITS NU Pekalongan Lost & Found System

## Overview

This document provides detailed information about the RESTful API endpoints available in the Lost & Found System. The API allows for integration with external systems and mobile applications.

## Authentication

All API requests (except for login/register) require authentication via session cookies. Admin endpoints require admin-level authentication.

## Base URL

```
http://localhost:8000/api
```

## Error Responses

All error responses follow this format:

```json
{
  "error": "Error message",
  "message": "Detailed error description"
}
```

## Endpoints

### Authentication

#### POST `/login`
Authenticate a user

**Request Body:**
```json
{
  "email": "user@example.com",
  "password": "password"
}
```

**Response:**
```json
{
  "status": "success",
  "message": "Login successful",
  "user": {
    "id": 1,
    "name": "User Name",
    "email": "user@example.com"
  }
}
```

#### POST `/logout`
Logout the current user

**Response:**
```json
{
  "status": "success",
  "message": "Logged out successfully"
}
```

### Items

#### GET `/items`
Retrieve all items (with optional filters)

**Query Parameters:**
- `type` (string): Filter by item type (lost/found)
- `status` (string): Filter by item status
- `search` (string): Search term for item descriptions

**Response:**
```json
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "type": "lost",
      "description": "Black wallet",
      "status": "Unresolved",
      "latitude": -6.888,
      "longitude": 109.675,
      "created_at": "2025-01-01T10:00:00.000000Z"
    }
  ]
}
```

#### POST `/items`
Create a new item listing

**Request Body:**
```json
{
  "type": "lost",
  "description": "Black wallet",
  "latitude": -6.888,
  "longitude": 109.675,
  "pic": "base64_encoded_image"
}
```

**Response:**
```json
{
  "status": "success",
  "message": "Item created successfully",
  "data": {
    "id": 1,
    "type": "lost",
    "description": "Black wallet",
    "status": "Unresolved"
  }
}
```

#### GET `/items/{id}`
Retrieve a specific item

**Response:**
```json
{
  "status": "success",
  "data": {
    "id": 1,
    "type": "lost",
    "description": "Black wallet",
    "status": "Unresolved",
    "latitude": -6.888,
    "longitude": 109.675,
    "created_at": "2025-01-01T10:00:00.000000Z",
    "owner": {
      "name": "Student Name",
      "email": "student@itsnupkl.ac.id"
    }
  }
}
```

### Claims

#### GET `/claims`
Retrieve all claims for the authenticated user

**Response:**
```json
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "item_id": 5,
      "status": "Pending",
      "created_at": "2025-01-01T10:00:00.000000Z"
    }
  ]
}
```

#### POST `/claims/{item_id}`
Create a new claim for an item

**Response:**
```json
{
  "status": "success",
  "message": "Claim submitted successfully",
  "data": {
    "id": 1,
    "item_id": 5,
    "status": "Pending"
  }
}
```

#### PUT `/claims/{id}/approve`
Approve a claim (admin only)

**Response:**
```json
{
  "status": "success",
  "message": "Claim approved successfully"
}
```

#### PUT `/claims/{id}/reject`
Reject a claim (admin only)

**Response:**
```json
{
  "status": "success",
  "message": "Claim rejected successfully"
}
```

### Admin

#### GET `/admin/items`
Retrieve all items (admin only)

**Response:**
```json
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "type": "lost",
      "description": "Black wallet",
      "status": "Unresolved",
      "is_approved": false,
      "is_flagged": false
    }
  ]
}
```

#### POST `/admin/items/{id}/approve`
Approve an item (admin only)

**Response:**
```json
{
  "status": "success",
  "message": "Item approved successfully"
}
```

#### POST `/admin/items/{id}/flag`
Flag an item (admin only)

**Request Body:**
```json
{
  "reason": "Inappropriate content"
}
```

**Response:**
```json
{
  "status": "success",
  "message": "Item flagged successfully"
}
```

#### GET `/admin/reports`
Retrieve admin activity logs (admin only)

**Response:**
```json
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "admin_id": 1,
      "action": "Approved item #5",
      "ip_address": "127.0.0.1",
      "created_at": "2025-01-01T10:00:00.000000Z"
    }
  ]
}
```

## Rate Limiting

The API implements rate limiting to prevent abuse:
- 60 requests per minute for regular endpoints
- 10 requests per minute for authentication endpoints

## CORS Policy

The API allows requests from the same origin and from the configured frontend domain.

## Versioning

This API is currently at version 1.0. Breaking changes will be introduced in new versions with appropriate versioning in the URL path.

## Support

For API support, please contact the development team at:
- Email: support@itsnupkl.ac.id
- Phone: +62 XXX XXX XXXX
# EcommerceAPI Documentation

## Overview

This document provides detailed information about the EcommerceAPI endpoints, request/response formats, authentication requirements, and usage examples.

## Base URL

All API requests should be prefixed with:

```
http://your-domain.com/api
```

## Authentication

The API uses JWT (JSON Web Tokens) for authentication. Protected routes require a valid token to be included in the request header.

### Headers for authenticated requests

```
Authorization: Bearer {your_jwt_token}
Content-Type: application/json
Accept: application/json
```

### Authentication Endpoints

#### Register a new user

```
POST /auth/register
```

**Request Body:**

```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Response (201 Created):**

```json
{
  "message": "User successfully registered",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "created_at": "2023-01-01T12:00:00.000000Z",
    "updated_at": "2023-01-01T12:00:00.000000Z"
  }
}
```

#### Login and get JWT token

```
POST /auth/login
```

**Request Body:**

```json
{
  "email": "john@example.com",
  "password": "password123"
}
```

**Response (200 OK):**

```json
{
  "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
  "token_type": "bearer",
  "expires_in": 3600,
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  }
}
```

**Error Response (401 Unauthorized):**

```json
{
  "error": "Unauthorized"
}
```

#### Logout and invalidate token

```
POST /auth/logout
```

**Headers:**

```
Authorization: Bearer {your_jwt_token}
```

**Response (200 OK):**

```json
{
  "message": "User successfully signed out"
}
```

#### Refresh JWT token

```
POST /auth/refresh
```

**Headers:**

```
Authorization: Bearer {your_jwt_token}
```

**Response (200 OK):**

```json
{
  "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
  "token_type": "bearer",
  "expires_in": 3600,
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  }
}
```

#### Get authenticated user details

```
GET /auth/user-profile
```

**Headers:**

```
Authorization: Bearer {your_jwt_token}
```

**Response (200 OK):**

```json
{
  "id": 1,
  "name": "John Doe",
  "email": "john@example.com",
  "created_at": "2023-01-01T12:00:00.000000Z",
  "updated_at": "2023-01-01T12:00:00.000000Z"
}
```

## Products

### List all products

```
GET /product
```

**Response (200 OK):**

```json
{
  "products": [
    {
      "id": 1,
      "name": "Product 1",
      "category_id": 1,
      "brand_id": 1,
      "price": 99.99,
      "amount": 100,
      "discount": 10,
      "image": "products/product1.jpg",
      "is_trendy": 1,
      "is_available": 1,
      "created_at": "2023-01-01T12:00:00.000000Z",
      "updated_at": "2023-01-01T12:00:00.000000Z"
    },
    {
      "id": 2,
      "name": "Product 2",
      "category_id": 2,
      "brand_id": 1,
      "price": 149.99,
      "amount": 50,
      "discount": 0,
      "image": "products/product2.jpg",
      "is_trendy": 0,
      "is_available": 1,
      "created_at": "2023-01-01T12:00:00.000000Z",
      "updated_at": "2023-01-01T12:00:00.000000Z"
    }
  ]
}
```

### Get product details

```
GET /product/{id}
```

**Response (200 OK):**

```json
{
  "product": {
    "id": 1,
    "name": "Product 1",
    "category_id": 1,
    "brand_id": 1,
    "price": 99.99,
    "amount": 100,
    "discount": 10,
    "image": "products/product1.jpg",
    "is_trendy": 1,
    "is_available": 1,
    "created_at": "2023-01-01T12:00:00.000000Z",
    "updated_at": "2023-01-01T12:00:00.000000Z"
  }
}
```

**Error Response (404 Not Found):**

```json
{
  "message": "Product Not Found!"
}
```

### Create a new product

```
POST /product
```

**Request Body (multipart/form-data):**

```
name: "New Product"
category_id: 1
brand_id: 1
price: 199.99
amount: 50
discount: 5
image: [file upload]
is_trendy: 1
is_available: 1
```

**Response (201 Created):**

```json
{
  "message": "Product Added Successfully!"
}
```

### Update a product

```
POST /product/update/{id}
```

**Request Body (multipart/form-data):**

```
name: "Updated Product"
category_id: 2
brand_id: 1
price: 179.99
amount: 75
discount: 10
image: [file upload] (optional)
is_trendy: 0
is_available: 1
```

**Response (200 OK):**

```json
{
  "message": "Product Updated Successfully!"
}
```

### Delete a product

```
DELETE /product/{id}
```

**Response (200 OK):**

```json
{
  "message": "Product Deleted Successfully!"
}
```

## Categories

### List all categories

```
GET /category
```

**Response (201 Created):**

```json
{
  "data": [
    {
      "id": 1,
      "name": "Electronics",
      "image": "categories/electronics.jpg",
      "created_at": "2023-01-01T12:00:00.000000Z",
      "updated_at": "2023-01-01T12:00:00.000000Z"
    },
    {
      "id": 2,
      "name": "Clothing",
      "image": "categories/clothing.jpg",
      "created_at": "2023-01-01T12:00:00.000000Z",
      "updated_at": "2023-01-01T12:00:00.000000Z"
    }
  ]
}
```

### Get category details

```
GET /category/{id}
```

**Response (201 Created):**

```json
{
  "id": 1,
  "name": "Electronics",
  "image": "categories/electronics.jpg",
  "created_at": "2023-01-01T12:00:00.000000Z",
  "updated_at": "2023-01-01T12:00:00.000000Z"
}
```

**Error Response:**

```json
{
  "message": "Category Not Found!"
}
```

### Create a new category

```
POST /category
```

**Request Body (multipart/form-data):**

```
name: "New Category"
image: [file upload]
```

**Response:**

```json
{
  "message": "Category Saved Successfully!"
}
```

### Update a category

```
POST /category/update/{id}
```

**Request Body (multipart/form-data):**

```
name: "Updated Category"
image: [file upload] (optional)
```

**Response:**

```json
{
  "message": "Category Updated Successfully!"
}
```

### Delete a category

```
DELETE /category/{id}
```

**Response:**

```json
{
  "message": "Category Deleted Successfully!"
}
```

## Brands

### List all brands

```
GET /brand
```

**Response (201 Created):**

```json
[
  {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "name": "Brand 1",
        "created_at": "2023-01-01T12:00:00.000000Z",
        "updated_at": "2023-01-01T12:00:00.000000Z"
      },
      {
        "id": 2,
        "name": "Brand 2",
        "created_at": "2023-01-01T12:00:00.000000Z",
        "updated_at": "2023-01-01T12:00:00.000000Z"
      }
    ],
    "first_page_url": "http://your-domain.com/api/brand?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://your-domain.com/api/brand?page=1",
    "links": [...],
    "next_page_url": null,
    "path": "http://your-domain.com/api/brand",
    "per_page": 10,
    "prev_page_url": null,
    "to": 2,
    "total": 2
  }
]
```

### Get brand details

```
GET /brand/{id}
```

**Response (201 Created):**

```json
[
  {
    "id": 1,
    "name": "Brand 1",
    "created_at": "2023-01-01T12:00:00.000000Z",
    "updated_at": "2023-01-01T12:00:00.000000Z"
  }
]
```

**Error Response:**

```json
{
  "message": "Brand Not Found!"
}
```

### Create a new brand

```
POST /brand
```

**Request Body:**

```json
{
  "name": "New Brand"
}
```

**Response (201 Created):**

```json
{
  "message": "تم حفظ الماركة بنجاح",
  "brand": {
    "name": "New Brand",
    "updated_at": "2023-01-01T12:00:00.000000Z",
    "created_at": "2023-01-01T12:00:00.000000Z",
    "id": 3
  }
}
```

### Update a brand

```
PUT /brand/{id}
```

**Request Body:**

```json
{
  "name": "Updated Brand"
}
```

**Response (201 Created):**

```json
{
  "message": "Brand is updated"
}
```

### Delete a brand

```
DELETE /brand/{id}
```

**Response:**

```json
{
  "message": "Brand Deleted Successfully!"
}
```

## Orders

### List all orders

```
GET /order
```

**Response (200 OK):**

```json
{
  "orders": [
    {
      "id": 1,
      "user_id": 1,
      "location_id": 1,
      "total_price": 299.97,
      "date_of_delivery": "2023-01-10",
      "created_at": "2023-01-01T12:00:00.000000Z",
      "updated_at": "2023-01-01T12:00:00.000000Z",
      "user": {
        "id": 1,
        "name": "John Doe"
      },
      "items": [
        {
          "id": 1,
          "order_id": 1,
          "product_id": 1,
          "price": 99.99,
          "quantity": 3,
          "created_at": "2023-01-01T12:00:00.000000Z",
          "updated_at": "2023-01-01T12:00:00.000000Z",
          "product": {
            "id": 1,
            "product_name": "Product 1"
          }
        }
      ]
    }
  ]
}
```

### Get order details

```
GET /order/{id}
```

**Response (200 OK):**

```json
{
  "id": 1,
  "user_id": 1,
  "location_id": 1,
  "total_price": 299.97,
  "date_of_delivery": "2023-01-10",
  "created_at": "2023-01-01T12:00:00.000000Z",
  "updated_at": "2023-01-01T12:00:00.000000Z"
}
```

### Create a new order

```
POST /order
```

**Request Body:**

```json
{
  "total_price": 299.97,
  "date_of_delivery": "2023-01-10",
  "order_items": [
    {
      "product_id": 1,
      "price": 99.99,
      "quantity": 3
    }
  ]
}
```

**Response (200 OK):**

```json
{
  "message": "Order Created Successfully!"
}
```

### Get order items

```
GET /order/get_order_items/{id}
```

**Response (200 OK):**

```json
{
  "order_items": [
    {
      "id": 1,
      "order_id": 1,
      "product_id": 1,
      "price": 99.99,
      "quantity": 3,
      "created_at": "2023-01-01T12:00:00.000000Z",
      "updated_at": "2023-01-01T12:00:00.000000Z",
      "product_name": "Product 1"
    }
  ]
}
```

### Get user orders

```
GET /order/get_user_orders/{user_id}
```

**Response (200 OK):**

```json
{
  "orders": [
    {
      "id": 1,
      "user_id": 1,
      "location_id": 1,
      "total_price": 299.97,
      "date_of_delivery": "2023-01-10",
      "created_at": "2023-01-01T12:00:00.000000Z",
      "updated_at": "2023-01-01T12:00:00.000000Z"
    }
  ]
}
```

### Change order status

```
POST /order/change_order_status/{id}
```

**Request Body:**

```json
{
  "status": "delivered"
}
```

**Response (200 OK):**

```json
{
  "message": "Order Status Updated Successfully!"
}
```

## Locations

### List all locations

```
GET /location
```

**Response (200 OK):**

```json
[
  {
    "id": 1,
    "user_id": 1,
    "street": "123 Main St",
    "building": "Apt 4B",
    "area": "Downtown",
    "created_at": "2023-01-01T12:00:00.000000Z",
    "updated_at": "2023-01-01T12:00:00.000000Z"
  },
  {
    "id": 2,
    "user_id": 2,
    "street": "456 Oak Ave",
    "building": "Suite 101",
    "area": "Uptown",
    "created_at": "2023-01-01T12:00:00.000000Z",
    "updated_at": "2023-01-01T12:00:00.000000Z"
  }
]
```

### Create a new location

```
POST /location
```

**Request Body:**

```json
{
  "street": "789 Pine St",
  "building": "Building C",
  "area": "Midtown"
}
```

**Response (200 OK):**

```json
{
  "status": true,
  "message": "Location Saved Successfully!"
}
```

### Update a location

```
PUT /location/{id}
```

**Request Body:**

```json
{
  "street": "789 Pine St",
  "building": "Building D",
  "area": "Midtown"
}
```

**Response (200 OK):**

```json
{
  "status": true,
  "message": "Location Has Been Updated Successfully!"
}
```

### Delete a location

```
DELETE /location/{id}
```

**Response (200 OK):**

```json
{
  "message": "Location Has Been Deleted Successfully!"
}
```

## Error Handling

The API returns appropriate HTTP status codes for different types of errors:

- `200 OK` - The request was successful
- `201 Created` - The resource was successfully created
- `400 Bad Request` - The request was invalid or cannot be served
- `401 Unauthorized` - Authentication failed or user doesn't have permissions
- `404 Not Found` - The requested resource does not exist
- `422 Unprocessable Entity` - Validation errors
- `500 Internal Server Error` - Server error

## Rate Limiting

API requests are subject to rate limiting to prevent abuse. If you exceed the rate limit, you will receive a `429 Too Many Requests` response.

## Pagination

Endpoints that return collections of resources (like listing products, categories, etc.) support pagination. The response includes metadata about the pagination state.

## Data Models

### User
- id (integer)
- name (string)
- email (string)
- password (string, hashed)
- created_at (timestamp)
- updated_at (timestamp)

### Product
- id (integer)
- name (string)
- category_id (integer, foreign key)
- brand_id (integer, foreign key)
- price (decimal)
- amount (integer)
- discount (integer)
- image (string, file path)
- is_trendy (boolean)
- is_available (boolean)
- created_at (timestamp)
- updated_at (timestamp)

### Category
- id (integer)
- name (string)
- image (string, file path)
- created_at (timestamp)
- updated_at (timestamp)

### Brand
- id (integer)
- name (string)
- created_at (timestamp)
- updated_at (timestamp)

### Order
- id (integer)
- user_id (integer, foreign key)
- location_id (integer, foreign key)
- total_price (decimal)
- date_of_delivery (date)
- created_at (timestamp)
- updated_at (timestamp)

### OrderItem
- id (integer)
- order_id (integer, foreign key)
- product_id (integer, foreign key)
- price (decimal)
- quantity (integer)
- created_at (timestamp)
- updated_at (timestamp)

### Location
- id (integer)
- user_id (integer, foreign key)
- street (string)
- building (string)
- area (string)
- created_at (timestamp)
- updated_at (timestamp)
# EcommerceAPI


## Overview

EcommerceAPI is a robust RESTful API built with Laravel for e-commerce applications. It provides a comprehensive set of endpoints to manage products, categories, brands, orders, and user authentication, making it an ideal backend solution for e-commerce websites and mobile applications.

## Features

- **User Authentication** - Secure JWT-based authentication system
- **Product Management** - Create, read, update, and delete products with support for images
- **Category Management** - Organize products into categories
- **Brand Management** - Associate products with brands
- **Order Processing** - Complete order management system
- **Location Management** - Track delivery locations

## Requirements

- PHP ^8.1
- Composer
- MySQL or compatible database
- Laravel 10.x

## Installation

1. Clone the repository:
   ```bash
   git clone https://your-repository-url/EcommerceAPI.git
   cd EcommerceAPI
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Create and configure your environment file:
   ```bash
   cp .env.example .env
   ```
   Then update the `.env` file with your database credentials and other configuration settings.

4. Generate application key:
   ```bash
   php artisan key:generate
   ```

5. Generate JWT secret:
   ```bash
   php artisan jwt:secret
   ```

6. Run database migrations and seeders:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

7. Start the development server:
   ```bash
   php artisan serve
   ```

## API Documentation

Detailed API documentation is available in the [API_DOCUMENTATION.md](API_DOCUMENTATION.md) file. This documentation includes:

- Complete endpoint descriptions
- Request/response formats with JSON examples
- Authentication requirements and JWT token usage
- Error handling information
- Data models

### Available Endpoints

#### Authentication

- `POST /api/auth/register` - Register a new user
- `POST /api/auth/login` - Login and get JWT token
- `POST /api/auth/logout` - Logout and invalidate token
- `POST /api/auth/refresh` - Refresh JWT token
- `GET /api/auth/user-profile` - Get authenticated user details

#### Products

- `GET /api/product` - List all products
- `GET /api/product/{id}` - Get product details
- `POST /api/product` - Create a new product
- `POST /api/product/update/{id}` - Update a product
- `DELETE /api/product/{id}` - Delete a product

#### Categories

- `GET /api/category` - List all categories
- `GET /api/category/{id}` - Get category details
- `POST /api/category` - Create a new category
- `POST /api/category/update/{id}` - Update a category
- `DELETE /api/category/{id}` - Delete a category

#### Brands

- `GET /api/brand` - List all brands
- `GET /api/brand/{id}` - Get brand details
- `POST /api/brand` - Create a new brand
- `PUT /api/brand/{id}` - Update a brand
- `DELETE /api/brand/{id}` - Delete a brand

#### Orders

- `GET /api/order` - List all orders
- `GET /api/order/{id}` - Get order details
- `POST /api/order` - Create a new order
- `GET /api/order/get_order_items/{id}` - Get order items
- `GET /api/order/get_user_orders/{user_id}` - Get user orders
- `POST /api/order/change_order_status/{id}` - Update order status

#### Locations

- `GET /api/location` - List all locations
- `POST /api/location` - Create a new location
- `PUT /api/location/{id}` - Update a location
- `DELETE /api/location/{id}` - Delete a location

For complete details on request/response formats, authentication, and usage examples, please refer to the [API Documentation](API_DOCUMENTATION.md).

## Data Models

- **User** - Authentication and user information
- **Product** - Product details including name, price, availability, and images
- **Category** - Product categorization
- **Brand** - Product brand information
- **Order** - Order details including status and delivery information
- **OrderItem** - Individual items within an order
- **Location** - Delivery location information

## Security

This API uses JWT (JSON Web Tokens) for authentication. Protected routes require a valid token to be included in the request header.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Acknowledgments

- [Laravel](https://laravel.com) - The web framework used
- [JWT Auth](https://github.com/tymondesigns/jwt-auth) - For JWT authentication

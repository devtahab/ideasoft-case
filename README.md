## Requirements
- Docker
- Docker Compose

The Application has been developed and tested using MySQL.

## Installation

### Backend
```bash
    git clone https://github.com/devtahab/ideasoft-case.git
    cd ideasoft-case

    cp .env.example .env

    docker compose up -d
    
    docker compose exec -u sail laravel.test composer install

    docker compose exec -u sail laravel.test php artisan key:generate

    docker compose exec -u sail laravel.test php artisan migrate:fresh --seed
```

### Frontend
```bash
    cd frontend

    npm install

    npm run dev
```

## Technologies

- Laravel 13
- Vue 3
- Pinia
- MySQL
- Docker/Sail

## API Endpoints

```text
GET /api/products
GET /api/customers

POST /api/orders
POST /api/orders/preview

GET /api/customers/{id}/orders
```

## Design Decisions

```text
Order creation is wrapped in a database transaction.
Products are locked using lockForUpdate() before stock validation and stock update operations.

Discount rules are implemented through a common Discount interface.
New discount types can be added by creating a new class implementing the interface and registering it in DiscountService.

Orders contain a status field (pending).
This allows future extension of the order workflow such as payment, shipping and delivery states.
```

## Assumptions

```text
For category 2 products, the "buy 6 get 1 free" rule is applied per product.
If a customer buys 12 units of the same category 2 product, 2 units become free.

For category 1 products, "cheapest product gets the 20 percent discount" rule is applied on line total of the product who has the cheapest price.
```

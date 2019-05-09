# Laravel Tech Support Ticket module

## Requirements
* `php 7.1.3`
* `laravel 5.5`
* Worked queues

## Installation

```bash
composer require rochev/laravel-support-tickets
```

Next you must migrate your DB
```bash
php artisan migrate
```

## Assets (optional)
```bash
php artisan vendor:publish \
    --provider="Rochev\Laravel\SupportTickets\ServiceProvider" \
    --tag=config
```

## Cons of package
* JSON response crutch. CRUD of package use middleware `ForceJsonResponseMiddleware` for forcing JSON response on validation and exceptions.
* Hardcoded routes
* Non-unique command namespace (`tickets:`) and config (`tickets.`)
* Using `$fillable` field in `Ticket` model

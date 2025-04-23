# Job Board with Advanced Filtering

A Laravel 12 application for managing job listings with advanced filtering features similar to Airtable. The app supports dynamic attributes (EAV), complex filter logic, and relational filters.

## Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Database Schema](#database-schema)
- [API Documentation](#api-documentation)
  - [Endpoints](#endpoints)
  - [Filtering Syntax](#filtering-syntax)
  - [Filter Examples](#filter-examples)
- [Design Decisions](#design-decisions)
- [Code Structure](#code-structure)
- [Potential Improvements](#potential-improvements)

## Features

- Core Job model with standard fields and relationships
- Many-to-many relationships: Languages, Locations, and Categories
- EAV (Entity-Attribute-Value) model for dynamic job attributes
- Advanced filtering API supporting:
  - Basic fields (text, number, boolean, date)
  - Relationship filters (e.g. locations, languages)
  - Attribute filters (`attribute:name`)
  - Logical grouping (AND, OR)
  - Nested filters with parentheses

## Requirements

- PHP 8.2+
- Laravel 12.x
- MySQL 5.7+ or PostgreSQL 10+
- Composer

## Installation

```bash
git clone https://github.com/Eng-IslamMoh/job-board.git
cd job-board
composer install
cp .env.example .env
php artisan key:generate
```

Set your `.env` file:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=job_board
DB_USERNAME=root
DB_PASSWORD=
```

Then migrate and seed:

```bash
php artisan migrate
php artisan db:seed
php artisan serve
```

## Database Schema

### Core Tables

- `jobs`: Base job data
- `languages`, `locations`, `categories`: Related models
- `job_language`, `job_location`, `job_category`: Pivot tables

### EAV Tables

- `attributes`: Definitions
- `job_attribute_values`: Values per job

## API Documentation

### Postman Collection

**[**Postman Collection Link**](https://api.postman.com/collections/12381022-a71fcd0a-7954-48e0-80ef-217582dab705?access_key=PMAT-01JSHW1BX2C4KXE3SX00X57YK3)**

### Endpoints

#### GET `/api/jobs`

Returns paginated jobs based on filters.

**Query Parameters**:

- `filter`: A complex filter string.
- `per_page`: Optional (default: 15)

**Response** (via `GeneralApiResponse::handlePaginate()` and custom formatter):

```json
{
  "status": true,
  "statusCode": 200,
  "msg": "Jobs retrieved successfully",
  "data": {
    "data": [...],
    "next_page_url": "...",
    "prev_page_url": "...",
    "current_page": 1,
    "last_page": 5,
    "per_page": 15
  }
}
```

### Filtering Syntax

Supports nested, grouped and relational filters.

#### Examples:

- `job_type=full-time`
- `languages HAS_ANY (PHP,JavaScript)`
- `locations IS_ANY (New York,Remote)`
- `attribute:years_experience>=3`
- `(job_type=full-time AND (languages HAS_ANY (PHP,JavaScript))) AND (locations IS_ANY (New York,Remote)) AND attribute:years_experience>=3`

### Specific Column Filtering in Locations

By default, filtering by `locations` will search in the `state` column. However, you can specify a different column (`city`, `country`, or `state`) by using the syntax `locations.column`.

#### Examples

* **Default Behavior** : `locations=NY` (Searches in the `state` column)
* **Specific Column** :
* `locations.city=New York`
* `locations.state=NY`
* `locations.country=USA`
* **Advanced Filtering** :
* `locations.city HAS_ANY (New York,San Francisco)`
* `locations.country IS_ANY (USA,Canada)`

## Design Decisions

- Laravel 12 + EAV + expressive query syntax
- Recursive parser for nested filters
- Dedicated `FilterService` + `FilterParser`

## Code Structure

The project follows a modular and service-oriented structure for clean separation of concerns.

```
app/
├── Http/
│   ├── Controllers/
│   │   └── Api/
│   │       └── Job/
│   │           └── JobController.php        # Handles job-related API requests
│   ├── Requests/
│   │   └── Api/
│   │       └── Job/
│   │           ├── StoreJobRequest.php      # Validates data when storing jobs
│   │           └── UpdateJobRequest.php     # Validates data when updating jobs
│   └── Resources/
│       └── JobResource.php                  # Transforms job data for API response
├── Interfaces/
│   └── Api/
│       └── Job/
│           └── JobRepositoryInterface.php   # Defines the job repository contract
├── Repository/
│   └── Api/
│       └── Job/
│           └── JobRepository.php            # Implementation of job data access layer
└── Helpers/
    └── GeneralApiResponse.php              # Unified response format for all API endpoints
```

## Potential Improvements

- Filter caching
- Full-text search
- Rate limiting
- UI for building filters

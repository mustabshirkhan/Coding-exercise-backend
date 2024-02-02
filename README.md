# Finance App

This Laravel application manages transactions for a company, providing APIs for web and mobile interfaces. It includes
authentication, user roles (admin and customer), and features such as creating transactions, viewing transactions,
recording payments, and generating reports.

## Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [API Documentation](#api-documentation)
- [Contributing](#contributing)
- [License](#license)

## Features

- User authentication (email and password)
- Admin and customer roles
- Creating transactions
- Viewing transactions
- Recording payments
- Generating reports

## Requirements

- Docker

## Installation

1. Clone the repository:

   ```
    git clone https://github.com/mustabshirkhan/coding-exercise-backend.git
   ```

2. Start Project:

    ```
    cd coding-exercise-backend
    cp .env.example .env
    docker-compose up
    ```

3. Access Project:
    ```
    http://0.0.0.0:9000
    ```
4. Test Credentials:
    ```
    admin@example.com
   password
   
   customer1@example.com
   password
   ```

### License

This project is licensed under the [MIT license](https://opensource.org/licenses/MIT).

<h1 align="center"> 🕵🏾‍♂️ Spies Directory </h1>  <p align="center"> <a href="https://laravel.com/"><img src="https://img.shields.io/badge/Laravel-10-FF2D20.svg?style=flat&logo=laravel" alt="Laravel 10"/></a> <a href="https://www.php.net/"><img src="https://img.shields.io/badge/PHP-8.2-777BB4.svg?style=flat&logo=php" alt="PHP 8.2"/></a> </p>

## 📘 Introduction

This project is the implementation of the Backend Developer Coding Challenge by [Prosperty](https://www.theprosperty.com/), which is a directory of (famous) spies, by the candidate [George Chatzipavlou](https://github.com/saimpot).



Absolutely! Here's an expanded version of the sections you've highlighted:

----------

### 🖥️ Stack

**PHP**: The server-side scripting language that powers Laravel. Known for its versatility and strong community support.

**Nginx**: A high-performance web server software that is also used as a reverse proxy. It's known for its stability, simplicity, and efficient resource management.

**Laravel**: A PHP framework that facilitates quick development cycles and robust feature sets. Its expressive syntax emphasizes clarity and readability.

**MariaDB**: A reliable and fast relational database. It's a fork of MySQL and remains open-source, boasting optimizations and features beyond its predecessor.

**Redis**: An in-memory key-value store, used for caching and session storage. It helps speed up Laravel applications by providing a faster alternative to file or database-based caching.

### 💡Architecture - Why DDD?

For this project, I've chosen Domain-Driven Design (DDD). While it might seem overkill for a small project like this, DDD is a way to showcase Laravel and architectural expertise. Here's why:
-   **Modeling Complex Logic**: Even though this project isn't sprawling, DDD shines in modeling complex domain logic and business rules.
-   **Scalability**: Should the project ever grow, having a DDD structure makes it easier to scale and expand upon without running into as many 
architectural issues.
-   **Ubiquitous Language**: DDD encourages the use of a common language between developers and stakeholders. This means code reflects the business 
domain closely, leading to fewer misunderstandings.
-   **Separation of Concerns**: By separating the domain, application, and infrastructure layers, DDD promotes a clean architecture, where business 
logic is distinct from the framework and other concerns.


### 🤔 Why both App and Src folders exist

The existence of both `App` and `Src` directories serves a specific purpose:

-   `App` Folder: This folder typically contains boilerplate Laravel code and components that are tightly coupled to the Laravel framework. Things like HTTP controllers, service providers, and middleware usually reside here.

-   `Src` Folder: In the context of DDD, the `Src` directory contains the core domain logic of the application, segregated from any framework-specific implementations. Here, you'll find entities, value objects, and other domain-related logic, ensuring they remain decoupled from the Laravel framework.


Having this distinction enforces a cleaner separation between framework-specific code and the core business logic, allowing for easier testing and potential future transitions or rewrites.

### 🤔 Why Patterns?

**CQRS (Command Query Responsibility Segregation)**: Even for a small project, there are benefits to using CQRS:
-   **Separation of Concerns**: By segregating modification commands from read queries, it ensures that the read model can be optimized independently 
of the write model.
-   **Flexibility**: CQRS allows for separate scaling of the read and write parts of the application. If, in the future, the application needs to 
handle a high number of read operations but fewer write operations, the read model can be scaled without affecting the write model.
-   **Event Sourcing Compatibility**: CQRS pairs well with event sourcing. While not implemented here, if the project ever pivots in that direction, 
having CQRS already in place eases the transition.
-   **Improved Security**: With separate models for reading and writing, it becomes easier to add specific security measures for operations that 
modify data.

## 🗾 Setup

### Prerequisites:

1.  Ensure Docker is installed and running on your machine.
2.  Ensure you have `make` utility available.
3.  Postman (or a similar tool) for testing the API.

### Steps:

0. **Edit Hosts File** 🖊️:

    Open your `/etc/hosts` file with elevated privileges in your favorite editor (e.g. `sudo nano /etc/hosts`). Then add the following line to the 
   file:
    
    `127.0.0.1   spd.test`
    
    Save and close the editor (`Ctrl+X, followed by Y` in the case of nano. This ensures the application's domain resolves correctly in your local 
   environment.

1. **Clone the repository**:
   
    `cd ~/Projects`
    
    `git clone https://github.com/saimpot/spies-directory`

    `cd spies-directory`



2. **Generate SSL Certificates**: 

    `make create-certs`



3. **Build & Start Docker Containers**:

    Ensure no docker containers are running on the folder by using `docker-compose down`. Then run build `docker-compose build` and 
   `docker-compose up -d` to run the docker containers as a daemon.



4. **Set up the Project**:

    While the steps to make it work are numerous, I've created this simple command to take care of it for you: `make setup-project`



5. **API Token for Postman**: After the database seeding step during the setup, an API token will be generated. Copy this token and replace the `{{ token }}` variable in your Postman collection/environment with this token.


6. **Import postman**:
    
    Import postman collection located in the root of the project `prosperty-postman.json`


7. **Test**:

    Run the test suite to make sure everything is working: `make test`


8. **Enjoy!**:
    
    Open postman and hit the actual API. 

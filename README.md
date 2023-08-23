<h1 align="center"> 🕵🏾‍♂️ Spies Directory </h1>  <p align="center"> <a href="https://laravel.com/"><img src="https://img.shields.io/badge/Laravel-10-FF2D20.svg?style=flat&logo=laravel" alt="Laravel 10"/></a> <a href="https://www.php.net/"><img src="https://img.shields.io/badge/PHP-8.2-777BB4.svg?style=flat&logo=php" alt="PHP 8.2"/></a> </p>

## 📘 Introduction

This project is the implementation of the Backend Developer Coding Challenge by [Prosperty](https://www.theprosperty.com/), which is a directory of (famous) spies, by the candidate [George Chatzipavlou](https://github.com/saimpot).


----------

## 🖥️ Stack

**PHP**: The server-side scripting language that powers Laravel. Known for its versatility and strong community support.

**Nginx**: A high-performance web server software also used as a reverse proxy. It's known for its stability, simplicity, and efficient resource management.

**Laravel**: A PHP framework that facilitates quick development cycles and robust feature sets. Its expressive syntax emphasizes clarity and readability.

**MariaDB**: A reliable and fast relational database. It's a fork of MySQL and remains open-source, boasting optimizations and features beyond its predecessor.

**Redis**: An in-memory key-value store, used for caching and session storage. It helps speed up Laravel applications by providing a faster alternative to file or database-based caching.

## 💡Architecture

### Why DDD?

For this project, I've chosen Domain-Driven Design (DDD). While it might seem overkill for a small project like this, DDD is an excellent way to 
demonstrate the combination of Laravel and architectural design. Here's why:
-   **Modeling Complex Logic**: DDD shines in modeling complex domain logic and business rules, even if this project isn't extensive.
-   **Scalability**: If the project grows, a DDD structure facilitates easier scaling and expansion without many architectural challenges.
-   **Ubiquitous Language**: DDD encourages using a shared language between developers and stakeholders, meaning the code mirrors the business domain, leading to fewer misunderstandings.
-   **Separation of Concerns**: By separating the domain, application, and infrastructure layers, DDD promotes a clean architecture, where business 
logic is separated from the framework and other concerns.


### 🤔 Why both App and Src folders exist

The existence of both `App` and `Src` directories serves a specific purpose:

-   `App` Folder: Contains boilerplate Laravel code and components tightly coupled to the Laravel framework. Elements like HTTP controllers, service providers, and middleware typically reside here.

-   `Src` Folder: Folder: In the context of DDD, this directory houses the core domain logic of the application, keeping it separate from any 
    framework-specific implementations. You'll find entities, value objects, and other domain-related logic here. 

    - ⚠️ Although the purpose here is 
        for the domain to stay framework-agnostic, I've made an exception for this project because the domain is so small and the objective was to 
        write this in Laravel. Ideally, the domain would be framework-agnostic, and the framework-specific code would reside in the `App` folder. At 
        least, that's how I envision a DDD approach to a Laravel project.


Having this distinction enforces a cleaner separation between framework-specific code and the core business logic, allowing for easier testing and potential future transitions or rewrites.

### 🤔 Patterns

**CQRS (Command Query Responsibility Segregation)**: Even for a small project, there are benefits to using CQRS:
-   **Separation of Concerns**: By separating modification commands from read queries, the read model can be independently optimized from the write model.
-   **Flexibility**: CQRS allows the read and write parts of the application to scale separately. If the app needs to handle many read operations but fewer write operations in the future, the read model can be scaled without impacting the write model.
-   **Event Sourcing Compatibility**: CQRS pairs well with event sourcing. While not implemented here, if the project ever moves in that direction, 
having CQRS already in place simplifies the transition greatly and ensures a solid base for the developers to built onto.
-   **Improved Security**: With separate models for reading and writing, it becomes easier to add specific security measures for operations that 
modify data.

## 🗾 Setup

### Prerequisites:

1.  Ensure Docker is installed and running on your machine.
2.  Ensure you have `make` utility available.
3.  Postman (or a similar tool) for testing the API.

### Steps:

0. **Edit Hosts File** 🖊️:

    Open your `/etc/hosts` file with elevated permissions in your preferred editor (e.g. for nano `sudo nano /etc/hosts`, for vim `sudo vim 
   /etc/hosts`. Also friendly tip to avoid situations like [these](https://www.reddit.com/media?url=https%3A%2F%2Fi.redd.it%2Fauqmgt4b8zm11.png): 
   press `shift+q` and type `q!` and then hit enter! 😍). 

   Then add    the    following   line to the    file: `127.0.0.1   spd.test`
    
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



5. ~~**API Token for Postman**: After the database seeding step during the setup, an API token will be generated. Copy this token and replace the `{
   { token }}` variable in your Postman collection/environment with this token.~~

    **The setup command now does this automatically for you, so you don't have to worry about it!** 🎉


6. **Import postman**:
    
    - Import Postman environment file located in `root/storage/app/postman/postman_environment.json` to postman by clicking on `Environments` then on 
      the button labeled `Import` near `New`. 
    - Import Postman collection filed located in `root/storage/app/postman/postman_collection.json` to postman by click on `Collections` then on the 
      button labeled `Import` near `New`.
    - Use the new environment file by clicking on the eye icon near the environment name and selecting the new environment. Name is most likely 
      `Prosperty - Assignment`.
    - You should now have 1 (or more?) collection named `Prosperty - Spy directory` and 1 (or more?) environment named `Prosperty - Assignment`. 
      Hooray! 🎉


7. **Test**:

    Run the test suite to make sure everything is working: `make test`


8. **Enjoy!** 🍔:
    
    Open postman and hit the actual API. 

## 🚀 Future Enhancements

Given more time and resources, there are endless possibilities to improve and expand on this project. Here's a glimpse of what could be achieved:

### 💻 Coding/Software Engineering Perspective:

- Introduce a new domain bounded context called Postman and have a full postman API implementation to build, through postman's API, the 
  creation/import of the .json files for the collection, and really automate the whole process more than it's already been automated, with just 
  the use of an API key. 

- Refactoring and Optimization: While the current architecture is solid, with more time, the codebase could be further refined to ensure maximum 
efficiency and reduce potential technical debt.

- Microservices Architecture: To ensure scalability and better fault isolation, transitioning to a microservices architecture would be a logical 
next step. This would also enable easier continuous deployment and integration routines.

- Event Sourcing: Implementing an event-sourced architecture would provide a complete log of changes, enhancing traceability and enabling more 
advanced features like audit trails.

- AI & Machine Learning Integration: By integrating machine learning models, the application could make predictions, such as predicting the most 
likely next moves of spies based on historical data, or detecting suspicious patterns. But that would need a full rethink of the context of the 
  application, i.e. not being just a spy directory, which is actually a perfect segue into the next section...

🎮 Application Features and Gameplay:

- Spy Missions: Users could create and participate in virtual spy missions. Challenges could be set up where spies have to decrypt messages, solve 
mysteries, and navigate through a series of clues to complete their mission. And then the spies could be catalogued like this application is doing 
  right now. 

- Spy Ranking System: Depending on the success and efficiency of missions, spies could be ranked. This ranking could be displayed on a global 
leaderboard, driving user engagement and competitiveness.

- Spy Training Academy: A section dedicated to educating and training users on spy techniques, codes, and tactics. As they progress, they earn 
badges and certificates.

- Historical Spies: Introduce real-life famous spies from history, providing users with educational content and the chance to virtually 'meet' and 
'interact' with these legendary figures.

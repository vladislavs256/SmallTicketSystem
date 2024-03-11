<a name="readme-top"></a>



<!--
*** https://www.markdownguide.org/basic-syntax/#reference-style-links
-->
[![Contributors][contributors-shield]][contributors-url]
[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]
[![Issues][issues-shield]][issues-url]

[//]: # ([![LinkedIn][linkedin-shield]][linkedin-url])



<!-- PROJECT LOGO -->
<br />
<div align="center">
  <a href="https://github.com/vladislavs256/SmallTicketSystem">
    <img src="https://avatars.githubusercontent.com/u/45405871?s=400&u=6b3f9774b0dd21e79ca4fe7c2676208956f64350&v=4" alt="Logo" width="80" height="80">
  </a>

<h3 align="center">Ticket system</h3>

  <p align="center">
    Test task  
  </p>
</div>

![Screenshot_1](https://github.com/vladislavs256/TicketSystem/assets/45405871/24b46793-e589-4737-9766-cdc34cf7ce0b)


<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li><a href="#usage">Usage</a></li>
    <li><a href="#roadmap">Roadmap</a></li>
    <li><a href="#contact">Contact</a></li>
  </ol>
</details>



<!-- ABOUT THE PROJECT -->
## About The Project

https://github.com/vladislavs256/SmallTicketSystem/assets/45405871/9a416e13-47db-473b-bcc7-7e64fba407b6

# Create ticket system using Nginx, PHP 8, and Laravel 9+

## Mandatory Requirements:

- Data stored in an SQLite database. [Database file](data/database.sqlite)
- User registration via email and name. [Authorization Controllers](app/Http/Controllers/Auth)
- After registration, users can: 
    - View ticket history. [TicketController(view)](app/Http/Controllers/Ticket/TicketController.php)
    - Create new tickets. [TicketController(create)](app/Http/Controllers/Ticket/TicketController.php)
    - Comment on and close their open tickets. [TicketController(reopen)(close)](app/Http/Controllers/Ticket/TicketController.php)
- Administrator account with access to all tickets. [TicketService(IsAdmin)](app/Services/Ticket/TicketService.php)
- Tickets must include: [Create blade](resources/views/tickets/create.blade.php)
    - Type (selected from a list).
    - Text (HTML tags not allowed).
    - Status (new, in progress, closed).
- Validation of input data on client and server side.
- [Server validation](app/Http/Requests/)

## Additional Requirements:

- Attach up to 3 files to a ticket, with total size not exceeding 5 MB; files should be viewable and/or downloadable. [Server Validation](app/Http/Requests/Ticket/CreateRequest.php)
- Utilize Laravel migration for admin account.[Migration file](database/migrations/2014_10_12_000000_create_users_table.php)
  - Implement AJAX for adding/updating comments.[Blade(in script tag)](resources/views/tickets/view.blade.php)
- Allow administrator to manage ticket types (add, edit, delete).[Typecontroller](app/Http/Controllers/Ticket/TypeController.php) [Blade](resources/views/type)
- Enable sorting, filtering, and searching by any field in the list of tickets.[DataTable library](resources/views/tickets/index.blade.php)
- Allow leaving a comment or closing a ticket directly from the ticket table (if not closed).[Blade](resources/views/tickets/index.blade.php)
- Protect all forms from CSRF.





### Built With

* [![Laravel][Laravel.com]][Laravel-url]
* [![Bootstrap][Bootstrap.com]][Bootstrap-url]
* [![JQuery][JQuery.com]][JQuery-url]




<!-- GETTING STARTED -->
## Getting Started

### Prerequisites

You need install docker to launch this project if you don't have it
* docker
  ```sh
  sudo apt-get install docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin
  ```

### Installation

1. Clone the repo
   ```sh
   git clone https://github.com/vladislavs256/SmallTicketSystem.git
   ```
2. Use make init to launch docker containers
   ```sh
   make init 
   ```
   
 
 





<!-- USAGE EXAMPLES -->
## Usage

Server running on http://localhost:8080

Admin account is<br>
Email: admin@email.com <br>
Password: admin123





<!-- ROADMAP -->
## Roadmap

- [ ] Add functional tests
- [ ] Use vue js instead jquery
- [x] Edit layouts

See the [open issues](https://github.com/vladislavs256/SmallTicketSystem/issues) for a full list of proposed features (and known issues).




<!-- CONTACT -->
## Contact

Email - vladislavsKudrins@gmail.com <br>

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[contributors-shield]: https://img.shields.io/github/contributors/vladislavs256/SmallTicketSystem.svg?style=for-the-badge
[contributors-url]: https://github.com/vladislavs256/SmallTicketSystem/graphs/contributors
[forks-shield]: https://img.shields.io/github/forks/vladislavs256/SmallTicketSystem.svg?style=for-the-badge
[forks-url]: https://github.com/vladislavs256/SmallTicketSystem/network/members
[stars-shield]: https://img.shields.io/github/stars/vladislavs256/SmallTicketSystem.svg?style=for-the-badge
[stars-url]: https://github.com/vladislavs256/SmallTicketSystem/stargazers
[issues-shield]: https://img.shields.io/github/issues/vladislavs256/SmallTicketSystem.svg?style=for-the-badge
[issues-url]: https://github.com/vladislavs256/SmallTicketSystem/issues
[license-shield]: https://img.shields.io/github/license/vladislavs256/SmallTicketSystem.svg?style=for-the-badge
[license-url]: https://github.com/vladislavs256/SmallTicketSystem/blob/master/LICENSE.txt
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://linkedin.com/in/linkedin_username
[product-screenshot]: images/screenshot.png
[Laravel.com]: https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white
[Laravel-url]: https://laravel.com
[Bootstrap.com]: https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white
[Bootstrap-url]: https://getbootstrap.com
[JQuery.com]: https://img.shields.io/badge/jQuery-0769AD?style=for-the-badge&logo=jquery&logoColor=white
[JQuery-url]: https://jquery.com





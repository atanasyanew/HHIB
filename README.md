
HHIB WEB MANAGEMENT <a href="http://www.hhi-co.bg/en"><img src="docs/logo.svg" title="Logo" align="right" height="30" /></a> 
======
<!-- 
[![Demo](https://img.shields.io/badge/Demo-Online-green.svg?style=for-the-badge)](http://hhib.azurewebsites.net/) -->


### Description
Content management system for "Tap Changers" devision. 
The application is designed to store information, files and monitoring the process for creating internal company orders and offers. Аpplication has features like: file upload, role based users, order and offers progress tracking, approval statuses, reports and MS Excel integration.

More information and futures available in [User guide](https://github.com/atanasyanew/HHIB/tree/master/docs/Instruction_web_management.pdf)

### Installation
The application is containerized with Docker
```
docker-compose build
docker-compose up
```

- Application url:  **http://localhost:8002**, credentials: 
	- username: **admin**
	- password: **admin**

- phpMyAdmin **http://localhost:8000**, credentials:
	- username: **user**
	- password: **test**

### Screenshots

![HHIB](docs/screenshots/hhib-01.png "Orders table")

![HHIB](docs/screenshots/hhib-02.png "Offers table")

![HHIB](docs/screenshots/hhib-03.png "Reports")

![HHIB](docs/screenshots/hhib-04.png "Profile panel")

![HHIB](docs/screenshots/hhib-09.png "Order")
![HHIB](docs/screenshots/hhib-10.png "Order")
![HHIB](docs/screenshots/hhib-11.png "Order")

![HHIB](docs/screenshots/hhib-15.png "Offer")
![HHIB](docs/screenshots/hhib-16.png "Offer")






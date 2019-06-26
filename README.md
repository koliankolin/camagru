# Application like Instagram and Snapchat

The main idea is to repeat functionality of Intagram and Snapchat

## Install application

1. Install docker-environment:
        
        docker-compose up --build -d

2. Install tables for database:

        http://ip-your-docker-machine:8080/config/setup.php

3. phpMyAdmin is available on 8001 port

4. Application is started on 8080 port for http and on 8001 for https


#### Already done:

* Login, Logout, Sign Up, Change email, password, etc.
* Ability to drag and drop picture on steam of web-camera
* Save pictures on profile and locally
* Ability to add likes and comments
* Users' profiles

#### TODO:

* Refactor code with MVC pattern and with using MVC-framework
# Learn By Tests
This project is the MVP version. This is a simple application that allows you to create closed tests.
Currently, it has database with tests for the Polish Yacht Sea Helmsman exam.

The application can be found at https://learnbytests.vxm.pl, after registration, please write me an e-mail at: p.czyzewski5@gmail.com to activate your account.

## Local environment requirements
Console, docker, docker-compose, make, internet.

## How to launch on the local environment
1. navigate to project dir in console
2. execute `make start`
3. answer `yes` on migration prompt<br/>![migration prompt](public/images/migration_prompt.jpg)
4. when console is ready execute `docker-compose ps`
5. locate port near nginx container (e.g: 8080)<br/>![docker-compose ps](public/images/docker_compose_ps.jpg "San Juan Mountains")
6. navigate to localhost with found port e.g `localhost:8080`
7. login with login `example@test.com` and password `Pass123@`
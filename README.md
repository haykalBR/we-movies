# We Movies Application
A We Movie for DDD applications using Symfony as framework and running with PHP 8.
## Implementations
- [x] Environment in Docker
- [x] Rest API
- [x] Web UI 
- [x] Swagger API Doc
- ## Stack
- PHP 8.1
- mariadb:10.10.2
- Redis
- javaScript
## Use Cases

#### User
- [x] Sign in
- [x] Logout
- Login : admin@symfony.com , password:admin

![Login page ](https://i.imgur.com/ps2S13U.png)
#### Movies
- [x] Get List movie By genere 
- [x] Search Movie
- [x] show detail of Movie

![API Doc](https://i.imgur.com/hKzjDTZ.png)
![List Movies ](https://i.imgur.com/eQiCwKv.png)
![List Movies ](https://i.imgur.com/Fdv5Smd.png)

## Project Setup

|    Action        	| Command            |
|------------------	|--------------------|
|  Setup 	          | ` make install`    |
|  Static Analisys 	| `make analyse`  	  |
|  Code Style      	| `make phpcs`     	 |

### Add in .env TOKEN_TMDB=TON KEY

##  Open http://localhost in your favorite web browser


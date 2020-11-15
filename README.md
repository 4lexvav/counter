### To start counter app

#### Build container from source
1. `git clone git@github.com:4lexvav/counter`
1. `cd counter`
1. `docker build -t counter .`
1. `docker run -p 8080:80 counter`
1. open http://localhost:8080

#### Or just run docker image:
1. `docker run -p 8080:80 4lexvav/counter:v1.0.2`
1. open http://localhost:8080

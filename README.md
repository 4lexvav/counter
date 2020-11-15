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

#### Example:

![Screenshot](https://www.dropbox.com/s/z671zwwh09a0owt/screen%202020-11-15%20at%2020.13.15.png?raw=1)
**Hits count** - shows the total number of non-unique openings of web-service pages.

**Unique website users** - total number of unique website users.

**Online users on this page** - total number of unique users located at this page at the moment, - this counter decrementing after leaving the page.

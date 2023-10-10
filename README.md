# ESA Mobile App

This app was originally developed by Ben Greiner for the 2017 ESA European Meeting in Vienna. And it was adapted to ESA Bologna and further developed by Ali Seyhun Saral. 

It was then adapted to ESA World Meeting in Lyon by Béatrice Montbroussous and Quentin Thevenet.

It was further adapted and Dockerised for the ESA Meeting in Exeter by Scott Vincent. We express our gratitude for making the source code available for our event.

## Database
This application uses a MySQL database. There are 2 files to get you started:

`esa2023AOO-Database.sql`  This creates the empty tables needed for the app
`docs/add_exeter_data.sql`  This creates the base data, such as the dates and the joint events

## Config
You will need to create a file called ".env" in the root folder of the Docker container with the following values populated:

```
ESA_MYSQL_HOST=''
ESA_MYSQL_DB=''
ESA_MYSQL_USERNAME=''
ESA_MYSQL_PASSWORD=''

ESA_PORT=''

ESA_MAIL_USERNAME=''
ESA_MAIL_PASSWORD=''
ESA_MAIL_HOSTNAME=''
ESA_MAIL_PORT=''
```

Most are obvious, but the `ESA_PORT` is the port number that the Docker contianer maps onto the Apache port 80 inside the container.

## Email
We were sending the outgoing emails through our cloud Exchange server - see the file `requestlink.php`

## Running
There are `Dockerfile` and `docker-compose.yaml` files in the root folder that can be used to easily spin this up in a Docker container. The container exposes the app on port `ESA_PORT`.

**Note** There is a README.md with some notes that I used when bulding and testing this locally on my machine

## Notes for Exeter dev

### Running locally on PC through apache:

`sudo /etc/init.d/apache2 restart`

To change the port it runs on:

`sudo vi /etc/apache2/ports.conf`

Export the database params in the file `/etc/apache2/envvars`

Then load the database with:

`mysql --host=$ESA_MYSQL_HOST -p -u $ESA_MYSQL_USERNAME $ESA_MYSQL_DB < esa2023APP-Database.sql`
`mysql --host=$ESA_MYSQL_HOST -p -u $ESA_MYSQL_USERNAME $ESA_MYSQL_DB < docs/add_exeter_data.sql`

Run this is see where the apache app is looking for php ini files:

`php --ini`


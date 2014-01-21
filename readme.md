## FusionInvoice

FusionInvoice is built for freelancers and small businesses who need a simple, 
yet powerful self-hosted web based invoicing system.

### Notice

This project is currently being migrated from CodeIgniter, and should not be 
used in production until an official release is ready. For those interested, 
you can keep tabs on the development activity by switching to the develop 
branch.

### Installation

1. Clone the repository:

	$ git clone -b develop https://github.com/jesseterry/FusionInvoice.git

2. Install the dependencies via Composer (from inside the cloned directory):

	$ composer install

3. Make sure the app/storage folder and all contents are writable by your web server.

4. Create an empty database and modify the database settings in 
app/config/database.php to match your environment.

5. Visit /setup in your browser to continue the installation. Do not use artisan at
the command line to migrate your database - the /setup module will take care of
that for you.

Please report your findings to either the github issue tracker or in the 
[Community Support Forums](https://groups.google.com/forum/#!forum/fusioninvoice-community-support).
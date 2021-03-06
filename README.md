![gif of project in action](https://github.com/JanisLeja96/VirtualWallet/blob/master/VirtualWallet.gif)

# Virtual Wallet

This is a basic virtual wallet web application. Unit and feature tests are included.
  
## Running the project

- In order to run the project, clone this repository, configure your `.env` file and install all dependencies using

`php composer install`

`npm install`

- Then you'll need to create the necessary database using

`php artisan mysql:createdb {db_name}`

**Note: If {db_name} is not specified, the default name (virtualwallet) will be used.**

- Afterwards you need to run database migrations using  

`php artisan migrate`

- Finally you can run the project using  

`php artisan serve` 

## Things to improve  

### Error handling when creating a new transaction  

Errors are being handled by Transaction controller. I would like to delegate this process to another class.

### Transaction "deleting"/hiding

When a user deletes a transaction, their ID is put into the "hidden_for" field of the Transaction entry.
I would like to figure out a better way of doing this.

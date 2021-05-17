# Pure PHP REST API

A simple REST API builded using only php and [phpunit](https://phpunit.de/) for testing.

## Running the project

Enter the `web` folder and run:

```bash
$ php -S localhost:<PORT>
```

where `<PORT>` is your favorite HTTP port.

You can use this [request collection](./Insominia_2021-05-16.yaml) to run the queries in Insomnia.

## Routes

### Users

#### /users GET - List Users

##### Response example

- 200 OK
```json
{
  "data": [
    {
      "firstName": "Silva",
      "lastName": "Esron",
      "email": "silva.esron@gmail.com",
      "phone": "87900000000"
    },
    {
      "firstName": "Alan",
      "lastName": "Turing",
      "email": "alan.turing@cam.ac.uk",
      "phone": "07911123456"
    },
    {
      "firstName": "Ada",
      "lastName": "Lovelace",
      "email": "ada.lovelace@london.ac.uk",
      "phone": "07966654321"
    },
    {
      "firstName": "Esron",
      "lastName": "Silva",
      "email": "esron.dtamar@gmail.com",
      "phone": "74900000000"
    }
  ]
}
```

#### /users POST - Create User

##### Request body example

```json
{
	"firstName": "Esron",
	"lastName": "Silva",
	"email": "esron.dtamar@gmail.com",
	"phone": "74991166571"
}
```

##### Response example

- 200 - OK
```json
{
  "data": {
    "firstName": "Esron",
    "lastName": "Silva",
    "email": "esron.dtamar@gmail.com",
    "phone": "74991166571"
  }
}
```

#### /users PUT - Update User

##### Query params

- email - an user email

##### Request body example

```json
{
	"firstName": "Esron",
	"lastName": "Silva",
	"email": "esron.dtamar@gmail.com",
	"phone": "74991166571"
}
```

##### Response example

- 200 - OK
```json
{
  "data": {
    "firstName": "Esron",
    "lastName": "Silva",
    "email": "esron.dtamar@gmail.com",
    "phone": "74991166571"
  }
}
```

#### /users PUT - Update User

##### Query params

- email - an user email

##### Request body example

```json
{
	"firstName": "Esron",
	"lastName": "Silva",
	"email": "esron.dtamar@gmail.com",
	"phone": "74991166571"
}
```

##### Response example

- 200 - OK
```json
{
  "data": {
    "firstName": "Esron",
    "lastName": "Silva",
    "email": "esron.dtamar@gmail.com",
    "phone": "74991166571"
  }
}
```

#### /users DELETE - Delete user

##### Query params

- email - an user email

##### Response example

- 200 - OK
```json
{
  "data": {
    "message": "User deleted"
  }
}
```

- 422 - Already deleted
```json
{
  "errors": {
    "email": "User with email esron.dtamar@gmail.com not found"
  }
}
```

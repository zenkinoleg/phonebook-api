#	Phonebook simple API

## Lumen PHP Framework Based

## Author Zenkin Oleg <zenkin.oleg.dev@gmail.com>

## Instalation

 - Install
 - Run migration
 - Run seeders
 - Use any user to get token
 - Use token to proceed with Phonebook calls

## Usage

description: Get user's token
method: POST
url: /login
data: email - string|required, password - string|required

description: Get either all records from phonebook or from specific page if noted
method: GET
url: /phonebook/{id}
params: id - integer|oprional, page - integer|oprional
examples: /phonebook, /phonebook/11, /phonebook?page=2

description: Add new or Update existing record of phonebook
method: POST
url: /phonebook/{id}
data: first_name - string|required, last_name - string|required, phone_number - required, country - string|required, timezone - string|required
examples: /phonebook, /phonebook/11

description: Delete existing record of phonebook
method: DELETE
url: /phonebook/id
params: id - integer|required

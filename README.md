# php-backend-study
 estudo laravel


# Json para postman

{
	"info": {
		"_postman_id": "7a183b77-05f2-4307-9dc6-c250cc91ad8c",
		"name": "Estudo PokemÃ£o",
		"schema": "https://schema.getpostman.com/json/collection/v2.0.0/collection.json",
		"_exporter_id": "40840367"
	},
	"item": [
		{
			"name": "consultar pokemon",
			"request": {
				"method": "POST",
				"header": [
					{
						"key": "X-CSRF-TOKEN",
						"value": "{{token}}",
						"type": "text"
					}
				],
				"body": {
					"mode": "raw",
					"raw": "{\r\n    \"name\": \"palkia\"\r\n}",
					"options": {
						"raw": {
							"language": "json"
						}
					}
				},
				"url": "{{root}}api/pokemon"
			},
			"response": []
		},
		{
			"name": "cadastrar pokemon",
			"request": {
				"method": "POST",
				"header": [
					{
						"key": "X-CSRF-TOKEN",
						"value": "{{token}}",
						"type": "text"
					}
				],
				"body": {
					"mode": "raw",
					"raw": "{\r\n    \"name\": \"palkia\"\r\n}",
					"options": {
						"raw": {
							"language": "json"
						}
					}
				},
				"url": "{{root}}api/pokemon/add_to_collection"
			},
			"response": []
		},
		{
			"name": "Quais pokemons nÃ£o possuo",
			"request": {
				"method": "GET",
				"header": [
					{
						"key": "X-CSRF-TOKEN",
						"value": "{{token}}",
						"type": "text"
					}
				],
				"url": "{{root}}api/pokemon/check"
			},
			"response": []
		},
		{
			"name": "register",
			"request": {
				"method": "POST",
				"header": [],
				"body": {
					"mode": "raw",
					"raw": "{\r\n    \"name\": \"John Doe\",\r\n    \"email\": \"john@example.com\",\r\n    \"password\": \"secret\"\r\n}",
					"options": {
						"raw": {
							"language": "json"
						}
					}
				},
				"url": "{{root}}credentials/register"
			},
			"response": []
		},
		{
			"name": "login",
			"request": {
				"method": "POST",
				"header": [],
				"body": {
					"mode": "raw",
					"raw": "{    \r\n    \"email\": \"john@example.com\",\r\n    \"password\": \"secret\"\r\n}",
					"options": {
						"raw": {
							"language": "json"
						}
					}
				},
				"url": "{{root}}credentials/login"
			},
			"response": []
		}
	]
}
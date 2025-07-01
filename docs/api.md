### API LOGIN
```
curl --location 'http://localhost:8000/api/auth/login' \
--header 'Content-Type: application/json' \
--data-raw '{
  "email": "nguyen.thanh.hoa.ctec@gmail.com",
  "password": "12345678"
}'
```
Response result:
```
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL2F1dGgvbG9naW4iLCJpYXQiOjE3NTEyNDg1MDEsImV4cCI6MTc1MTI1MjEwMSwibmJmIjoxNzUxMjQ4NTAxLCJqdGkiOiJKOFFJV25hS1RsN3JTY1dvIiwic3ViIjoiMTgiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.Xjt9z1v5uS4HUpw95whlZP-Rl98iDFxQrOXoK_mQJyU",
    "token_type": "bearer",
    "expires_in": 3600
}
```

### API REGISTER
```
curl --location 'http://localhost:8000/api/auth/register' \
--header 'Content-Type: application/json' \
--data-raw '{
  "name": "Hoa Code",
  "email": "hoacode123@example.com",
  "password": "12345678"
}'
```

Response result:
```
{
    "user": {
        "name": "Hoa Code",
        "email": "hoacode123@example.com",
        "updated_at": "2025-06-30T01:57:37.000000Z",
        "created_at": "2025-06-30T01:57:37.000000Z",
        "id": 62
    },
    "status": "success",
    "authorization": {
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL2F1dGgvcmVnaXN0ZXIiLCJpYXQiOjE3NTEyNDg2NTcsImV4cCI6MTc1MTI1MjI1NywibmJmIjoxNzUxMjQ4NjU3LCJqdGkiOiIwTTB2eTg1dDVkUGdGQTZMIiwic3ViIjoiNjIiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.Vgee6Svf183ALR1QUlYlRvkyXxsaSxgASf7fI1VxQSE",
        "type": "bearer"
    }
}
```

### GET USER FROM TOKEN
```
curl --location --request POST 'http://localhost:8000/api/auth/me' \
--header 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL2F1dGgvbG9naW4iLCJpYXQiOjE3NTEyNDg1MDEsImV4cCI6MTc1MTI1MjEwMSwibmJmIjoxNzUxMjQ4NTAxLCJqdGkiOiJKOFFJV25hS1RsN3JTY1dvIiwic3ViIjoiMTgiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.Xjt9z1v5uS4HUpw95whlZP-Rl98iDFxQrOXoK_mQJyU'
```

Response result:
```
{
    "id": 18,
    "name": "Hoa Nguyen Coder",
    "email": "nguyen.thanh.hoa.ctec@gmail.com",
    "avatar": null,
    "status": 1,
    "email_verified_at": null,
    "created_at": "2025-04-17T01:51:21.000000Z",
    "updated_at": "2025-04-17T01:51:21.000000Z"
}
```

### API CATEGORY
```
curl --location 'http://laravel.test/api/v1/categories'
```

Response result:
```
{
    "status": 1,
    "data": [
        {
            "id": 1,
            "title": "Toyota",
            "slug": "toyota",
            "image": null,
            "category_id": null,
            "created_at": "2025-06-10T03:00:48.000000Z",
            "updated_at": "2025-06-10T03:00:48.000000Z",
            "children": [
                {
                    "id": 2,
                    "title": "Camry",
                    "slug": "camry",
                    "image": null,
                    "category_id": 1,
                    "created_at": "2025-06-10T03:00:48.000000Z",
                    "updated_at": "2025-06-10T03:00:48.000000Z"
                },
                {
                    "id": 3,
                    "title": "Corolla",
                    "slug": "corolla",
                    "image": null,
                    "category_id": 1,
                    "created_at": "2025-06-10T03:00:48.000000Z",
                    "updated_at": "2025-06-10T03:00:48.000000Z"
                }
            ]
        },
    ]
}
```

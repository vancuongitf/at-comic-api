#AT ANDROID COMIC API DOCUMENT

## Base URL: https://at-android-comic.000webhostapp.com/

## UPLOAD

### Upload image: api/v1/upload/image/

#### Method: POST

#### Params:

|Param|Type|Max Length|Note|Require|
|---|---|---|---|---|
|image|File||Mutil Part|Yes|

#### Result:

```
{
    "image_name": "15368982157977fixed.png"
}

```

## USER

### 1. Sign Up: api/v1/user/signup/signup.php

#### Method: POST

#### Params:

|Param|Type|Max Length|Note|Require|
|---|---|---|---|---|
|email|String|300||Yes|
|password|String|300|Encrypt with SHA256 before|Yes|
|avatar|String|100|Result from api upload image|No|

#### Result:
```
{
    "message": "Tạo tài khoản thành công."
}
```

### 2. Login: api/v1/user/login/login.php

#### Method: POST

|Param|Type|Max Length|Note|Require|
|---|---|---|---|---|
|email|String|300||Yes|
|password|String|300|Encrypt with SHA256 before|Yes|

### Result

```
{
    "access_token": "ff10e81b0021496a2f2b230e448abf41f05994ddbfca1a97997cfd22a8b329a0"
}

```

## COMIC

### 1. Home: api/v1/comic/home/home.php

#### Method: GET

|Param|Type|Max Length|Default|Note|Require|
|---|---|---|---|---|---|
|access-token|String|||Header|Yes|
|page|Interge||1|Page to load|No|

#### Result - Max 50 comics each page.
```
{
    "next_page_flag": false,
    "result": [
        {
            "id": 1,
            "name": "Conan",
            "description": "Tóm tắt câu chuyện.",
            "author": "Gosho Aoyama",
            "view_count": 0,
            "like_count": 0,
            "image": "http://st.thichtruyentranh.com/images/icon/0004/conan1416865530.jpg"
        }
    ]
}
```

### 2. Comic Detail: api/v1/comic/detail/detail.php

#### Method: GET

|Param|Type|Max Length|Default|Note|Require|
|---|---|---|---|---|---|
|access-token|String|||Header|Yes|
|id|Interge|||Id of target comic|Yes|

#### Result:

```
{
    "id": 1,
    "name": "Conan",
    "description": "Tóm tắt câu chuyện.",
    "author": "Gosho Aoyama",
    "view_count": 0,
    "like_count": 0,
    "image": "http://st.thichtruyentranh.com/images/icon/0004/conan1416865530.jpg"
}
```

### 3. Comic Chapter List: api/v1/comic/chapter/chapters.php

#### Method: GET

|Param|Type|Max Length|Default|Note|Require|
|---|---|---|---|---|---|
|access-token|String|||Header|Yes|
|id|Interge|||Id of target comic|Yes|
|page|Interge||1|Page to load|No|

#### Result
```
{
    "next_page_flag": false,
    "result": [
        {
            "id": 1,
            "comic_id": 1,
            "name": "Mở đầu",
            "position": 1,
            "viewcount": 0,
            "image": ""
        }
    ]
}
```

### 4. Chapter content: api/v1/comic/chapter/detail/detail.php

#### Method: GET

|Param|Type|Max Length|Default|Note|Require|
|---|---|---|---|---|---|
|access-token|String|||Header|Yes|
|id|Interge|||Id of target chapter|Yes|

#### Result

```
{
    "result": [
        {
            "id": 1,
            "position": 1,
            "image": "http://uptruyen.com/stream/cloud_link/0000/0000/0000/493/0000/0000/0565/5659715.006.jpg"
        }
    ]
}
```

### 5. Comic star: api/v1/comic/favorite/star.php

#### Method: POST

|Param|Type|Max Length|Note|Require|
|---|---|---|---|---|
|access-token|String||Header|Yes|
|id|Interge||Id of target comic|Yes|


#### Result

```
{
    "success": true
}
```

### 6. Comic Unstar: api/v1/comic/favorite/unstar.php

#### Method: POST

|Param|Type|Max Length|Note|Require|
|---|---|---|---|---|
|access-token|String||Header|Yes|
|id|Interge||Id of target comic|Yes|


#### Result

```
{
    "success": true
}
```

## API EXCEPTION

### Normal Error
#### Status code: 400 BAD REQUEST
#### Model:

```
{
    "code": 678,
    "message": "Thiếu dữ liệu."
}
```

### UnAuthorizion
#### Status code: 401 UNAUTHORIZED
#### Model:
```
{
    "code": 401,
    "message": "Phiên đăng nhập đã hết hạn. Vui lòng đăng nhập lại để tiếp tục."
}
```

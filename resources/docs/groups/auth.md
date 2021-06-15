# Auth


## Register New User




> Example request:

```javascript
const url = new URL(
    "http://localhost:3541/api/register"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "first_name": "consequatur",
    "last_name": "consequatur",
    "email": "qkunze@example.com",
    "username": "consequatur",
    "password": "consequatur",
    "password_confirmation": "consequatur"
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost:3541/api/register',
    [
        'headers' => [
            'Accept' => 'application/json',
        ],
        'json' => [
            'first_name' => 'consequatur',
            'last_name' => 'consequatur',
            'email' => 'qkunze@example.com',
            'username' => 'consequatur',
            'password' => 'consequatur',
            'password_confirmation' => 'consequatur',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost:3541/api/register'
payload = {
    "first_name": "consequatur",
    "last_name": "consequatur",
    "email": "qkunze@example.com",
    "username": "consequatur",
    "password": "consequatur",
    "password_confirmation": "consequatur"
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```

```bash
curl -X POST \
    "http://localhost:3541/api/register" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"first_name":"consequatur","last_name":"consequatur","email":"qkunze@example.com","username":"consequatur","password":"consequatur","password_confirmation":"consequatur"}'

```


<div id="execution-results-POSTapi-register" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-register"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-register"></code></pre>
</div>
<div id="execution-error-POSTapi-register" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-register"></code></pre>
</div>
<form id="form-POSTapi-register" data-method="POST" data-path="api/register" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-register', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-register" onclick="tryItOut('POSTapi-register');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-register" onclick="cancelTryOut('POSTapi-register');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-register" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/register</code></b>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>first_name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="first_name" data-endpoint="POSTapi-register" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>last_name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="last_name" data-endpoint="POSTapi-register" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>email</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="email" data-endpoint="POSTapi-register" data-component="body" required  hidden>
<br>
The value must be a valid email address.
</p>
<p>
<b><code>username</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="username" data-endpoint="POSTapi-register" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>password</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="password" name="password" data-endpoint="POSTapi-register" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>password_confirmation</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="password" name="password_confirmation" data-endpoint="POSTapi-register" data-component="body" required  hidden>
<br>

</p>

</form>


## Login




> Example request:

```javascript
const url = new URL(
    "http://localhost:3541/api/login"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "qkunze@example.com",
    "password": "consequatur"
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost:3541/api/login',
    [
        'headers' => [
            'Accept' => 'application/json',
        ],
        'json' => [
            'email' => 'qkunze@example.com',
            'password' => 'consequatur',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost:3541/api/login'
payload = {
    "email": "qkunze@example.com",
    "password": "consequatur"
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```

```bash
curl -X POST \
    "http://localhost:3541/api/login" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"qkunze@example.com","password":"consequatur"}'

```


<div id="execution-results-POSTapi-login" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-login"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-login"></code></pre>
</div>
<div id="execution-error-POSTapi-login" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-login"></code></pre>
</div>
<form id="form-POSTapi-login" data-method="POST" data-path="api/login" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-login', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-login" onclick="tryItOut('POSTapi-login');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-login" onclick="cancelTryOut('POSTapi-login');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-login" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/login</code></b>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>email</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="email" data-endpoint="POSTapi-login" data-component="body" required  hidden>
<br>
The value must be a valid email address.
</p>
<p>
<b><code>password</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="password" name="password" data-endpoint="POSTapi-login" data-component="body" required  hidden>
<br>

</p>

</form>


## Ask Email Verification Otp




> Example request:

```javascript
const url = new URL(
    "http://localhost:3541/api/get_email_verify_token"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "qkunze@example.com"
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost:3541/api/get_email_verify_token',
    [
        'headers' => [
            'Accept' => 'application/json',
        ],
        'json' => [
            'email' => 'qkunze@example.com',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost:3541/api/get_email_verify_token'
payload = {
    "email": "qkunze@example.com"
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```

```bash
curl -X POST \
    "http://localhost:3541/api/get_email_verify_token" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"qkunze@example.com"}'

```


<div id="execution-results-POSTapi-get_email_verify_token" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-get_email_verify_token"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-get_email_verify_token"></code></pre>
</div>
<div id="execution-error-POSTapi-get_email_verify_token" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-get_email_verify_token"></code></pre>
</div>
<form id="form-POSTapi-get_email_verify_token" data-method="POST" data-path="api/get_email_verify_token" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-get_email_verify_token', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-get_email_verify_token" onclick="tryItOut('POSTapi-get_email_verify_token');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-get_email_verify_token" onclick="cancelTryOut('POSTapi-get_email_verify_token');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-get_email_verify_token" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/get_email_verify_token</code></b>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>email</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="email" data-endpoint="POSTapi-get_email_verify_token" data-component="body" required  hidden>
<br>
The value must be a valid email address.
</p>

</form>


## Activate Email




> Example request:

```javascript
const url = new URL(
    "http://localhost:3541/api/verify_email_token"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "qkunze@example.com",
    "otp": "consequatur"
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost:3541/api/verify_email_token',
    [
        'headers' => [
            'Accept' => 'application/json',
        ],
        'json' => [
            'email' => 'qkunze@example.com',
            'otp' => 'consequatur',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost:3541/api/verify_email_token'
payload = {
    "email": "qkunze@example.com",
    "otp": "consequatur"
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```

```bash
curl -X POST \
    "http://localhost:3541/api/verify_email_token" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"qkunze@example.com","otp":"consequatur"}'

```


<div id="execution-results-POSTapi-verify_email_token" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-verify_email_token"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-verify_email_token"></code></pre>
</div>
<div id="execution-error-POSTapi-verify_email_token" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-verify_email_token"></code></pre>
</div>
<form id="form-POSTapi-verify_email_token" data-method="POST" data-path="api/verify_email_token" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-verify_email_token', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-verify_email_token" onclick="tryItOut('POSTapi-verify_email_token');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-verify_email_token" onclick="cancelTryOut('POSTapi-verify_email_token');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-verify_email_token" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/verify_email_token</code></b>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>email</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="email" data-endpoint="POSTapi-verify_email_token" data-component="body" required  hidden>
<br>
The value must be a valid email address.
</p>
<p>
<b><code>otp</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="otp" data-endpoint="POSTapi-verify_email_token" data-component="body" required  hidden>
<br>

</p>

</form>


## Forget Password




> Example request:

```javascript
const url = new URL(
    "http://localhost:3541/api/forget_password"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "qkunze@example.com"
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost:3541/api/forget_password',
    [
        'headers' => [
            'Accept' => 'application/json',
        ],
        'json' => [
            'email' => 'qkunze@example.com',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost:3541/api/forget_password'
payload = {
    "email": "qkunze@example.com"
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```

```bash
curl -X POST \
    "http://localhost:3541/api/forget_password" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"qkunze@example.com"}'

```


<div id="execution-results-POSTapi-forget_password" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-forget_password"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-forget_password"></code></pre>
</div>
<div id="execution-error-POSTapi-forget_password" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-forget_password"></code></pre>
</div>
<form id="form-POSTapi-forget_password" data-method="POST" data-path="api/forget_password" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-forget_password', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-forget_password" onclick="tryItOut('POSTapi-forget_password');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-forget_password" onclick="cancelTryOut('POSTapi-forget_password');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-forget_password" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/forget_password</code></b>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>email</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="email" data-endpoint="POSTapi-forget_password" data-component="body" required  hidden>
<br>
The value must be a valid email address.
</p>

</form>


## Reset Forget Password




> Example request:

```javascript
const url = new URL(
    "http://localhost:3541/api/reset_forget_password"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "qkunze@example.com",
    "otp": "consequatur",
    "password": "consequatur",
    "password_confirmation": "consequatur"
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost:3541/api/reset_forget_password',
    [
        'headers' => [
            'Accept' => 'application/json',
        ],
        'json' => [
            'email' => 'qkunze@example.com',
            'otp' => 'consequatur',
            'password' => 'consequatur',
            'password_confirmation' => 'consequatur',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost:3541/api/reset_forget_password'
payload = {
    "email": "qkunze@example.com",
    "otp": "consequatur",
    "password": "consequatur",
    "password_confirmation": "consequatur"
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```

```bash
curl -X POST \
    "http://localhost:3541/api/reset_forget_password" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"qkunze@example.com","otp":"consequatur","password":"consequatur","password_confirmation":"consequatur"}'

```


<div id="execution-results-POSTapi-reset_forget_password" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-reset_forget_password"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-reset_forget_password"></code></pre>
</div>
<div id="execution-error-POSTapi-reset_forget_password" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-reset_forget_password"></code></pre>
</div>
<form id="form-POSTapi-reset_forget_password" data-method="POST" data-path="api/reset_forget_password" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-reset_forget_password', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-reset_forget_password" onclick="tryItOut('POSTapi-reset_forget_password');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-reset_forget_password" onclick="cancelTryOut('POSTapi-reset_forget_password');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-reset_forget_password" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/reset_forget_password</code></b>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>email</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="email" data-endpoint="POSTapi-reset_forget_password" data-component="body" required  hidden>
<br>
The value must be a valid email address.
</p>
<p>
<b><code>otp</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="otp" data-endpoint="POSTapi-reset_forget_password" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>password</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="password" name="password" data-endpoint="POSTapi-reset_forget_password" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>password_confirmation</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="password" name="password_confirmation" data-endpoint="POSTapi-reset_forget_password" data-component="body" required  hidden>
<br>

</p>

</form>


## Log out

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```javascript
const url = new URL(
    "http://localhost:3541/api/logout"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost:3541/api/logout',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost:3541/api/logout'
headers = {
  'Authorization': 'Bearer {YOUR_AUTH_KEY}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()
```

```bash
curl -X GET \
    -G "http://localhost:3541/api/logout" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```


> Example response (400):

```json
{
    "data": [],
    "message": "Unauthenticated.",
    "status": 400
}
```
<div id="execution-results-GETapi-logout" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-logout"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-logout"></code></pre>
</div>
<div id="execution-error-GETapi-logout" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-logout"></code></pre>
</div>
<form id="form-GETapi-logout" data-method="GET" data-path="api/logout" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-logout', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-logout" onclick="tryItOut('GETapi-logout');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-logout" onclick="cancelTryOut('GETapi-logout');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-logout" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/logout</code></b>
</p>
<p>
<label id="auth-GETapi-logout" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-logout" data-component="header"></label>
</p>
</form>


## Get Current User

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```javascript
const url = new URL(
    "http://localhost:3541/api/user"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost:3541/api/user',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost:3541/api/user'
headers = {
  'Authorization': 'Bearer {YOUR_AUTH_KEY}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()
```

```bash
curl -X GET \
    -G "http://localhost:3541/api/user" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```


> Example response (400):

```json
{
    "data": [],
    "message": "Unauthenticated.",
    "status": 400
}
```
<div id="execution-results-GETapi-user" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-user"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-user"></code></pre>
</div>
<div id="execution-error-GETapi-user" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-user"></code></pre>
</div>
<form id="form-GETapi-user" data-method="GET" data-path="api/user" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-user', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-user" onclick="tryItOut('GETapi-user');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-user" onclick="cancelTryOut('GETapi-user');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-user" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/user</code></b>
</p>
<p>
<label id="auth-GETapi-user" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-user" data-component="header"></label>
</p>
</form>


## Generate 2FA secret key

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```javascript
const url = new URL(
    "http://localhost:3541/api/generate2fa_secret"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "POST",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost:3541/api/generate2fa_secret',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost:3541/api/generate2fa_secret'
headers = {
  'Authorization': 'Bearer {YOUR_AUTH_KEY}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers)
response.json()
```

```bash
curl -X POST \
    "http://localhost:3541/api/generate2fa_secret" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```


<div id="execution-results-POSTapi-generate2fa_secret" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-generate2fa_secret"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-generate2fa_secret"></code></pre>
</div>
<div id="execution-error-POSTapi-generate2fa_secret" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-generate2fa_secret"></code></pre>
</div>
<form id="form-POSTapi-generate2fa_secret" data-method="POST" data-path="api/generate2fa_secret" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-generate2fa_secret', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-generate2fa_secret" onclick="tryItOut('POSTapi-generate2fa_secret');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-generate2fa_secret" onclick="cancelTryOut('POSTapi-generate2fa_secret');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-generate2fa_secret" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/generate2fa_secret</code></b>
</p>
<p>
<label id="auth-POSTapi-generate2fa_secret" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-generate2fa_secret" data-component="header"></label>
</p>
</form>


## Enable 2FA

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```javascript
const url = new URL(
    "http://localhost:3541/api/generate2fa_enable"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "one_time_password": "consequatur"
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost:3541/api/generate2fa_enable',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'one_time_password' => 'consequatur',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost:3541/api/generate2fa_enable'
payload = {
    "one_time_password": "consequatur"
}
headers = {
  'Authorization': 'Bearer {YOUR_AUTH_KEY}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```

```bash
curl -X POST \
    "http://localhost:3541/api/generate2fa_enable" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"one_time_password":"consequatur"}'

```


<div id="execution-results-POSTapi-generate2fa_enable" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-generate2fa_enable"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-generate2fa_enable"></code></pre>
</div>
<div id="execution-error-POSTapi-generate2fa_enable" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-generate2fa_enable"></code></pre>
</div>
<form id="form-POSTapi-generate2fa_enable" data-method="POST" data-path="api/generate2fa_enable" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-generate2fa_enable', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-generate2fa_enable" onclick="tryItOut('POSTapi-generate2fa_enable');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-generate2fa_enable" onclick="cancelTryOut('POSTapi-generate2fa_enable');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-generate2fa_enable" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/generate2fa_enable</code></b>
</p>
<p>
<label id="auth-POSTapi-generate2fa_enable" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-generate2fa_enable" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>one_time_password</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="password" name="one_time_password" data-endpoint="POSTapi-generate2fa_enable" data-component="body" required  hidden>
<br>

</p>

</form>


## Disable 2FA

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```javascript
const url = new URL(
    "http://localhost:3541/api/generate2fa_disable"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "one_time_password": "consequatur"
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost:3541/api/generate2fa_disable',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'one_time_password' => 'consequatur',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost:3541/api/generate2fa_disable'
payload = {
    "one_time_password": "consequatur"
}
headers = {
  'Authorization': 'Bearer {YOUR_AUTH_KEY}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```

```bash
curl -X POST \
    "http://localhost:3541/api/generate2fa_disable" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"one_time_password":"consequatur"}'

```


<div id="execution-results-POSTapi-generate2fa_disable" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-generate2fa_disable"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-generate2fa_disable"></code></pre>
</div>
<div id="execution-error-POSTapi-generate2fa_disable" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-generate2fa_disable"></code></pre>
</div>
<form id="form-POSTapi-generate2fa_disable" data-method="POST" data-path="api/generate2fa_disable" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-generate2fa_disable', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-generate2fa_disable" onclick="tryItOut('POSTapi-generate2fa_disable');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-generate2fa_disable" onclick="cancelTryOut('POSTapi-generate2fa_disable');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-generate2fa_disable" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/generate2fa_disable</code></b>
</p>
<p>
<label id="auth-POSTapi-generate2fa_disable" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-generate2fa_disable" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>one_time_password</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="password" name="one_time_password" data-endpoint="POSTapi-generate2fa_disable" data-component="body" required  hidden>
<br>

</p>

</form>




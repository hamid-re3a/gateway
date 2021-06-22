# Admin > User


## Activate Or Deactivate User Account

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```javascript
const url = new URL(
    "http://localhost:3541/api/activate_or_deactivate_user"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "qkunze@example.com",
    "deactivate": false
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
    'http://localhost:3541/api/activate_or_deactivate_user',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'email' => 'qkunze@example.com',
            'deactivate' => false,
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost:3541/api/activate_or_deactivate_user'
payload = {
    "email": "qkunze@example.com",
    "deactivate": false
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
    "http://localhost:3541/api/activate_or_deactivate_user" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"qkunze@example.com","deactivate":false}'

```


<div id="execution-results-POSTapi-activate_or_deactivate_user" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-activate_or_deactivate_user"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-activate_or_deactivate_user"></code></pre>
</div>
<div id="execution-error-POSTapi-activate_or_deactivate_user" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-activate_or_deactivate_user"></code></pre>
</div>
<form id="form-POSTapi-activate_or_deactivate_user" data-method="POST" data-path="api/activate_or_deactivate_user" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-activate_or_deactivate_user', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-activate_or_deactivate_user" onclick="tryItOut('POSTapi-activate_or_deactivate_user');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-activate_or_deactivate_user" onclick="cancelTryOut('POSTapi-activate_or_deactivate_user');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-activate_or_deactivate_user" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/activate_or_deactivate_user</code></b>
</p>
<p>
<label id="auth-POSTapi-activate_or_deactivate_user" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-activate_or_deactivate_user" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>email</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="email" data-endpoint="POSTapi-activate_or_deactivate_user" data-component="body" required  hidden>
<br>
The value must be a valid email address.
</p>
<p>
<b><code>deactivate</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-activate_or_deactivate_user" hidden><input type="radio" name="deactivate" value="true" data-endpoint="POSTapi-activate_or_deactivate_user" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-activate_or_deactivate_user" hidden><input type="radio" name="deactivate" value="false" data-endpoint="POSTapi-activate_or_deactivate_user" data-component="body" ><code>false</code></label>
<br>

</p>

</form>


## Verify Email User Account

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```javascript
const url = new URL(
    "http://localhost:3541/api/verify_email_user"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
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
    'http://localhost:3541/api/verify_email_user',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
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

url = 'http://localhost:3541/api/verify_email_user'
payload = {
    "email": "qkunze@example.com"
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
    "http://localhost:3541/api/verify_email_user" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"qkunze@example.com"}'

```


<div id="execution-results-POSTapi-verify_email_user" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-verify_email_user"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-verify_email_user"></code></pre>
</div>
<div id="execution-error-POSTapi-verify_email_user" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-verify_email_user"></code></pre>
</div>
<form id="form-POSTapi-verify_email_user" data-method="POST" data-path="api/verify_email_user" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-verify_email_user', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-verify_email_user" onclick="tryItOut('POSTapi-verify_email_user');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-verify_email_user" onclick="cancelTryOut('POSTapi-verify_email_user');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-verify_email_user" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/verify_email_user</code></b>
</p>
<p>
<label id="auth-POSTapi-verify_email_user" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-verify_email_user" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>email</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="email" data-endpoint="POSTapi-verify_email_user" data-component="body" required  hidden>
<br>
The value must be a valid email address.
</p>

</form>




# Admin > Tickets


## All Tickets

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```javascript
const url = new URL(
    "http://localhost:2222/api/admin/tickets"
);

let params = {
    "name": "consequatur",
    "status": "consequatur",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": {},
    "status": "SPAM"
}

fetch(url, {
    method: "GET",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost:2222/api/admin/tickets',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'query' => [
            'name'=> 'consequatur',
            'status'=> 'consequatur',
        ],
        'json' => [
            'name' => [],
            'status' => 'SPAM',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost:2222/api/admin/tickets'
payload = {
    "name": {},
    "status": "SPAM"
}
params = {
  'name': 'consequatur',
  'status': 'consequatur',
}
headers = {
  'Authorization': 'Bearer {YOUR_AUTH_KEY}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers, json=payload, params=params)
response.json()
```

```bash
curl -X GET \
    -G "http://localhost:2222/api/admin/tickets?name=consequatur&status=consequatur" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":{},"status":"SPAM"}'

```


> Example response (400):

```json
{
    "data": [],
    "message": "Unauthenticated.",
    "status": 400
}
```
<div id="execution-results-GETapi-admin-tickets" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-admin-tickets"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-admin-tickets"></code></pre>
</div>
<div id="execution-error-GETapi-admin-tickets" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-admin-tickets"></code></pre>
</div>
<form id="form-GETapi-admin-tickets" data-method="GET" data-path="api/admin/tickets" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-admin-tickets', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-admin-tickets" onclick="tryItOut('GETapi-admin-tickets');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-admin-tickets" onclick="cancelTryOut('GETapi-admin-tickets');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-admin-tickets" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/admin/tickets</code></b>
</p>
<p>
<label id="auth-GETapi-admin-tickets" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-admin-tickets" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="name" data-endpoint="GETapi-admin-tickets" data-component="query"  hidden>
<br>
</p>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="status" data-endpoint="GETapi-admin-tickets" data-component="query"  hidden>
<br>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="name" data-endpoint="GETapi-admin-tickets" data-component="body"  hidden>
<br>
</p>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="status" data-endpoint="GETapi-admin-tickets" data-component="body"  hidden>
<br>
The value must be one of <code>ANSWERED</code>, <code>NOT_ANSWERED</code>, <code>IN_PROGRESS</code>, or <code>SPAM</code>.</p>

</form>


## Reply Tickets

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```javascript
const url = new URL(
    "http://localhost:2222/api/admin/tickets/comment"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ticket_id": "consequatur",
    "comment": "consequatur"
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
    'http://localhost:2222/api/admin/tickets/comment',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ticket_id' => 'consequatur',
            'comment' => 'consequatur',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost:2222/api/admin/tickets/comment'
payload = {
    "ticket_id": "consequatur",
    "comment": "consequatur"
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
    "http://localhost:2222/api/admin/tickets/comment" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ticket_id":"consequatur","comment":"consequatur"}'

```


<div id="execution-results-POSTapi-admin-tickets-comment" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-admin-tickets-comment"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-admin-tickets-comment"></code></pre>
</div>
<div id="execution-error-POSTapi-admin-tickets-comment" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-admin-tickets-comment"></code></pre>
</div>
<form id="form-POSTapi-admin-tickets-comment" data-method="POST" data-path="api/admin/tickets/comment" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-admin-tickets-comment', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-admin-tickets-comment" onclick="tryItOut('POSTapi-admin-tickets-comment');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-admin-tickets-comment" onclick="cancelTryOut('POSTapi-admin-tickets-comment');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-admin-tickets-comment" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/admin/tickets/comment</code></b>
</p>
<p>
<label id="auth-POSTapi-admin-tickets-comment" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-admin-tickets-comment" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ticket_id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="ticket_id" data-endpoint="POSTapi-admin-tickets-comment" data-component="body" required  hidden>
<br>
</p>
<p>
<b><code>comment</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="comment" data-endpoint="POSTapi-admin-tickets-comment" data-component="body" required  hidden>
<br>
</p>

</form>


## Change Ticket Status

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```javascript
const url = new URL(
    "http://localhost:2222/api/admin/tickets/change_status"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ticket_id": "consequatur",
    "status": "SPAM"
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
    'http://localhost:2222/api/admin/tickets/change_status',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ticket_id' => 'consequatur',
            'status' => 'SPAM',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost:2222/api/admin/tickets/change_status'
payload = {
    "ticket_id": "consequatur",
    "status": "SPAM"
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
    "http://localhost:2222/api/admin/tickets/change_status" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ticket_id":"consequatur","status":"SPAM"}'

```


<div id="execution-results-POSTapi-admin-tickets-change_status" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-admin-tickets-change_status"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-admin-tickets-change_status"></code></pre>
</div>
<div id="execution-error-POSTapi-admin-tickets-change_status" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-admin-tickets-change_status"></code></pre>
</div>
<form id="form-POSTapi-admin-tickets-change_status" data-method="POST" data-path="api/admin/tickets/change_status" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-admin-tickets-change_status', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-admin-tickets-change_status" onclick="tryItOut('POSTapi-admin-tickets-change_status');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-admin-tickets-change_status" onclick="cancelTryOut('POSTapi-admin-tickets-change_status');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-admin-tickets-change_status" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/admin/tickets/change_status</code></b>
</p>
<p>
<label id="auth-POSTapi-admin-tickets-change_status" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-admin-tickets-change_status" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ticket_id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="ticket_id" data-endpoint="POSTapi-admin-tickets-change_status" data-component="body" required  hidden>
<br>
</p>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="status" data-endpoint="POSTapi-admin-tickets-change_status" data-component="body" required  hidden>
<br>
The value must be one of <code>ANSWERED</code>, <code>NOT_ANSWERED</code>, <code>IN_PROGRESS</code>, or <code>SPAM</code>.</p>

</form>


## Show Ticket

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```javascript
const url = new URL(
    "http://localhost:2222/api/admin/tickets/consequatur"
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
    'http://localhost:2222/api/admin/tickets/consequatur',
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

url = 'http://localhost:2222/api/admin/tickets/consequatur'
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
    -G "http://localhost:2222/api/admin/tickets/consequatur" \
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
<div id="execution-results-GETapi-admin-tickets--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-admin-tickets--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-admin-tickets--id-"></code></pre>
</div>
<div id="execution-error-GETapi-admin-tickets--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-admin-tickets--id-"></code></pre>
</div>
<form id="form-GETapi-admin-tickets--id-" data-method="GET" data-path="api/admin/tickets/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-admin-tickets--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-admin-tickets--id-" onclick="tryItOut('GETapi-admin-tickets--id-');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-admin-tickets--id-" onclick="cancelTryOut('GETapi-admin-tickets--id-');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-admin-tickets--id-" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/admin/tickets/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-admin-tickets--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-admin-tickets--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-admin-tickets--id-" data-component="url" required  hidden>
<br>
</p>
</form>




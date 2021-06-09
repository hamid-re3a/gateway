# Public User > Comments


## Send Comment

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```javascript
const url = new URL(
    "http://localhost:2222/api/ticket/comment"
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
    'http://localhost:2222/api/ticket/comment',
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

url = 'http://localhost:2222/api/ticket/comment'
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
    "http://localhost:2222/api/ticket/comment" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ticket_id":"consequatur","comment":"consequatur"}'

```


<div id="execution-results-POSTapi-ticket-comment" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-ticket-comment"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-ticket-comment"></code></pre>
</div>
<div id="execution-error-POSTapi-ticket-comment" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-ticket-comment"></code></pre>
</div>
<form id="form-POSTapi-ticket-comment" data-method="POST" data-path="api/ticket/comment" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-ticket-comment', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-ticket-comment" onclick="tryItOut('POSTapi-ticket-comment');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-ticket-comment" onclick="cancelTryOut('POSTapi-ticket-comment');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-ticket-comment" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/ticket/comment</code></b>
</p>
<p>
<label id="auth-POSTapi-ticket-comment" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-ticket-comment" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ticket_id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="ticket_id" data-endpoint="POSTapi-ticket-comment" data-component="body" required  hidden>
<br>
</p>
<p>
<b><code>comment</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="comment" data-endpoint="POSTapi-ticket-comment" data-component="body" required  hidden>
<br>
</p>

</form>




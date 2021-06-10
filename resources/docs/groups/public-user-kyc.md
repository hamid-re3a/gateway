# Public User > KYC


## Upload New Document

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```javascript
const url = new URL(
    "http://localhost:3541/api/kyc/upload"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
};

const body = new FormData();
body.append('document_type', 'driving_licence');
body.append('file', document.querySelector('input[name="file"]').files[0]);

fetch(url, {
    method: "POST",
    headers,
    body,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost:3541/api/kyc/upload',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'multipart' => [
            [
                'name' => 'document_type',
                'contents' => 'driving_licence'
            ],
            [
                'name' => 'file',
                'contents' => fopen('/tmp/phpTirgtu', 'r')
            ],
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost:3541/api/kyc/upload'
files = {
  'file': open('/tmp/phpTirgtu', 'rb')
}
payload = {
    "document_type": "driving_licence"
}
headers = {
  'Authorization': 'Bearer {YOUR_AUTH_KEY}',
  'Content-Type': 'multipart/form-data',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, files=files, data=payload)
response.json()
```

```bash
curl -X POST \
    "http://localhost:3541/api/kyc/upload" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: multipart/form-data" \
    -H "Accept: application/json" \
    -F "document_type=driving_licence" \
    -F "file=@/tmp/phpTirgtu" 
```


<div id="execution-results-POSTapi-kyc-upload" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-kyc-upload"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-kyc-upload"></code></pre>
</div>
<div id="execution-error-POSTapi-kyc-upload" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-kyc-upload"></code></pre>
</div>
<form id="form-POSTapi-kyc-upload" data-method="POST" data-path="api/kyc/upload" data-authed="1" data-hasfiles="1" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"multipart\/form-data","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-kyc-upload', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-kyc-upload" onclick="tryItOut('POSTapi-kyc-upload');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-kyc-upload" onclick="cancelTryOut('POSTapi-kyc-upload');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-kyc-upload" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/kyc/upload</code></b>
</p>
<p>
<label id="auth-POSTapi-kyc-upload" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-kyc-upload" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>document_type</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="document_type" data-endpoint="POSTapi-kyc-upload" data-component="body" required  hidden>
<br>
The value must be one of <code>driving_licence</code>, <code>passport</code>, or <code>national_id</code>.
</p>
<p>
<b><code>file</code></b>&nbsp;&nbsp;<small>file</small>  &nbsp;
<input type="file" name="file" data-endpoint="POSTapi-kyc-upload" data-component="body" required  hidden>
<br>
The value must be a file.
</p>

</form>




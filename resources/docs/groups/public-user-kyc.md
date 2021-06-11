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
    method: "PUT",
    headers,
    body,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
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
                'contents' => fopen('/tmp/phppnFm0K', 'r')
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
  'file': open('/tmp/phppnFm0K', 'rb')
}
payload = {
    "document_type": "driving_licence"
}
headers = {
  'Authorization': 'Bearer {YOUR_AUTH_KEY}',
  'Content-Type': 'multipart/form-data',
  'Accept': 'application/json'
}

response = requests.request('PUT', url, headers=headers, files=files, data=payload)
response.json()
```

```bash
curl -X PUT \
    "http://localhost:3541/api/kyc/upload" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: multipart/form-data" \
    -H "Accept: application/json" \
    -F "document_type=driving_licence" \
    -F "file=@/tmp/phppnFm0K" 
```


<div id="execution-results-PUTapi-kyc-upload" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-kyc-upload"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-kyc-upload"></code></pre>
</div>
<div id="execution-error-PUTapi-kyc-upload" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-kyc-upload"></code></pre>
</div>
<form id="form-PUTapi-kyc-upload" data-method="PUT" data-path="api/kyc/upload" data-authed="1" data-hasfiles="1" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"multipart\/form-data","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-kyc-upload', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-PUTapi-kyc-upload" onclick="tryItOut('PUTapi-kyc-upload');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-PUTapi-kyc-upload" onclick="cancelTryOut('PUTapi-kyc-upload');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-PUTapi-kyc-upload" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/kyc/upload</code></b>
</p>
<p>
<label id="auth-PUTapi-kyc-upload" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-kyc-upload" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>document_type</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="document_type" data-endpoint="PUTapi-kyc-upload" data-component="body" required  hidden>
<br>
The value must be one of <code>driving_licence</code>, <code>passport</code>, or <code>national_id</code>.
</p>
<p>
<b><code>file</code></b>&nbsp;&nbsp;<small>file</small>  &nbsp;
<input type="file" name="file" data-endpoint="PUTapi-kyc-upload" data-component="body" required  hidden>
<br>
The value must be a file.
</p>

</form>




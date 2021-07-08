#Publish config
 ```
php artisan vendor:publish --provider="RequestRouter\GatewayServiceProvider"
 ``` 

we now support multiple services with middleware

####change the config file in laravel default folder

you have 2 options:
    
- services
- routes

##Services
    doc_point  --> route of service documentation
    just_current_routes --> can read other routes more than what defined in routes part
    domain --> base_path of the service
##routes
Accepts arrays of routes
each array can tell:
- services
- matches
- middlewares 


    services -> array of services that match this routes
    matches -> array of routes and their pathes
    middleswares -> array of middlewares which should be passed during this call

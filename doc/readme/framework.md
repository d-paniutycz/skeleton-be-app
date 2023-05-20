## Framework
The framework utilizes Symfony and is a layered monolith architecture that combines the CQRS pattern with non-purist DDD principles. The source code is divided into two layers, `App` contains the actual business and application logic, and `Sys`, which provides basic and general tools for the `App` layer.

To access the Symfony console, execute the command `bin/app exec` command directly from PHP container.

## Framework: Flow
![](/doc/readme/img/framework-flow.png)

### 1) Database
Using CQRS encourages separating database connections into read-only and read/write connections. By separating connections, it enables future replication of the database when vertical scaling is no longer feasible. Data replication between databases should occur synchronously, for example using Write Ahead Log (PostgreSQL).

Using two different connections for Query and Command poses a challenge when reading data that is currently in a transaction. In such cases, when an active transaction is detected, the Read Model will utilize the read/write instead of default read only connection.

### 2) Async messages
All messages that implement the `AsyncMessage` interface are routed to the asynchronous transport of the Messenger component. Additionally, they are marked with the `DispatchAfterCurrentBusStamp` stamp. This ensures that the messages will not be sent if an error occurs during the execution of the current bus message stack.

## Feature: Guard
The basic functionality of `isGranted` is not sufficient. To enable more flexible access control, a `Guard` attribute has been created, allowing easy implementation of any ACL logic through strategies. The basic access control strategy is the `GuardRole`.

```php
final class ClientController extends WebController
{
    // no guard, endpoint publicly accessible
    #[Route(path: null, methods: Request::METHOD_POST)]
    public function create(ClientCreateInput $createInput): Response
    {
        // ...
    }

    // any role guard, only clients with master role are allowed
    #[Guard(new GuardRoleAny(Role::MASTER))]
    #[Route(path: '/{clientId}', methods: Request::METHOD_GET)]
    public function read(ClientId $clientId): Response
    {
        // ...
    }

    // only authenticated clients are allowed
    #[Guard]
    #[Route(path: '/current', methods: Request::METHOD_GET)]
    public function current(): Response
    {
        // ...
    }
}
```

An endpoint can be guarded by multiple strategies, and each strategy must express consent for access. You can implement new strategies using the `GuardStrategy` interface, but since attributes are not part of the container, you need to ensure that the necessary dependencies (DI) are provided.

## Feature: Request resolver
Every HTTP request can be automatically resolved into a DTO that implements the `ResolveableRequest` interface. Optionally, the data can also be validated against a set of assertion rules.

### 1) HTTP Request
```shell
curl --request POST \
  --url http://127.0.0.1/api/v1/client \
  --header 'Content-Type: application/json' \
  --data '{
	"username": "username",
	"password": "password"
  }'
```

### 2) Input DTO
```php
readonly class ClientCreateInput implements ResolvableRequest
{
    #[Assert\Type('alnum')]
    #[Assert\Length(min: 8, max: 32)]
    public string $username;

    #[Assert\Length(min: 8, max: 32)]
    public string $password;

    public static function getRequestResolver(): RequestResolverStrategy
    {
        return new JsonContentResolverStrategy();
    }
}
```
The `ResolvableRequest` interface enforces the requirement to specify a strategy that determines how we want to extract data from the request. In this case, the data source for the DTO is the content encoded in JSON. Implementing other strategies is possible using the `RequestResolverStrategy` interface.

### 3) Input DTO injection
```php
#[Route(path: '/api/v1/client']
final class ClientController extends WebController
{
    #[Route(path: null, methods: Request::METHOD_POST)]
    public function create(ClientCreateInput $createInput): Response
    {
        echo $createInput->username;
        echo $createInput->password;
        // ...
    }
}
```
The data received in the controller action, based on the type hint `ClientCreateInput`, is automatically validated against the rules defined in the DTO and can be used in further program logic.

## Feature: ID resolver
All objects that store IDs and inherit from `UlidValue` are automatically resolved to their respective types directly from the URL path.

### 1) HTTP Request
```shell
curl --request GET \
  --url http://127.0.0.1/api/v1/client/01H0WHQA9AVR19484F2AHMP3Y4
```

### 2) Value injection
```php
#[Route(path: '/api/v1/client']
final class ClientController extends WebController
{
    #[Route(path: '/{clientId}', methods: Request::METHOD_GET)]
    public function read(ClientId $clientId): Response
    {
        echo $clientId->getValue();
        // ...
    }
}
```

## Feature: Api Problem
All exceptions that inherit from `ApplicationException` will be automatically converted to an API Problem response and returned as a `problem+json` response with the appropriate status code. Each other uncaught exception will result in an anonymized response with a status code of 500.

### 1) Application exception
```php
class InsufficientRoleException extends ApplicationException
{
    public function __construct(
        public readonly Role $currentRole,
    ) {
        parent::__construct('Insufficient role to access this resource.');
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_FORBIDDEN;
    }
}
```
The default status code for the API Problem response is 400. However, you can override the `getStatusCode` method to change it to a different value. Additionally, all **public** properties will be included in the response as additional problem information.

### 2) Response problem+json
```json
{
	"type": "urn:id:706337496",
	"title": "Insufficient role exception",
	"detail": "Insufficient role to access this resource.",
	"status": 403,
	"additional": {
		"currentRole": "ROLE_REGULAR"
	}
}
```
The Api Problem `type` is constructed by calculating the CRC32 checksum of the exception's namespace. Therefore, it represents a unique type across the entire application, even though the exception may be thrown in multiple places with different detail (exception) message.

_...There is more, check the source code by yourself!_

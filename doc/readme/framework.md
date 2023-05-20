## Framework
The framework utilizes Symfony and is a layered monolith architecture that combines the CQRS pattern with non-purist DDD principles. The source code is divided into two layers, `App` contains the actual business and application logic, and `Sys`, which provides basic and general tools for the `App` layer.

To access the Symfony console, execute the command `bin/app exec` command directly from PHP container.

## Framework: Flow
![](/doc/readme/img/framework-flow.png)


## Feature: Guard
The basic functionality of `isGranted` is not sufficient. To enable more flexible access control, a `Guard` attribute has been created, allowing easy implementation of any ACL logic through strategies. The basic access control strategy is the `GuardRole`. Here are a few usage examples:

```php
final class ClientController extends WebController
{
    // no guard, endpoint publicly accessible
    #[Route(path: null, methods: Request::METHOD_POST)]
    public function create(ClientCreateInput $createInput): Response
    {
        // ...
    }

    // role guard, only clients with master or moderator role are allowed
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

## Feature: Api Problem generator

## Framework
The framework utilizes Symfony and is a layered monolith architecture that combines the CQRS pattern with non-purist DDD principles. The source code is divided into two layers `App`, which contains the actual business and application logic, and `Sys`, which provides basic and general tools for the `App` layer.

To access the Symfony console, execute the command `bin/app exec` command directly from PHP container.

## Framework: Flow
![](/doc/readme/img/framework-flow.png)


## Feature: Guard

## Feature: Resolver

## Feature: ApiProblem

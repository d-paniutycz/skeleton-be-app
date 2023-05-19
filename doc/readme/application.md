
## Tests:
Application testing is divided into two independent test groups. The `quality` group performs static code analysis to check its quality and potential errors that may occur during runtime. The `code` group conducts tests directly on the code and determines the code coverage of the application. In the case of CI/CD, both groups are executed in parallel to reduce the overall testing time. Locally, **within a container**, tests can be executed independently and selectively.

## Tests: Quality
Running the group: `bin/app test --quality` or selectively: `bin/app test phpcs psalm`

| order | name    | bin (php tech image)   | config path                          |
|-------|---------|------------------------|--------------------------------------|
| 1     | phpmd   | /usr/local/bin/phpmd   | etc/config/test/quality/phpmd.xml    |
| 2     | phpcs   | /usr/local/bin/phpcs   | etc/config/test/quality/phpcs.xml    |
| 3     | psalm   | /usr/local/bin/psalm   | etc/config/test/quality/psalm.xml    |
| 4     | phpstan | /usr/local/bin/phpstan | etc/config/test/quality/phpstan.neon |

These tools can be integrated with an IDE (e.g., PHPStorm) by configuring the interpreter to point to the executable paths within the image and their respective configurations.

## Tests: Code
Running the group: `bin/app test --code` or selectively: `bin/app test phpunit`

|   | driver  | abstract type   |                            |
|---|---------|-----------------|----------------------------|
|   | phpunit | UnitTest        | high level of insulation   |
|   | phpunit | IntegrationTest | medium level of insulation |
|   | phpunit | FunctionalTest  | smoke, end to end tests    |

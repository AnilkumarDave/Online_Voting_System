# Test Automation for Online Voting System

This folder contains a Java-based UI test automation project for the
**Online Voting System** (PHP + MySQL) application.

The goal is to demonstrate how I use:

- Java with TestNG for structured automated tests
- Selenium WebDriver (and optionally Selenium Grid) for browser automation
- Page Object Model (POM) for maintainable test design
- Lombok to reduce boilerplate in page objects
- Maven for dependency management and builds
- Jenkins for CI, so tests can run automatically on each push

## Project structure

- `pom.xml` – Maven configuration, dependencies (Selenium, TestNG, Lombok)
- `src/test/java/com/anildave/onlinevoting/BaseTest.java` – shared WebDriver setup/teardown
- `src/test/java/com/anildave/onlinevoting/pages/LoginPage.java` – page object for the login page
- `src/test/java/com/anildave/onlinevoting/pages/VotePage.java` – page object for the voting page
- `src/test/java/com/anildave/onlinevoting/tests/LoginAndVoteTest.java` – example end-to-end test

## Prerequisites

- JDK 11+ installed  
- Maven installed (`mvn -v` should work)  
- Chrome or another supported browser installed  
- The PHP application running locally, e.g.:

  - `http://localhost/Online_Voting_System/index.php`

## How to run tests locally

From the `automation` folder:

```bash
mvn clean test
```

By default, the tests assume the application is available at
`http://localhost/Online_Voting_System/`. You can change this by editing
the `BASE_URL` in `BaseTest.java`.

## Running via Jenkins

A simple `Jenkinsfile` is included at the root of the main repository.
When a Jenkins pipeline is created pointing to this repo, it will:

1. Check out the code  
2. Change into the `automation` folder  
3. Run `mvn clean test`  
4. Archive the test reports  

This demonstrates how automated UI tests can be integrated into a CI
pipeline for a small PHP web application.

# MSIDN Parser

## Instructions

1. Create an application with following requirements:

    - latest PHP 5.6 or Golang
    - takes MSISDN as an input
    - returns MNO identifier, country dialling code, subscriber number and country identifier as defined with ISO 3166-1-alpha-2
    - do not care about number portability

2. Write all needed tests.

3. Expose the package through an RPC API, select one and explain why have you chosen it.

4. Use git, vagrant and/or docker, and a configuration management tool (puppet, chef, ansible, ...).

5. Other:

    - a git repository with full commit history is expected to be part of the delivered solution
    - if needed, provide additional installation instructions, but there shouldn’t be much more than running a simple command to set everything up
    - use best practices all around. For PHP, good source of that would be http://www.phptherightway.com/

important: do not take this task lightly. You will be judged according to the quality, completion and perfection of the task.

## Requirements

- [Vagrant](https://docs.vagrantup.com/v2/installation/)
- [Go](https://golang.org/dl/)

## Usage

```
git clone
cd msisdn
vagrant up
go run client/client.go <msisdn_number>
```

## Tests

```
vagrant ssh
cd /vagrant/server
vendor/bin/phpunit
```

## RPC API

I choose JSON RPC v2.0 over XML RPC because of JSON simplicity and it's small overhead.

Method  | Parameters
------------- | -------------
parse   | \<msisdn\>



Author: Andraž Krašček

E-mail: andraz.krascek@gmail.com

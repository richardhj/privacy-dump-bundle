<div align="center">
  <p><img src="/docs/logo.svg" width="200" alt=""></p>
  <p>Create purged and anonymized MySQL database dumps</p>
</div>

## About

This Symfony bundle provides utilities for creating anonymized database dumps.

It is the equivalent of `mysqldump`, with additional features, at the cost of performance (PHP implementation).
The main purpose of this tool is to create anonymized dumps, in order to comply with GDPR regulations.

This Symfony bundle complements https://github.com/richardhj/privacy-dump/.

## Features

- Data converters (transform the data before it is dumped to the file)
- Table filtering
- Tables include list (only these tables will be included in the dump)
- Tables exclude list (not included in the dump)

## Installation

```shell script
composer require richardhj/privacy-dump-bundle
```

## Configuration

```yml
richardhj_privacy_dump:
  database:
    prod: # <- the name of the database
      host: localhost
      port: 3306
      user: root
      password: password
      database: test
    
      # If DSN is specified, it will override other values
      dsn: 'mysql://root:root_pass@127.0.0.1:3306/test_db'
      # DSN can be an environment variable
      dsn: '%env(DATABASE_URL)%'

  config:
    default: # <- the name of the export configuration
      tables:
        log:
          truncate: true

        user:
          converters:
            firstname:
              converter: 'anonymizeText'
            lastname:
              converter: 'anonymizeText'
            street:
              converter: 'anonymizeText'
            company:
              converter: 'anonymizeText'
            email:
              converter: 'randomizeEmail'
              cache_key: 'member_email'
              unique: true
            username:
              converter: 'randomizeEmail'
              cache_key: 'member_email'
              unique: true
            secret:
              converter: 'setNull'
```

**Full documentation of available converters:**

https://github.com/Smile-SA/gdpr-dump/blob/master/docs/01-configuration.md#dump-settings

## Usage

```shell script
php bin/console privacy-dump prod default --filename dump.sql
```


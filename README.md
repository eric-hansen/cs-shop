# Introduction

An awesome project showing off some shop interfaces!

# Setup

This requires Docker to be installed on your computer.  The below steps assume you're on Linux or Mac.

First you need to install the dependencies (including Sail):

```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/opt \
    -w /opt \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```

Now you need to register Sail and create the `./vendor/bin/sail` binary:

```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/opt \
    -w /opt \
    laravelsail/php81-composer:latest \
    php artisan sail:install 
```

# Running

Now you can do `./vendor/bin/sail up` (optionally pass in `-d` to daemonize the startup).

Once that finishes you can now view the app at `http://localhost`.

To make the app meaningful though you also need to seed the database:

`./vendor/bin/sail artisan migrate && ./vendor/bin/sail artisan db:seed`

If no errors occur you can now log in: `http://localhost/login`.

# Logging In

The passwords are hashed, but a user you can log in with is `larhonda.hovis@foo.com:cghmpbKXXK` (username:password).
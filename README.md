# Introduction

An awesome project showing off some shop interfaces!

# Setup

This requires Docker & Docker Compose to be installed on your computer.  The below steps assume you're on Linux or Mac.  If you're on Windows then use [WSL](https://docs.docker.com/desktop/windows/wsl/) to run these commands.

First you need to install the dependencies (including Sail):

```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/opt \
    -w /opt \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```

Now copy over the `.env.example` to `.env`: `cp .env{.example,}`

Now you need to register Sail and create the `./vendor/bin/sail` binary:

```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/opt \
    -w /opt \
    laravelsail/php81-composer:latest \
    php artisan sail:install 
```

After this run `git stash` as the `sail:install` command overrides the `docker-compose.yml` file.

Now generate an application/app key: `./vendor/bin/sail artisan key:generate`.

# Running

Now you can do `./vendor/bin/sail up` (optionally pass in `-d` to daemonize the startup).

Once that finishes you can now view the app at `http://localhost`.

To make the app meaningful though you also need to seed the database:

`./vendor/bin/sail artisan migrate && ./vendor/bin/sail artisan db:seed`

If no errors occur you can now log in: `http://localhost/login`.

# Logging In

The passwords are hashed, but a user you can log in with is `larhonda.hovis@foo.com:cghmpbKXXK` (username:password).

# FAQ

**Q**: I get an error saying that the key isn't generated.  Why?

You need to run `./vendor/bin/sail artisan key:generate` after installing the composer dependencies (the first Docker command).

**Q**: Why does the database seeder (`BaseSeeder`) load a local file?

For performance.  The quickest I could get the seeder to run the `OrderSeeder` was about 110s (~1m 50s).

This includes doing transactions, batching, exploring other CSV handler services (those caused worse performance than just using `str_getcsv`).

It's not a normal route to go, for security and practical reasons.  But at the same time one doesn't run `artisan db:seed` in production (or shouldn't).  Collectively the seeding took about 2-3 minutes at it's fastest before writing it to load in the files to MySQL.  Now it takes ~1.5-2 seconds.

Of course this is due to the amount of data that needs to be imported.  For comparison, the `users.csv` file takes ~200ms doing it any way besides loading it in.

But to give you an idea, here's the output of `artisan db:seed`:

```
@1000 transactions per commit:

Seeding: Database\Seeders\UserSeeder
Seeded:  Database\Seeders\UserSeeder (88.89ms)
Seeding: Database\Seeders\ProductSeeder
Seeded:  Database\Seeders\ProductSeeder (11,177.48ms)
Seeding: Database\Seeders\InventorySeeder
Seeded:  Database\Seeders\InventorySeeder (30,629.46ms)
Seeding: Database\Seeders\OrderSeeder
Seeded:  Database\Seeders\OrderSeeder (110,739.71ms)

LOAD DATA INFILE LOCAL:

Seeding: Database\Seeders\UserSeeder
Seeded:  Database\Seeders\UserSeeder (17.81ms)
Seeding: Database\Seeders\ProductSeeder
Seeded:  Database\Seeders\ProductSeeder (202.81ms)
Seeding: Database\Seeders\InventorySeeder
Seeded:  Database\Seeders\InventorySeeder (238.50ms)
Seeding: Database\Seeders\OrderSeeder
Seeded:  Database\Seeders\OrderSeeder (1,123.71ms)
Database seeding completed successfully.
```

Security was another concern when deciding on going this route.  Due to that, there are a couple of checks made to eleviate the concern.

First the filename is hardcoded for each seeder and confirmed prior to reading the file in.
Second we check the header columns found in the file and compare that against the list of fillable model properties.

If either of the above checks don't match, we throw an exception.

**Q**: Unable to connect to MySQL via Sail

This may happen due to an app caching issue.  A few steps to try:

* Run `./vendor/bin/sail artisan optimize`
* Run `./vendor/bin/sail artisan`

Both will build out a cache for the app appropriately.  While the above shouldn't be necessary (or this issue happen) you never know.

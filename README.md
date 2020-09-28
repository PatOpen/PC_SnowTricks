# OC_SnowTricks

![GitHub Version](https://img.shields.io/github/v/tag/PatOpen/OC_SnowTricks?label=version)
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/9842e867455b4ae192da6a0c76bdaea6)](https://www.codacy.com/manual/PatOpen/OC_SnowTricks?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=PatOpen/OC_SnowTricks&amp;utm_campaign=Badge_Grade)
[![Maintainability](https://api.codeclimate.com/v1/badges/bf9f44c4ce39753bc8b6/maintainability)](https://codeclimate.com/github/PatOpen/OC_SnowTricks/maintainability)
---

## Overview

This project aims to show my work and to promote it.

It was developed with **symfony 4** and realized with the *PhpStorm* IDE

---

## Summary

-   [Installation procedure](#Installation-procedure)
-   [Copyright](#Copyright)
-   [Issues](#Issues)
-   [Pull Requests](#Pull-Requests)

---

## Installation procedure

-   In your console, `git clone https://github.com/PatOpen/OC_SnowTricks.git`.
-   Install *composer* and do `php composer.phar install`.
-   Configure your `.env` file with your database configuration with PostgreSQL.
-   `php bin/console doctrine:database:create snowtricks`
-   `php bin/console make:migration`
-   `php bin/console doctrine:migrations:migrate`
-   In the file *snowtricks_dump.sql* replace your owner in line 26.
-   Import *snowtricks_dump.sql* in your database.
-   For test the *Administration* login to *test@test.com* and password *test*.

And now you can connect on the site .

---

## Copyright

Code published under the MIT license

![GitHub license](https://img.shields.io/github/license/PatOpen/OC_SnowTricks)

---


## Issues

For Issues

![GitHub Open Issues](https://img.shields.io/github/issues-raw/PatOpen/OC_SnowTricks)
![GitHub Close Issues](https://img.shields.io/github/issues-closed-raw/PatOpen/OC_SnowTricks?color=green)

---

## Pull Requests

For Pull Requests

![GitHub Open Pull Requests](https://img.shields.io/github/issues-pr-raw/PatOpen/OC_SnowTricks)
![GitHub Close Pull Requests](https://img.shields.io/github/issues-pr-closed-raw/PatOpen/OC_SnowTricks?color=green)
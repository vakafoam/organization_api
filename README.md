Organization API

A RESTful service that stores organisations with relations
(parent to child relation). Organization name is unique. One organisation may have multiple
parents and daughters. All relations and organisations are inserted with one request (endpoint
1).
API has a feature to retrieve all relations of one organization (endpoint 2). This endpoint
response includes all parents, daughters and sisters of a given organization.


The service endpoints:
1) REST API endpoint that would allow to add many organization with relations in one
POST request:

{
"org_name": "Paradise Island",
"daughters": [{
	"org_name": "Banana tree",
	"daughters": [{
		"org_name": "Yellow Banana"
		}, {
		"org_name": "Brown Banana"
		}, {
		"org_name": "Black Banana"
		}]
		}, {
		"org_name": "Big banana tree",
		"daughters": [{
			"org_name": "Yellow Banana"
			}, {
			"org_name": "Brown Banana"
			}, {
			"org_name": "Green Banana"
			}, {
			"org_name": "Black Banana",
			"daughters": [{
				"org_name": "Phoneutria Spider"
			}]
		}]
	}]
}

2) REST API endpoint that returns relations of one organization (queried by name). All
organization daughters, sisters and parents are returned as one list. List is ordered by
name and one page may return 100 rows at max with pagination support. For example
if you query relations for organization “Black Banana”, you will get:

[{
	"relationship_type": "parent",
	"org_name": "Banana tree"
	}, {
	"relationship_type": "parent",
	"org_name": "Big banana tree"
	}, {
	"relationship_type": "sister",
	"org_name": "Brown Banana"
	}, {
	"relationship_type": "sister",
	"org_name": "Green Banana"
	}, {
	"relationship_type": "daughter",
	"org_name": "Phoneutria Spider"
	}, {
	"relationship_type": "sister",
	"org_name": "Yellow Banana"
}]




Symfony Standard Edition
========================

**WARNING**: This distribution does not support Symfony 4. See the
[Installing & Setting up the Symfony Framework][15] page to find a replacement
that fits you best.

Welcome to the Symfony Standard Edition - a fully-functional Symfony
application that you can use as the skeleton for your new applications.

For details on how to download and get started with Symfony, see the
[Installation][1] chapter of the Symfony Documentation.

What's inside?
--------------

The Symfony Standard Edition is configured with the following defaults:

  * An AppBundle you can use to start coding;

  * Twig as the only configured template engine;

  * Doctrine ORM/DBAL;

  * Swiftmailer;

  * Annotations enabled for everything.

It comes pre-configured with the following bundles:

  * **FrameworkBundle** - The core Symfony framework bundle

  * [**SensioFrameworkExtraBundle**][6] - Adds several enhancements, including
    template and routing annotation capability

  * [**DoctrineBundle**][7] - Adds support for the Doctrine ORM

  * [**TwigBundle**][8] - Adds support for the Twig templating engine

  * [**SecurityBundle**][9] - Adds security by integrating Symfony's security
    component

  * [**SwiftmailerBundle**][10] - Adds support for Swiftmailer, a library for
    sending emails

  * [**MonologBundle**][11] - Adds support for Monolog, a logging library

  * **WebProfilerBundle** (in dev/test env) - Adds profiling functionality and
    the web debug toolbar

  * **SensioDistributionBundle** (in dev/test env) - Adds functionality for
    configuring and working with Symfony distributions

  * [**SensioGeneratorBundle**][13] (in dev env) - Adds code generation
    capabilities

  * [**WebServerBundle**][14] (in dev env) - Adds commands for running applications
    using the PHP built-in web server

  * **DebugBundle** (in dev/test env) - Adds Debug and VarDumper component
    integration

All libraries and bundles included in the Symfony Standard Edition are
released under the MIT or BSD license.

Enjoy!

[1]:  https://symfony.com/doc/3.4/setup.html
[6]:  https://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/index.html
[7]:  https://symfony.com/doc/3.4/doctrine.html
[8]:  https://symfony.com/doc/3.4/templating.html
[9]:  https://symfony.com/doc/3.4/security.html
[10]: https://symfony.com/doc/3.4/email.html
[11]: https://symfony.com/doc/3.4/logging.html
[13]: https://symfony.com/doc/current/bundles/SensioGeneratorBundle/index.html
[14]: https://symfony.com/doc/current/setup/built_in_web_server.html
[15]: https://symfony.com/doc/current/setup.html

# Group Gist
Gist-related resources of *Gist Fox API*.

## Gist [/gists/{id}]
A single Gist object.
The Gist resource is the central resource in the Gist Fox API. It represents one paste - a single text note.

The Gist resource has the following attributes:

- id
- created_at
- description
- content

The states *id* and *created_at* are assigned by the Gist Fox API at the moment of creation.


+ Parameters
	+ id (string) ... ID of the Gist in the form of a hash.

+ Model (application/hal+json)

	HAL+JSON representation of Gist Resource. In addition to representing its state in the JSON form it offers affordances in the form of the HTTP Link header and HAL links.

	+ Headers

			Link: <http:/api.gistfox.com/gists/42>;rel="self", <http:/api.gistfox.com/gists/42/star>;rel="star"

	+ Body

			{
				"_links": {
					"self": { "href": "/gists/42" },
					"star": { "href": "/gists/42/star" },
				},
				"id": "42",
				"created_at": "2014-04-14T02:15:15Z",
				"description": "Description of Gist",
				"content": "String contents"
			}

### Retrieve a Single Gist [GET]
+ Response 200

	[Gist][]

## Changelog

**Version 0.6.0**  
* New api client to handle lighting within a World.

**Version 0.5.1**  
* New param `lit` added to 3D objects client.

**Version 0.5.0**  
* New api client to handle creating, updating, and deleting 3D objects on a world.

**Version 0.4.5**  
* Allow status to be passed to getWorldList method as a param. It is not required, but allows us to show draft items for admins in an organization.

**Version 0.4.4**  
* Fix email regexp to allow addresses longer than 3 characters.

**Version 0.4.3**  
* New method added to the Meida client that allows to retrieve media from a specific organization.

**Version 0.4.2**  
* Ability to update Advanced Settings in Worlds.

**Version 0.4.1**  
* Integrated ConverKit with the registration form.

**Version 0.4.0**  
* Method `getWorldList` of world client now takes a single object as one (and only) argument.  
* Methods `searchWorlds` and `getWorldList` now take a `cat` param that determines which categories to pull results from.

**Version 0.3.1**  
* The world client now accepts a new argument when loading a list of worlds. Now, you can pass a `page` argument to the `getWorldList` method of the `WorldAPIClient` class. This parameter dictates which page to load from the results.  
* The `searchWorlds` method of the `WorldAPIClient` class now returns an object containing an array of worlds found, and a `count` property with the number of worlds found in the search.

**Version 0.3.0**  
* Ability to create organizations.

**Version 0.1.0**  
* new `tax_client` to get categories for a world.
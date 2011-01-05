#PHPStack

A new version is in development on the master branch. The currently released version of PHPStack can be found
[https://github.com/conceptcoding/PHPStack/tree/1.1](here "PHPStack 1.1").

##PHPStack 2

PHPStack 2 is currently in development.

To initialise PHPStack, simply create a new PHPStack class, along with your API key.

    $phpstack = new PHPStack("YOUR_API_KEY");

This will return an array. The first element ([0]) contains the PHPStack class, while the second element ([1]) contains an array of `StackSites`. These classes are accessible through a key of the API endpoint.

    $phpstack = new PHPStack("YOUR_API_KEY");
    $phpstack[1]['api.stackoverflow.com'];

`StackSites` are scoped to a single API endpoint, and *all* site-specific routes are initially retrieved through this.
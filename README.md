silverstripe-optimisticlocking
==============================

Prevent overwriting data by blocking the save process when the data changed since retrieval (using a timestamp).


## Usage:

1. Extract / clone the package so that the path to the `_config.php` is `optimisticlocking\\_config.php`.
2. Open _config.php and add the OptimisticLocking class to your ``Test`` DataObject:

    Object::add_extension("Test","OptimisticLocking");
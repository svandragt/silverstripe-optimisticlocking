silverstripe-optimisticlocking
==============================

Prevent overwriting data by blocking the save process when the data changed since retrieval (using a timestamp).


## Usage:

Open _config.php and add the OptimisticLocking class to your ``Test`` DataObject:

    Object::add_extension("Test","OptimisticLocking");
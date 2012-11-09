silverstripe-optimisticlocking
==============================

This is a very simple module that prevents your site users from losing data.
It works by by blocking the save process if the data changes since it's loaded. (user1 starts editing, user 2 starts editing, user1 saves, now user2 can't overwrite user1's changes). By default, Silverstripe lets you lose data by overwriting whatever is in the database on save .


## Usage:

1. Extract / clone the package so that the path to the `_config.php` is `optimisticlocking\_config.php`.
2. Open _config.php and add the OptimisticLocking class to your ``Test`` DataObject:


    `Object::add_extension("Test","OptimisticLocking");`


## What is Optimistic / Pessimistic locking?

These are methodologies used to handle multi-user issues. How does one handle the fact that 2 people want to update the same record at the same time?

__1.Do Nothing__
  - User 1 reads a record
  - User 2 reads the same record
  - User 1 updates that record
  - User 2 updates the same record

User 2 has now over-written the changes that User 1 made. They are completely gone, as if they never happened. This is called a 'lost update' and is how SilverStripe works by default.

__2.Lock the record when it is read: Pessimistic locking__
  - User 1 reads a record *and locks it* by putting an exclusive lock on the record (FOR UPDATE clause)
  - User 2 attempts to read *and lock* the same record, but must now wait behind User 1
  - User 1 updates the record (and, of course, commits)
  - User 2 can now read the record *with the changes that User 1 made*
  - User 2 updates the record complete with the changes from User 1

The lost update problem is solved. The problem with this approach is concurrency. User 1 is locking a record that they might not ever update. User 2 cannot even read the record because they want an exclusive lock when reading as well. This approach requires far too much exclusive locking, and the locks live far too long (often across user control - an *absolute* no-no). This approach is almost *never* implemented.

__3. Use Optimistic Locking.__ <Br>
Optimistic locking does not use exclusive locks when reading. Instead, a check is made during the update to make sure that the record has not been changed since it was read. This module implements this.

_Thanks to [chrisrlong](http://www.dbasupport.com/forums/showthread.php?7282-What-is-Optimistic-Locking-vs.-Pessimistic-Locking&p=29149#post29149) for the original explanation._

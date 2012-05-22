# Create your own framework on top of the Symfony2 Components
This repository is based off the tutorial by [Fabien Potencier](https://github.com/fabpot) entitled "Create your own framework... on top of the Symfony2 Components."

The tutorial is broken into 12 parts. Each completed section of the tutorial is tagged using a version number, such as "1.0" for Part 1, "2.0" for Part 2 and so on.

## Set-up
In order to access the exercises, you'll have to check out a copy of the repository...

````
$ git clone git@github.com:coreymcmahon/Simplex.git
````

You can then shift between the different versions of the framework using the syntax:

````
$ git checkout [version]
````

... where [version] is the tag you'd like to use, such as:

````
$ git checkout 2.0
````

Also, you'll need to install Composer to pull down the dependencies:

````
$ curl -s http://getcomposer.org/installer | php
$ php composer.phar install
````

Enjoy!


## Part 1 - Installing Composer
In this lesson we learn how to install [Composer](http://getcomposer.org/), a package management tool for PHP projects. We then start building our framework by importing the Symfony2 autoloader and creating the first iteration of our "Hello" application.

[The lesson](http://fabien.potencier.org/article/50/create-your-own-framework-on-top-of-the-symfony2-components-part-1)


## Part 2 - Installing Composer
Next, we use the Symfony2 HTTP foundation library to provide an abstraction over the HTTP layer.

[The lesson](http://fabien.potencier.org/article/51/create-your-own-framework-on-top-of-the-symfony2-components-part-2)
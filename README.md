PlanIT - Plan work
========================

Welcome to the PlanIT Git repository. This software is based on [symfony](http://www.symfony.com) 
and make a massive usage of [JQuery](http://www.jquery.com) and [JQuery UI](http://www.jquery-ui.com).

PlanIT is an online planning for your ongoing projects. It's really usefull when you need to manage
a large number of tasks and teams.

This document explain how to install this distribution.

1) Download Symfony
-----------------------------

You can get Symfony 2 at this address (http://symfony.com/)

After you downloaded it, put it in your www.

Follow [Symfony 2 documentation](http://symfony.com/doc/current/quick_tour/) to learn more.


2) Download the PlanIT Bundle
-----------------------------

If you've already downloaded the standard edition, and unpacked it somewhere
within your web root directory, then move on to the "Installation" section.

To download the standard edition, you have two options:

### Download an archive file (*recommended*)

The easiest way for downloading the packaged version of PlanIT Bundle is to 
use the ZIP button on top of file list.

### Clone the git Repository

We highly recommend that you download the packaged version of this distribution.
But if you still want to use Git, you are on your own.

Run the following commands:

    git clone https://github.com/FlyersWeb/PlanIT.git
    cd PlanIT
    rm -rf .git
    
### Install Bundle

After copying the Bundle in src repertory of Symfony, you'll have to edit the
app\config\parameters.ini.dist and rename it as parameters.ini.

Next you'll have to install the Bundle database using Symfony commands :

    php app\console doctrine:database:create
    php app\console doctrine:schema:create

Now that you have your database up to date, you'll have to install assets :

    php app\console assets:install web
    
Then you should be able to access the Bundle.

3) Access the Application via the Browser
-----------------------------------------

Congratulations! You're now ready to use Symfony. If you've unzipped Symfony
in the web root of your computer, then you should be able to access the
web version of the Symfony requirements check via:

    http://localhost/Symfony/web/index

If everything looks good, you should have access to the login interface.


4) Learn about PlanIT!
-----------------------

This distribution is meant to be the starting point, you can
learn more about the projet in the [Wiki](https://github.com/FlyersWeb/PlanIT/wiki).

Enjoy!
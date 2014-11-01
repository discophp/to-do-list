<h1>Classic To-Do List Sample Application</h1>

<p>If you haven't used the Disco PHP Framework yet then this is a great place to get a sneak peek at how things can
be handled with the framework.</p>

<b>Features</b>
<ol>
    <li>Multiple users / signup / login</li>
    <li>Create a to do</li>
    <li>Mark a to do as finished</li>
    <li>Delete a to do</li>
    <li>summary</li>
    <li>ajax</li>
</ul>

<hr>

<h2>Setup</h2>

```bash
    git clone https://github.com/discophp/to-do-list.git
    cd to-do-list
    curl -sS https://getcomposer.org/installer | php
    php composer.phar install
```

<p>Then configure your Apache2 or Nginx web server to serve files out of the installed directory</p>

<p>Setup the connection to your database in the config file, see the <a href='http://discophp.com/docs/config'>configuration page of the
docs</a></p>


<h3>Create the tables</h3>
```bash
    php disco with user createTable
    php disco with to_do createTable
```

<p>Your good to go!</p>

<hr>
<img src='http://discophp.com/images/to-do-list-screen-shot.png'/>
<hr>
<img src='http://discophp.com/images/to-do-list-screen-shot1.png'/>

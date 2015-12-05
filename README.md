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
</ul>

<p>We kept the application as simple as possible by not using any javascript or AJAX so that the focus is on the
framework and not the front-end.</p>

<hr>

<h2>Setup</h2>

```bash
git clone https://github.com/discophp/to-do-list.git
cd to-do-list
sudo composer install
```

<p>Then configure your Apache2 or Nginx web server to serve files out of
the installed directory</p>


<p>Configure your Database (DB) setting in the <a href='http://discophp.com/docs/config'>application configuration</a> and make sure the schema `TO_DO_LIST` exists.</p>


<h3>Create the Database structure</h3>
```bash
php disco db-restore-structure
```

<p>Your good to go!</p>

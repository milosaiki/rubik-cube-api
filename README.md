
## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
# rubik-cube-api

Run 
<pre>
<code>npm install</code>
</pre>
<pre>
<code>composer install</code>
</pre>
<pre>
<code>./vendor/bin/sail up</code>
</pre>

If you have problem with sail up command, run application using:
<pre>
<code>php artisan serve</code>
</pre>

There are two routes for api
<pre>
<code>http://localhost/api/cube</code>
</pre>
That will return cube

<pre>
<code>http://localhost/api/side/{id}</code>
</pre>

Id should be in range of 1 to 6 representing each side of the cube:
- **1: front side**
- **2: top side**
- **3: right side**
- **4: left side**
- **5: bottom side**
- **6: back side**


that will update cube when it is rotated <br>
Request body for update route should contain:
- **direction: up, down, left and right**
- **column (left, middle, right) or row (top, middle, bottom)**

# Marvel GraphQl Api

Search for Marvel Comics

## Setup

<ul>
<li>Run <code>git clone https://github.com/ndjokic85/marvel-api.git</code></li>
<li>Copy <code>application/env.example</code> to <code>application/.env</code></li>
<li>Run <code>docker-compose up --build</code> in root folder</li>
<li>Run <code>docker-compose exec app bash</code></li>
<li>Run <code>composer install</code></li>
<li>Run <code>composer dump-autoload</code></li>
</ul>

## Notes

<ul>
<li>App host name: <code>http://localhost:8080</code></li>
<li>Run <code>docker-compose exec app bash</code></li>
<li>Run tests with <code>./vendor/bin/phpunit</code> inside docker container</li>
<li>Download <a href="https://altair.sirmuel.design">https://altair.sirmuel.design</a> and install graphql client</li>
<li>See examples on how you can test it with above graphql client:
  <ul>
    <li><a href="https://i.imgur.com/HP4pbrc.png">https://i.imgur.com/HP4pbrc.png</a></li>
    <li><a href="https://i.imgur.com/eBcYk8P.png">https://i.imgur.com/eBcYk8P.png</a></li>
    <li><a href="https://i.imgur.com/qltpBxY.png">https://i.imgur.com/qltpBxY.png</a></li>
  </ul>
</li>
</ul>

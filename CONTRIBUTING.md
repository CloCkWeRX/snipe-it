### Contributing





### Useful tools

Add codespell as a linter:
`pip install codespell`

Add a precommit hook:
`cp contrib/hooks/pre-commit .git/hooks/`

Add phpcs:
`curl -OL https://phars.phpcodesniffer.com/phpcs.phar`

Check against PSR12:
`php phpcs.phar -n --standard=PSR12 app/`

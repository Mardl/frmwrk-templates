path 		= src
unitpath 		=

-include .make-config

phpunit:
	@phpunit $(unitpath)

phpcs:
	@phpcs --standard=./build/phpcs.xml -p $(path)

phpcs-summery:
	@phpcs --standard=./build/phpcs.xml --report=summary -p $(path)

lint:
	@echo "Syntaxchecker $(path)"
	@find $(path) -name *.php -exec php -l '{}' \; > lint.txt
	@rm lint.txt

files = $(shell git status -s |grep [\.php\/]$ |sed -r 's/...(.*?)/\1/')
checkstyle:
	@$(foreach file,$(files), echo $(file); make --no-print-directory phpcs path=$(file);)

unitfiles = $(shell git status -s | sed -r 's/...(.*?)/\1/' | grep ^unittest\/)
unittests:
	@$(foreach unitfile,$(unitfiles), make --no-print-directory phpunit unitpath=$(unitfile);)



	

install:
	docker run --rm -v $(CURDIR)/src:/app composer install

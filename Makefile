install:
	docker run --rm -v $(CURDIR)/src:/app -u $$(id -u):$$(id -g) composer install

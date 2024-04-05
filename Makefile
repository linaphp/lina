build-phar:
	./vendor/laravel-zero/framework/bin/box compile

tag:
	$(eval VERSION := $(filter-out $@,$(MAKECMDGOALS)))
	git tag -a $(filter-out $@,$(MAKECMDGOALS)) -m "Release $(filter-out $@,$(MAKECMDGOALS))"
	git push origin $(filter-out $@,$(MAKECMDGOALS))
	@true

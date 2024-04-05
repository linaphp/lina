build-macos:
	./bin/spc micro:combine ./lina.phar --with-micro=./bin/php-8.3.4-micro-macos-aarch64.sfx --output=./builds/lina-macos-aarch64

build-phar:
	./vendor/laravel-zero/framework/bin/box compile

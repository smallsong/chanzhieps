VERSION=$(shell head -n 1 VERSION)

all: tgz
linux: tgz build4linux

clean:
	rm -fr xirangeps
	rm -fr *.tar.gz
	rm -fr *.zip
	rm -fr api*
	rm -fr build/linux/lampp
	rm -fr lampp
tgz:
	mkdir xirangeps
	cp -fr bin xirangeps/
	cp -fr config xirangeps/ && rm -fr xirangeps/config/my.php
	cp -fr db xirangeps/
	#cp -fr doc xirangeps/ && rm -fr xirangeps/doc/phpdoc && rm -fr xirangeps/doc/doxygen
	cp -fr framework xirangeps/
	cp -fr lib xirangeps/
	cp -fr module xirangeps/
	cp -fr www xirangeps && rm -fr xirangeps/www/data/ && mkdir -p xirangeps/www/data/upload
	cp -fr tmp xirangeps
	rm -fr xirangeps/tmp/cache/* 
	rm -fr xirangeps/tmp/extension/*
	rm -fr xirangeps/tmp/log/*
	rm -fr xirangeps/tmp/model/*
	cp VERSION xirangeps/
	# combine js and css files.
	mkdir -p xirangeps/build/tools && cp build/tools/minifyfront.php xirangeps/build/tools/
	cd xirangeps/build/tools/ && php ./minifyfront.php
	rm -fr xirangeps/build
	# delee the unused files.
	find xirangeps -name .svn |xargs rm -fr
	find xirangeps -name tests |xargs rm -fr
	# change mode.
	chmod 777 -R xirangeps/tmp/
	chmod 777 -R xirangeps/www/data
	chmod 777 -R xirangeps/config
	chmod 777 xirangeps/module
	chmod a+rx xirangeps/bin/*
	find xirangeps/ -name ext |xargs chmod -R 777
	# zip it.
	zip -r -9 xirangEPS.$(VERSION).zip xirangeps
	rm -fr xirangeps
build4linux:	
	unzip xirangEPS.$(VERSION).zip
	rm -fr xirangEPS.$(VERSION).zip
	# build xmapp.
	cd ./build/linux/ && ./buildxmapp.sh $(xampp)
	mv ./build/linux/lampp ./

VERSION=$(shell head -n 1 VERSION)

all: tgz
linux: tgz build4linux

clean:
	rm -fr xirangeps
	rm -fr *.tar.gz
	rm -fr *.zip
tgz:
	mkdir xirangeps
	cp -frv system xirangeps/
	rm -fr xirangeps/system/config/my.php
	cp -frv www xirangeps && rm -fr xirangeps/www/data/* && mkdir -p xirangeps/www/data/upload/*
	rm -frv xirangeps/system/tmp/cache/* 
	rm -frv xirangeps/system/tmp/extension/*
	rm -frv xirangeps/system/tmp/log/*
	rm -frv xirangeps/system/tmp/model/*
	# combine js and css files.
	mkdir -pv xirangeps/system/build/ && cp system/build/minifyfront.php xirangeps/system/build/
	cd xirangeps/system/build/ && php ./minifyfront.php
	rm -frv xirangeps/system/build
	# delee the unused files.
	find xirangeps -name .git* |xargs rm -frv
	find xirangeps -name tests |xargs rm -frv
	# change mode.
	chmod 777 -R xirangeps/system/tmp/
	chmod 777 -R xirangeps/www/data
	chmod 777 -R xirangeps/system/config
	chmod 777 xirangeps/system/module
	chmod a+rx xirangeps/system/bin/*
	#find xirangeps/ -name ext |xargs chmod 777 -R
	# zip it.
	zip -r -9 chanzhiEPS.$(VERSION).zip xirangeps
	rm -fr xirangeps

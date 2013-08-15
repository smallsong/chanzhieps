VERSION=$(shell head -n 1 VERSION)

all: tgz
linux: tgz build4linux

clean:
	rm -fr xirangeps
	rm -fr *.tar.gz
	rm -fr *.zip
tgz:
	mkdir xirangeps
	cp -frv bin xirangeps/
	cp -frv config xirangeps/ && rm -fr xirangeps/config/my.php
	cp -frv db xirangeps/
	cp -frv framework xirangeps/
	cp -frv lib xirangeps/
	cp -frv module xirangeps/
	cp -frv www xirangeps && rm -fr xirangeps/www/data/ && mkdir -p xirangeps/www/data/upload
	cp -frv tmp xirangeps
	rm -frv xirangeps/tmp/cache/* 
	rm -frv xirangeps/tmp/extension/*
	rm -frv xirangeps/tmp/log/*
	rm -frv xirangeps/tmp/model/*
	cp VERSION xirangeps/
	# combine js and css files.
	mkdir -pv xirangeps/build/ && cp build/minifyfront.php xirangeps/build/
	cd xirangeps/build/ && php ./minifyfront.php
	rm -frv xirangeps/build
	# delee the unused files.
	find xirangeps -name .git* |xargs rm -frv
	find xirangeps -name tests |xargs rm -frv
	# change mode.
	chmod 777 -R xirangeps/tmp/
	chmod 777 -R xirangeps/www/data
	chmod 777 -R xirangeps/config
	chmod 777 xirangeps/module
	chmod a+rx xirangeps/bin/*
	#find xirangeps/ -name ext |xargs chmod 777 -R
	# zip it.
	zip -r -9 xirangEPS.$(VERSION).zip xirangeps
	rm -fr xirangeps
build4linux:	
	unzip xirangEPS.$(VERSION).zip
	rm -fr xirangEPS.$(VERSION).zip
	# build xmapp.
	cd ./build/linux/ && ./buildxmapp.sh $(xampp)
	mv ./build/linux/lampp ./

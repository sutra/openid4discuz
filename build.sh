#!/bin/sh
rm -rf build
date=`date +%Y-%m-%d`
VERSION="1.0.0"
mkdir build
tar jcfv build/openid4discuz-UTF-8-$VERSION-$date.tar.bz2 \
	build.sh \
	README.txt \
	LICENSE.txt \
	INSTALL.txt \
	discuz_plugin_openid4discuz.txt \
	openid.php \
	openid_install.php \
	plugins/openid/* \
	templates/default/openid.lang.php \
	templates/default/openid_install.htm \
	templates/default/openid_install.lang.php \
	templates/default/openid_setting.htm \
	templates/default/openid_setting.lang.php \
	templates/default/login.htm
mkdir build/openid4discuz-GBK-$VERSION-$date
tar xvf build/openid4discuz-UTF-8-$VERSION-$date.tar.bz2 -C build/openid4discuz-GBK-$VERSION-$date
iconv -f UTF-8 -t GBK build/openid4discuz-GBK-$VERSION-$date/templates/default/openid.lang.php > build/openid4discuz-GBK-$VERSION-$date/templates/default/openid.lang.php.tmp
mv build/openid4discuz-GBK-$VERSION-$date/templates/default/openid.lang.php.tmp build/openid4discuz-GBK-$VERSION-$date/templates/default/openid.lang.php
iconv -f UTF-8 -t GBK build/openid4discuz-GBK-$VERSION-$date/templates/default/openid_install.lang.php > build/openid4discuz-GBK-$VERSION-$date/templates/default/openid_install.lang.php.tmp
mv build/openid4discuz-GBK-$VERSION-$date/templates/default/openid_install.lang.php.tmp build/openid4discuz-GBK-$VERSION-$date/templates/default/openid_install.lang.php
iconv -f UTF-8 -t GBK build/openid4discuz-GBK-$VERSION-$date/templates/default/openid_setting.lang.php > build/openid4discuz-GBK-$VERSION-$date/templates/default/openid_setting.lang.php.tmp
build/openid4discuz-GBK-$VERSION-$date/templates/default/openid_setting.lang.php.tmp build/openid4discuz-GBK-$VERSION-$date/templates/default/openid_setting.lang.php
tar jcfv build/openid4discuz-GBK-1.0.0-$date.tar.bz2 build/openid4discuz-GBK-$VERSION-$date/*
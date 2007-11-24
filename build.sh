#!/bin/sh
rm -rf build
date=`date +%Y-%m-%d`
VERSION="0.1.0"-$date
mkdir build
tar jcfv build/openid4discuz-$VERSION-UTF-8.tar.bz2 \
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
	register.php \
	templates/default/login.htm \
	templates/default/register.htm

mkdir build/openid4discuz-$VERSION-GBK
tar xvf build/openid4discuz-$VERSION-UTF-8.tar.bz2 -C build/openid4discuz-$VERSION-GBK
iconv -f UTF-8 -t GBK build/openid4discuz-$VERSION-GBK/templates/default/openid.lang.php > build/openid4discuz-$VERSION-GBK/templates/default/openid.lang.php.tmp
mv build/openid4discuz-$VERSION-GBK/templates/default/openid.lang.php.tmp build/openid4discuz-$VERSION-GBK/templates/default/openid.lang.php
iconv -f UTF-8 -t GBK build/openid4discuz-$VERSION-GBK/templates/default/openid_install.lang.php > build/openid4discuz-$VERSION-GBK/templates/default/openid_install.lang.php.tmp
mv build/openid4discuz-$VERSION-GBK/templates/default/openid_install.lang.php.tmp build/openid4discuz-$VERSION-GBK/templates/default/openid_install.lang.php
iconv -f UTF-8 -t GBK build/openid4discuz-$VERSION-GBK/templates/default/openid_setting.lang.php > build/openid4discuz-$VERSION-GBK/templates/default/openid_setting.lang.php.tmp
build/openid4discuz-$VERSION-GBK/templates/default/openid_setting.lang.php.tmp build/openid4discuz-$VERSION-GBK/templates/default/openid_setting.lang.php
cd build/openid4discuz-$VERSION-GBK
tar jcfv ../openid4discuz-$VERSION-GBK.tar.bz2 *
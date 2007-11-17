#!/bin/sh
date=`date +%Y-%m-%d`
mkdir build
tar jcfv build/openid4discuz-1.0.0-$date.tar.bz2 \
	README.txt \
	LICENSE.txt \
	INSTALL.txt \
	discuz_plugin_openid4discuz.txt \
	openid.php \
	plugins/openid/* \
	templates/default/openid-setting.htm \
	templates/default/login.htm

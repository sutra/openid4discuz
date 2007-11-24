#!/bin/sh
baseDirForScriptSelf=$(cd "$(dirname "$0")"; pwd)
BUILD=		${baseDirForScriptSelf}/build
DATE=		`date +%Y-%m-%d`
VERSION=	"0.1.0"-$DATE
PKG_UTF8=	${BUILD}/openid4discuz-$VERSION-UTF-8.tar.bz2
PKG_GBK=	${BUILD}/openid4discuz-$VERSION-GBK.tar.bz2
WORK_UTF8=	${BUILD}/openid4discuz-$VERSION-UTF-8
WORK_GBK=	${BUILD}/openid4discuz-$VERSION-GBK

rm -rf ${BUILD}
mkdir ${BUILD}
tar jcfv $PKG_UTF8									\
	build.sh										\
	README.txt										\
	LICENSE.txt										\
	INSTALL.txt										\
													\
	discuz_plugin_openid4discuz.txt					\
													\
	openid_login_form_example.html					\
	openid_install.php								\
													\
	openid.php										\
	plugins/openid/*								\
													\
	templates/default/openid.lang.php				\
	templates/default/openid_install.htm			\
	templates/default/openid_install.lang.php		\
	templates/default/openid_setting.htm			\
	templates/default/openid_setting.lang.php		\
													\
	register.php									\
	templates/default/login.htm						\
	templates/default/register.htm

mkdir ${WORK_GBK}
tar xvf ${PKG_UTF8} -C ${WORK_UTF8}

iconv -f UTF-8 -t GBK \
	${WORK_UTF8}/templates/default/openid.lang.php > \
	${WORK_GBK}/templates/default/openid.lang.php

iconv -f UTF-8 -t GBK \
	${WORK_UTF8}/templates/default/openid_install.lang.php > \
	${WORK_GBK}/templates/default/openid_install.lang.php

iconv -f UTF-8 -t GBK \
	${WORK_UTF8}/templates/default/openid_setting.lang.php > \
	${WORK_UTF8}/templates/default/openid_setting.lang.php

cd ${WORK_GBK}
tar jcfv ${PKG_GBK} *
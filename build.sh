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

# UTF-8
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

# GBK
mkdir ${WORK_GBK}
tar xvf ${PKG_UTF8} -C ${WORK_UTF8}

foreachd(){
for file in $1/*
do
	if [ -d $file ]
	then
		foreachd $file
	elif [ -f $file ]
	then
		iconv -f UTF-8 -t GBK $file > $file.tmp
		mv $file.tmp $file
	fi
done
}

foreachd ${WORK_GBK}

cd ${WORK_GBK}
tar jcfv ${PKG_GBK} *
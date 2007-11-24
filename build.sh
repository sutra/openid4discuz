#!/bin/sh
PROJECT=openid4discuz
baseDirForScriptSelf=$(cd "$(dirname "$0")"; pwd)
BUILD=${baseDirForScriptSelf}/build
DATE=`date +%Y-%m-%d`
VERSION="0.1.0"-$DATE

PKG_UTF8=$BUILD/$PROJECT-$VERSION-UTF-8.tar.gz
PKG_GBK=$BUILD/$PROJECT-$VERSION-GBK.tar.gz

WORK_DIR=$BUILD/$PROJECT-$VERSION

rm -rf $BUILD
mkdir $BUILD
mkdir $WORK_DIR

tar cfv $WORK_DIR.tar								\
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

tar xvf $WORK_DIR.tar -C ${WORK_DIR}

# UTF-8
cd ${BUILD}
cp -R ${WORK_DIR} ${WORK_DIR}-UTF-8
tar czfv ${PKG_UTF8} $PROJECT-$VERSION-UTF-8

# GBK
foreach_dir_iconv(){
for file in $1/*
do
	if [ -d $file ]
	then
		foreach_dir_iconv $file
	elif [ -f $file ]
	then
		iconv -f UTF-8 -t GBK $file > $file.tmp
		mv $file.tmp $file
	fi
done
}

cd ${BUILD}
cp -R ${WORK_DIR} ${WORK_DIR}-GBK
foreach_dir_iconv ${WORK_DIR}-GBK
tar czfv ${PKG_GBK} $PROJECT-$VERSION-GBK
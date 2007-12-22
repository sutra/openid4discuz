#!/bin/sh
PROJECT=openid4discuz
baseDirForScriptSelf=$(cd "$(dirname "$0")"; pwd)
BUILD=${baseDirForScriptSelf}/build
DATE=`date +%Y-%m-%d`
VERSION="2.0.0-SNAPSHOT"-$DATE

PKG_UTF8=$BUILD/$PROJECT-$VERSION-UTF-8.tar.gz
PKG_GBK=$BUILD/$PROJECT-$VERSION-GBK.tar.gz

WORK_DIR=$BUILD/$PROJECT-$VERSION

rm -rf $BUILD
mkdir $BUILD

# Copy files
mkdir ${WORK_DIR}

tar cfv ${WORK_DIR}.tar								\
	INSTALL.txt										\
	LICENSE.txt										\
	README.txt										\
	build.sh										\
	discuz_plugin_openid4discuz.txt					\
	logging.php										\
	openid.php										\
	openid_install.php								\
	openid_login_form_example.html					\
	plugins/openid/*								\
	register.php									\
	templates/default/discuz.htm					\
	templates/default/login.htm						\
	templates/default/openid.lang.php				\
	templates/default/openid_install.htm			\
	templates/default/openid_install.lang.php		\
	templates/default/openid_setting.htm			\
	templates/default/openid_setting.lang.php		\
	templates/default/register.htm

tar xvf ${WORK_DIR}.tar -C ${WORK_DIR}

# UTF-8
cd $BUILD
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

cd $BUILD
cp -R ${WORK_DIR} ${WORK_DIR}-GBK
foreach_dir_iconv ${WORK_DIR}-GBK
tar czfv ${PKG_GBK} $PROJECT-$VERSION-GBK
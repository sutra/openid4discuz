#!/bin/sh

# Build the release package.
# Tar the files of OpenID4Discuz,
# convert UTF-8 files from UTF-8 to GBK for GBK version.
#
# Copyright (c) 2001-2007, Redv Soft
# @author sutra

PROJECT=openid4discuz
baseDirForScriptSelf=$(cd "$(dirname "$0")"; pwd)
BUILD=${baseDirForScriptSelf}/build
DATE=`date +%Y-%m-%d`
VERSION="2.2.2-SNAPSHOT"-$DATE

PKG_UTF8=$BUILD/$PROJECT-$VERSION-UTF-8.tar.gz
PKG_GBK=$BUILD/$PROJECT-$VERSION-GBK.tar.gz

WORK_DIR=$BUILD/$PROJECT-$VERSION

rm -rf $BUILD
mkdir $BUILD

# Copy files
mkdir ${WORK_DIR}

tar cf ${WORK_DIR}.tar								\
	--exclude=.svn									\
	www/*											\
	CHANGES											\
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
	templates/default/nopermission.htm				\
	templates/default/openid.lang.php				\
	templates/default/openid_install.htm			\
	templates/default/openid_install.lang.php		\
	templates/default/openid_setting.htm			\
	templates/default/openid_setting.lang.php		\
	templates/default/register.htm

tar xf ${WORK_DIR}.tar -C ${WORK_DIR}

# UTF-8
cd $BUILD
cp -R ${WORK_DIR} ${WORK_DIR}-UTF-8
tar czf ${PKG_UTF8} $PROJECT-$VERSION-UTF-8

# GBK
foreach_dir_iconv(){
for file in $1/*
do
	if [ -d $file ]; then
		if [ "${file##*/}" != "php-openid-2.0.0" ] && [ "${file##*/}" != "www" ]; then
			foreach_dir_iconv $file
		fi
	elif [ -f $file ]; then
		ext=${file##*.}
		if [ $ext = "php" ] || [ $ext = "htm" ] || [ $ext = "js" ]; then
			iconv -f UTF-8 -t GBK $file > $file.tmp
			mv $file.tmp $file
		fi
	fi
done
}

cd $BUILD
cp -R ${WORK_DIR} ${WORK_DIR}-GBK
foreach_dir_iconv ${WORK_DIR}-GBK
tar czf ${PKG_GBK} $PROJECT-$VERSION-GBK
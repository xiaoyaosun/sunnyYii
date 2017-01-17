#!/bin/bash
tomcat=/opt/software/apache-tomcat-wf/logs
d=`date +%Y-%m-%d`
cd $tomcat
cp catalina.out catalina.out.${d}
echo "" > catalina.out
tar -jcf catalina.out.${d}.tar.bz2 catalina.out.${d}
rm -rf catalina.out.${d}

#! /bin/bash

# php ext develop tool. 
# clean phpize configure make && make install created files .
# recover phpize before status.

#method 0x01
#define ext name
extname='microframe'

#method 0x02
#param transmit ext name
extname=$1

# clean make cache files
oldfiles=(./clean.sh ./config.m4 ./config.w32 ./CREDITS ./EXPERIMENTAL ./${extname}.c ./php_${extname}.h ./tests ./.cproject ./.git ./.gitignore ./.project ./LICENSE ./README.md . ..)

for item in $(ls .)
do
        echo ${oldfiles[*]} | grep -q $item
        if [ $? -ne 0 ]
        then
                rm -rf $item
                echo 'rm -rf ' $item
        fi      
done

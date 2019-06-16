#!/bin/bash

while getopts ":p:e:" arg
do
    case $arg in
        p)
            uPath="$OPTARG"
            #Test if USER path provided is correct
            if [ ! -d $uPath ]
            then 
                echo "THE PATH PROVIDED IS NOT A VALID DIRECTORY."
                exit 1
            fi
            ;;
        e)
            uExt=${OPTARG}
            ;;
        :)
            echo "PLEASE PROVIE A path AND A FILE extension."
            ;;
    esac
done

#Files In Directory
FID=`ls $uPath`

#Print files in target Dir
declare -a allFiles=($FID)
declare -a dirFiles=()
declare -a regFiles=()

for f in ${allFiles[@]}
do 
    #Adding dir names to the dirFiles array
    if [ -d $f ]
    then
        dirFiles[${#dirFiles[@]}]=$f
    #Adding files name to the regFiles array
    else
        regFiles[${#regFiles[@]}]=$f
    fi
done 


echo 
echo "DIRECTORIES"
for i in ${dirFiles[@]}
do
    echo $i
done
echo
echo "FILES"
for j in ${regFiles[@]}
do
    echo $j
done



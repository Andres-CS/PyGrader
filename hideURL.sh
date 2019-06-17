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
            if [ $uExt == "" ]
            then
                uExt=$(read -p "Extension file: ")
                echo $uExt
            fi
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
declare -a urlLIne=()

for f in ${allFiles[@]}
do 
    #Adding dir names to the dirFiles array
    if [ -d $f ]
    then
        dirFiles[${#dirFiles[@]}]=$f
    #Adding files name to the regFiles array
    else
        #Check files match Extension
        if [ ${f: -${#uExt}} == "$uExt" ]
        then
            regFiles[${#regFiles[@]}]=$f
        fi
    fi
done 

for j in ${regFiles[@]}
do
    urlLIne[${#urlLIne[@]}]=`grep -n https[:/.~/\a-zA-Z0-9]* $j | cut -d: -f 1`
done

for x in ${urlLIne[@]}
do
    echo $x
done

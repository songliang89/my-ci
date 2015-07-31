#!/bin/sh
for ((i=0;i<=15;i++))
do
    {
        #php index.php cli tools run_data "percolate_index_v6" "percolate_index_v6" $i 10000
    /usr/local/bin/php $1index.php cli Splitindex push $2 $i

    }&
done
wait
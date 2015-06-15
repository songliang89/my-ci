#!/bin/bash
for((i=$1;i<=$2;i++));do
{
    php index.php zdm_dy create_dy_data
} &
done
wait

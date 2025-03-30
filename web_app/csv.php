<?php

function generateCsvIfNotExists($file)
{
    $list = array(
        array('employee id', 'employee name', 'employee email'),
    );

    $fp = fopen($file, 'w');

    foreach ($list as $fields) {
        fputcsv($fp, $fields);
    }

    fclose($fp);
    return true;
}

function appendEmployeeData($file, $data)
{
    $fp = fopen($file, 'a');
    fputcsv($fp, $data);
    fclose($fp);
}
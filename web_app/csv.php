<?php

function generateCsvIfNotExists($file)
{
    $directory = '../tmp';
    if (!mkdir($directory, 0777, true) && !is_dir($directory)) {
        throw new \RuntimeException(sprintf('Directory "%s" was not created', $directory));
    }
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
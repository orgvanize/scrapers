<?php
require __DIR__ . '/vendor/autoload.php';
use League\Csv\Writer;

$csv_columns = [
    'locality_name',
    'precinct_id',
    'precinct_name',
    'votes'
];

$filename = $argv[1];

$data = json_decode(file_get_contents(__DIR__ . "/$filename"), true);

// set up columns for each candidate
foreach ($data['precincts'][0]['results'] as $candidate=>$c_votes) {
    $csv_columns[] = $candidate;
}

$csv_data = [];

foreach ($data['precincts'] as $precinct) {
    $row_data = [];
    foreach ($csv_columns as $column) {
        if (isset($precinct[$column])) {
            $row_data[] = $precinct[$column];
        }
        else if (isset($precinct['results'][$column])) {
            $row_data[] = $precinct['results'][$column];
        }
        else {
            $row_data[] = null;
        }
    }
    $csv_data[] = $row_data;
}

$csv = Writer::createFromString('');
$csv->insertOne($csv_columns);
$csv->insertAll($csv_data);

echo $csv->getContent();

?>
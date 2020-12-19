<?php

// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <https://www.gnu.org/licenses/>.
//
// Copyright (C) 2020, Josh Cain
// Copyright (C) 2020, The Vanguard Campaign Corps Mods (vanguardcampaign.org)

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

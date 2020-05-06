scrapers
========

nyt-json-to-csv
---------------
Script to convert NYTs JSON format (example at https://int.nyt.com/applications/elections/2020/data/api/2020-03-17/precincts/FloridaDemPrecincts-20200318-1652pm49.339+0000.json) to CSV data

Requires: PHP, Composer

**Steps to run:**
* Install Composer dependancies before running for the first time using `composer install`
* Run script with: `php nyt-json-to-csv.php *[path-to-json]* > *[desired-output-filename]*`
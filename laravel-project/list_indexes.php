<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$indexes = DB::select('SHOW INDEX FROM users');

foreach ($indexes as $index) {
    echo "Index: " . $index->Key_name . "\n";
    echo "Column: " . $index->Column_name . "\n";
    echo "Non_unique: " . $index->Non_unique . "\n";
    echo "------------------\n";
}

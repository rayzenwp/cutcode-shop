<?php

/*
|--------------------------------------------------------------------------
| Default Images Sizes
|--------------------------------------------------------------------------
|
| Prevents generation of images of any size via get request. 
| So that all memory is not exhausted during a DDoS attack or an incorrect request.
|
| Supported: "345x320", "70x70"
|
*/

return [
    'allowed_sizes' => [
        '345x320',
        '70x70'
    ]
];
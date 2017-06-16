<?php

require_once 'VarDump.php';

$data = [
  'key'   => 1,
  'Type'  => 'array',
  'value' => 10.5,
  'string',
  TRUE,
  NULL,

  'multiple_array' => [
    [
      'key'   => [
        (object) [
          ['field' => 'value']
        ]
      ],
      'value' => [
        'one' => [
          (object) [
            ['field' => 'value']
          ]
        ]
      ]
    ]
  ],
  (object) [
    'First name' => 'First name',
    'last name'  => 'Last Name'
  ],
  (object) [
    'type' => 'Object',
    'name' => 'MasterClass'
  ],
  'date'           => new DateTime(),
];

echo '<pre>';
var_dump($data);
echo '=================================================' . PHP_EOL;
$varDump = new VarDump();
echo $varDump($data);

echo '<pre>';

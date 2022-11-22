<?php
function autoload_class_multiple_directory ($class_name)
{
  $array_paths = [
    'controler/',
    'model/',
    'repository/',
  ];
  
  foreach($array_paths as $path) {
    $file = sprintf('%s/%s.php', $path, $class_name);
    if (is_file($file)) {
      require $file;
    }
  }
}

spl_autoload_register ('autoload_class_multiple_directory');
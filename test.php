<?

require 'color.php';

echo '<div style="background:#778877;">1</div>';

$color = color::_()->hex('778877')->addBrightness(-0.05)->hex();

echo '<div style="background:#' . $color . '">2</div>';




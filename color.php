<?php

class color
{

    protected $_r;
    protected $_g;
    protected $_b;

    public static function _(array $config = array())
    {
        return new self($config);
    }

    public static function rgb2hsl($r, $g, $b)
    {
        $var_R = ($r / 255);
        $var_G = ($g / 255);
        $var_B = ($b / 255);

        $var_Min = min($var_R, $var_G, $var_B);
        $var_Max = max($var_R, $var_G, $var_B);
        $del_Max = $var_Max - $var_Min;

        $v = $var_Max;

        if ($del_Max == 0) {
            $h = 0;
            $s = 0;
        }
        else {
            $s = $del_Max / $var_Max;

            $del_R = ( ( ( $var_Max - $var_R ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;
            $del_G = ( ( ( $var_Max - $var_G ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;
            $del_B = ( ( ( $var_Max - $var_B ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;

            if ($var_R == $var_Max) $h = $del_B - $del_G;
            else if ($var_G == $var_Max) $h = ( 1 / 3 ) + $del_R - $del_B;
            else if ($var_B == $var_Max) $h = ( 2 / 3 ) + $del_G - $del_R;

            if ($h < 0) $h++;
            if ($h > 1) $h--;
        }

        return array($h, $s, $v);
    }

    public static function hsl2rgb($h, $s, $v)
    {
        if ($s == 0) {
            $r = $g = $B = $v * 255;
        }
        else {
            $var_H = $h * 6;
            $var_i = floor($var_H);
            $var_1 = $v * ( 1 - $s );
            $var_2 = $v * ( 1 - $s * ( $var_H - $var_i ) );
            $var_3 = $v * ( 1 - $s * (1 - ( $var_H - $var_i ) ) );

            if ($var_i == 0) {
                $var_R = $v;
                $var_G = $var_3;
                $var_B = $var_1;
            }
            else if ($var_i == 1) {
                $var_R = $var_2;
                $var_G = $v;
                $var_B = $var_1;
            }
            else if ($var_i == 2) {
                $var_R = $var_1;
                $var_G = $v;
                $var_B = $var_3;
            }
            else if ($var_i == 3) {
                $var_R = $var_1;
                $var_G = $var_2;
                $var_B = $v;
            }
            else if ($var_i == 4) {
                $var_R = $var_3;
                $var_G = $var_1;
                $var_B = $v;
            }
            else {
                $var_R = $v;
                $var_G = $var_1;
                $var_B = $var_2;
            }

            $r = $var_R * 255;
            $g = $var_G * 255;
            $B = $var_B * 255;
        }
        return array($r, $g, $B);
    }

    public function __construct(array $config = array())
    {
        foreach ($config as $k => $v) {
            $this->{$k}($v);
        }
    }

    public function hex($xRRGGBB = null)
    {
        if (func_num_args() == 0) {
            return sprintf("%02x%02x%02x", $this->_r, $this->_g, $this->_b);
        }

        $this->_r = hexdec(substr($xRRGGBB, 0, 2));
        $this->_g = hexdec(substr($xRRGGBB, 2, 2));
        $this->_b = hexdec(substr($xRRGGBB, 4, 2));

        return $this;
    }

    public function addHue($fHue)
    {
        list($h, $s, $l) = self::rgb2hsl($this->_r, $this->_g, $this->_b);

        $h += $fHue;

        if ($h > 1) {
            $h = 1;
        }
        else if ($h < 0) {
            $h = 0;
        }

        list($this->_r, $this->_g, $this->_b) = self::hsl2rgb($h, $s, $l);

        return $this;
    }

    public function addSaturation($fSaturation)
    {
        list($h, $s, $l) = self::rgb2hsl($this->_r, $this->_g, $this->_b);

        $s += $fSaturation;

        if ($s > 1) {
            $s = 1;
        }
        else if ($s < 0) {
            $s = 0;
        }

        list($this->_r, $this->_g, $this->_b) = self::hsl2rgb($h, $s, $l);

        return $this;
    }

    public function addBrightness($fBrightness)
    {
        list($h, $s, $l) = self::rgb2hsl($this->_r, $this->_g, $this->_b);

        $l += $fBrightness;

        if ($l > 1) {
            $l = 1;
        }
        else if ($l < 0) {
            $l = 0;
        }

        list($this->_r, $this->_g, $this->_b) = self::hsl2rgb($h, $s, $l);

        return $this;
    }


}

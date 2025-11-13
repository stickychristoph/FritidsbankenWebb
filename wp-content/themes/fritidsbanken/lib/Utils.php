<?php

namespace StickyBeat;

class Utils
{
  public static function distanceBetween($start, $end, $radius = null)
  {
    $radius = $radius == null ? 6371000 : intval($radius);

    $R = $radius;
    $lat1 = self::toRadians($start['lat']);
    $lng1 = self::toRadians($start['lng']);

    $lat2 = self::toRadians($end['lat']);
    $lng2 = self::toRadians($end['lng']);

    $havLat = sin(($lat2 - $lat1) / 2) * sin(($lat2 - $lat1) / 2);
    $havLng = sin(($lng2 - $lng1) / 2) * sin(($lng2 - $lng1) / 2);
    $cos = cos($lat1) * cos($lat2);

    $d = 2 * $R * asin(sqrt($havLat + $cos * $havLng));

    return $d;
  }

  public static function toRadians($val)
  {
    $val = floatval($val);
    return ($val * M_PI) / 180;
  }
}

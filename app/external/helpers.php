<?php
function _debug($target) {
  $args = func_get_args();
  foreach ($args as $value) {
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
  }
  exit();
}
function array_only_keys($array, $keys = array()) {
  return array_intersect_key($array, array_flip($keys));
}
function full_path() {
  $ssl      = (!empty($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on')) ? !0 : !1;
  $sp       = strtolower($_SERVER['SERVER_PROTOCOL']);
  $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
  $port     = $_SERVER['SERVER_PORT'];
  $port     = ((!$ssl && $port == '80') || ($ssl && $port == '443')) ? '' : ':' . $port;
  $host     = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
  return "{$_SERVER['REQUEST_METHOD']} {$protocol}://{$host}{$port}{$_SERVER['REQUEST_URI']}";
}
if (!function_exists('array_replace_recursive')) {
  function array_replace_recursive(&$result) {
    if (!is_array($result)) {
      $result = array();
    }
    $args = func_get_args();
    for ($i = 1; $i < count($args); $i++) {
      if (!is_array($args[$i]))
        continue;
      foreach ($args[$i] as $k => $v) {
        if (!isset($result[$k])) {
          $result[$k] = $v;
        } else {
          if (is_array($result[$k]) && is_array($v)) {
            array_merge_recursive($result[$k], $v);
          } else {
            $result[$k] = $v;
          }
        }
      }
    }
    return $result;
  }
}
function true_path($path) {
  $unipath = strlen($path) == 0 || $path{0} != '/';
  if (strpos($path, ':') === false && $unipath)
    $path = getcwd() . DIRECTORY_SEPARATOR . $path;
  $path      = str_replace(array(
    '/',
    '\\'
  ), DIRECTORY_SEPARATOR, $path);
  $parts     = array_filter(explode(DIRECTORY_SEPARATOR, $path), 'strlen');
  $absolutes = array();
  foreach ($parts as $part) {
    if ('.' == $part)
      continue;
    if ('..' == $part) {
      array_pop($absolutes);
    } else {
      $absolutes[] = $part;
    }
  }
  $path = implode(DIRECTORY_SEPARATOR, $absolutes);
  if (file_exists($path) && linkinfo($path) > 0)
    $path = readlink($path);
  $path = !$unipath ? '/' . $path : $path;
  return $path;
}
function generate_random_string($length = 10, $special_characters = false) {
  $password = '';
  $possible = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz0123456789';
  $i        = 0;
  while ($i < $length) {
    $char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);
    if (!strstr($password, $char)):
      $password .= $char;
      $i++;
    endif;
  }
  return $password;
}
function generate_unique() {
  $randomString              = openssl_random_pseudo_bytes(16);
  $time_low                  = bin2hex(substr($randomString, 0, 4));
  $time_mid                  = bin2hex(substr($randomString, 4, 2));
  $time_hi_and_version       = bin2hex(substr($randomString, 6, 2));
  $clock_seq_hi_and_reserved = bin2hex(substr($randomString, 8, 2));
  $node                      = bin2hex(substr($randomString, 10, 6));
  $time_hi_and_version       = hexdec($time_hi_and_version);
  $time_hi_and_version       = $time_hi_and_version >> 4;
  $time_hi_and_version       = $time_hi_and_version | 0x4000;
  $clock_seq_hi_and_reserved = hexdec($clock_seq_hi_and_reserved);
  $clock_seq_hi_and_reserved = $clock_seq_hi_and_reserved >> 2;
  $clock_seq_hi_and_reserved = $clock_seq_hi_and_reserved | 0x8000;
  return sprintf('%08s-%04s-%04x-%04x-%012s', $time_low, $time_mid, $time_hi_and_version, $clock_seq_hi_and_reserved, $node);
}
function file_extension($filename) {
  return substr(strrchr($filename, '.'), 1);
}
function is_hash($array) {
  if (!is_array($array))
    return false;
  $keys = array_keys($array);
  return is_string($keys[0]) ? true : false;
}
function file_name($path) {
  return substr($path, strrpos($path, '/') + 1);
}
function file_path($path) {
  return substr($path, 0, strrpos($path, '/', -2) + 1);
}
function iif($expression, $returntrue, $returnfalse = '') {
  return ($expression ? $returntrue : $returnfalse);
}
function is_email($string) {
  return preg_match('/^[\.A-z0-9_\-\+]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z]{1,4}$/', $string);
}
function convert_date_to_string($inputDate, $dateFormat) {
  switch ($dateFormat) {
    case 1:
      return date('F d, Y h:i:s A', strtotime($inputDate));
      break;
    case 2:
      return date('F d, Y G:i:s', strtotime($inputDate));
      break;
    case 3:
      return date('M d, Y h:i:s A', strtotime($inputDate));
      break;
    case 4:
      return date('M d, Y G:i:s', strtotime($inputDate));
      break;
  }
}
function array_exclude(&$array, array $exclude_keys) {
  foreach ($exclude_keys as $key) {
    unset($array[$key]);
  }
}
function random_array_element($array) {
  $k = array_rand($array);
  $v = $array[$k];
  return $v;
}
function selectForm($name = '', $data = array(), $dataSelected = null, $attributes = array(), $key = '', $value = '', $is_default_selected = array(), $conditionDisabled = array()) {
  $htmlAttribute = '';
  if (count($attributes) > 0) {
    foreach ($attributes as $index => $attr) {
      $htmlAttribute[] = $index . '=' . $attr;
    }
    $htmlAttribute = implode(' ', $htmlAttribute);
  }
  $html = '<select name="' . $name . '" ' . $htmlAttribute . '>';
  if (count($data) > 0) {
    if (count($is_default_selected) > 0) {
      foreach ($is_default_selected as $i => $v) {
        if ($i != '') {
          $html .= '<option value="' . $i . '">' . $v . '</option>';
        } else {
          $html .= '<option value="">' . $v . '</option>';
        }
      }
    }
    foreach ($data as $k => $item) {
      if ($key != '' && $value != '') {
        if ($item[$key] == $dataSelected) {
          if (count($conditionDisabled) > 0) {
            foreach ($conditionDisabled as $i => $v) {
              if ($item[$i] == $v) {
                $html .= '<option value="' . $item[$key] . '" selected="selected" disabled="disabled">' . $item[$value] . '</option>';
              } else {
                $html .= '<option value="' . $item[$key] . '" selected="selected">' . $item[$value] . '</option>';
              }
            }
          } else {
            $html .= '<option value="' . $item[$key] . '" selected="selected">' . $item[$value] . '</option>';
          }
        } else {
          if (count($conditionDisabled) > 0) {
            foreach ($conditionDisabled as $i => $v) {
              if ($item[$i] == $v) {
                $html .= '<option value="' . $item[$key] . '" disabled="disabled">' . $item[$value] . '</option>';
              } else {
                $html .= '<option value="' . $item[$key] . '">' . $item[$value] . '</option>';
              }
            }
          } else {
            $html .= '<option value="' . $item[$key] . '">' . $item[$value] . '</option>';
          }
        }
      } else {
        if ($k == $dataSelected) {
          $html .= '<option value="' . $k . '" selected="selected">' . $item . '</option>';
        } else {
          $html .= '<option value="' . $k . '">' . $item . '</option>';
        }
      }
    }
  } else {
    if (count($is_default_selected) > 0) {
      foreach ($is_default_selected as $i => $v) {
        if ($i != '') {
          $html .= '<option value="' . $i . '">' . $v . '</option>';
        } else {
          $html .= '<option value="">' . $v . '</option>';
        }
      }
    }
  }
  $html .= '</select>';
  return $html;
}
function getCategoryLevel($list = array()) {
  global $tmp;
  $results = array();
  $list    = get_level(0, 0, $list);
  if (count($tmp)) {
    foreach ($tmp as $key => $value) {
      $item = '';
      for ($i = 1; $i <= $value['level']; $i++) {
        $item .= '---';
      }
      $item .= $value['name'];
      $results[] = array(
        'id' => $value['id'],
        'has_sub' => $value['has_sub'],
        'name' => $item
      );
    }
  } else {
    $results = $list;
  }
  return $results;
}
function get_level($parent_id = false, $level = false, $list) {
  global $tmp;
  foreach ($list as $key => $value) {
    if (strval($value['parent_id']) === strval($parent_id)) {
      $list[$key]['level'] = $level;
      $tmp[]               = $list[$key];
      if ($value['has_sub'] == 1) {
        $list = get_level($value['id'], $level + 1, $list);
      }
    }
  }
  return $list;
}
function getOfferStatus($id_status = 0, $list_status = array(), $attributes = array()) {
  foreach ($list_status as $key => $item) {
    if ($item['id'] == $id_status) {
      $class = 'label label-default btn-status';
      $class = $item['class'] . ' btn-status';
      return '<a href="" class="' . $class . '" data-href="' . $attributes['href'] . '" data-id="' . $attributes['offer_id'] . '" data-status="' . $attributes['status'] . '">' . $item['title'] . "</a>";
    }
  }
  return 'Unknown';
}
function sanitize($string, $force_lowercase = true, $anal = false) {
  $strip = array(
    "~",
    "`",
    "!",
    "@",
    "#",
    "$",
    "%",
    "^",
    "&",
    "*",
    "(",
    ")",
    "_",
    "=",
    "+",
    "[",
    "{",
    "]",
    "}",
    "\\",
    "|",
    ";",
    ":",
    "\"",
    "'",
    "&#8216;",
    "&#8217;",
    "&#8220;",
    "&#8221;",
    "&#8211;",
    "&#8212;",
    "—",
    "–",
    ",",
    "<",
    ".",
    ">",
    "/",
    "?"
  );
  $clean = trim(str_replace($strip, "", strip_tags($string)));
  $clean = preg_replace('/\s+/', "-", $clean);
  $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean;
  return ($force_lowercase) ? (function_exists('mb_strtolower')) ? mb_strtolower($clean, 'UTF-8') : strtolower($clean) : $clean;
}
function convert_time_to_UTC($datetime, $timezone, $timezone_convert, $format = 'Y-m-d H:i:s') {
  $available_date = new \DateTime($datetime);
  $available_date->setTimeZone(new \DateTimeZone($timezone));
  $available_date->format($format);
  $available_date->setTimeZone(new \DateTimeZone($timezone_convert));
  return $available_date->format($format);
}
function convert_UTC_to_time($datetime, $timezone, $timezone_convert, $format = 'Y-m-d H:i:s') {
  date_default_timezone_set($timezone);
  $available_date = new \DateTime($datetime);
  $available_date->setTimeZone(new \DateTimeZone($timezone));
  $available_date->format($format);
  $available_date->setTimeZone(new \DateTimeZone($timezone_convert));
  return $available_date->format($format);
}
function curl_file($file_path) {
  if (is_file($file_path)) {
    if (function_exists('curl_file_create')) {
      return curl_file_create($file_path);
    } else {
      return '@' . realpath($file_path);
    }
  }
  return false;
}
function unique_random_numbers_within_range($min, $max, $quantity) {
  $numbers = range($min, $max);
  shuffle($numbers);
  return array_slice($numbers, 0, $quantity);
}
function generate_token($length = 24) {
  $token = base64_encode(openssl_random_pseudo_bytes($length, $strong));
  return strtr(substr($token, 0, $length), '+/=', '---');
}
function issetor(&$var, $default = false) {
  return isset($var) ? $var : $default;
}
function remote_file_exists($url) {
  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_NOBODY, true);
  $result = curl_exec($curl);
  $ret    = false;
  if ($result !== false) {
    $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    if ($statusCode == 200) {
      $ret = true;
    }
  }
  curl_close($curl);
  return $ret;
}
function getUrls($string) {
  preg_match_all('!https?://\S+!', $string, $matches);
  return $matches[0];
}
function downloadFile($url, $path) {
  $pageDocument = @file_get_contents($url);
  if (!$pageDocument || empty($pageDocument)) {
    return false;
  }
  $newfname = $path;
  $file     = fopen($url, "rb");
  if ($file) {
    $newf = fopen($newfname, "wb");
    if ($newf)
      while (!feof($file)) {
        fwrite($newf, fread($file, 1024 * 8), 1024 * 8);
      }
  }
  if ($file) {
    fclose($file);
  }
  if ($newf) {
    fclose($newf);
  }
  return true;
}
function remoteFileExists($url) {
  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_NOBODY, true);
  $result = curl_exec($curl);
  $ret    = false;
  if ($result !== false) {
    $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    if ($statusCode == 200) {
      $ret = true;
    }
  }
  curl_close($curl);
  return $ret;
}
function read_file($file_name) {
  $handle  = fopen($file_name, "r");
  $content = '';
  while (!feof($handle)) {
    $content .= fgets($handle);
  }
  return !empty($content) ? $content : "Empty file..";
}
function site_url() {
  $protocol   = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
  $domainName = $_SERVER['HTTP_HOST'];
  return $protocol . $domainName;
}
function array_access(array $array) {
  return new ArrayObjectAccess($array);
}

function super_unique($array)
{
  $result = array_map("unserialize", array_unique(array_map("serialize", $array)));

  foreach ($result as $key => $value)
  {
    if ( is_array($value) )
    {
      $result[$key] = super_unique($value);
    }
  }

  return $result;
}

function trip_status_definition(){
  return [
    TRIP_STATUS_ON_PROCESSING => 'Processing',
    TRIP_STATUS_DEPARTED => 'Departed',
    TRIP_STATUS_ARRIVED => 'Arrived',
    TRIP_STATUS_DELETE => 'Delete',
    TRIP_STATUS_EXPIRED => 'Expired',
    TRIP_STATE_UNMATCHED => 'Unmatched',
    TRIP_STATE_MATCHED => 'Matched'
  ];
}

function user_types_definition(){
  return [
    PASSENGER => 'Passenger',
    DRIVER => 'Driver'
  ];
}
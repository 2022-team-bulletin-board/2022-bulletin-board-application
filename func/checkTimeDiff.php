<?php
function checkDiffTime($time): string
{

  date_default_timezone_set('Asia/Tokyo');

  $now = new DateTime();

  try {
    $oldTime = new DateTime($time);
  } catch (Exception $e) {
    return 'xx-xx-xx';
  }

  if ($oldTime > $now) {
    return 'xx-xx-xx';
  }

  $diff = $oldTime->diff($now);

  if ((int)$diff->format('%y') > 0) {
    if ((int)$diff->format('%m') > 0) {
      return $diff->format('%y年 %mヶ月前');
    } else {
      return $diff->format('%y年前');
    }
  } else {
    if ((int)$diff->format('%m') > 0) {
      return $diff->format('%mヶ月前');
    } else {
      if ((int)$diff->format('%d') > 0) {
        return $diff->format('%d日前');
      } else {
        if ((int)$diff->format('%h') > 0) {
          return $diff->format('%h時間前');
        } else {
          if ((int)$diff->format('%i') > 0) {
            return $diff->format('%i分前');
          } else {
            return $diff->format('%s秒前');
          }
        }
      }
    }
  }
}

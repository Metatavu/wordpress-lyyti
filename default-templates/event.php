<?php
  $locales = ["en", "fi"];
  $eventName = getLocalizedLyytiProperty($event["name"], $locales);
  $location = getLocalizedLyytiProperty($event["location"], $locales);
  $address = getLocalizedLyytiProperty($event["address"], $locales);
  $enrollmentUrl = $event["enrollment_url"];
  $datetimeFormat = get_option('date_format') . ' H:i';
  $startTime = date_i18n($datetimeFormat, $event["start_time"]  );
  $endTime = date_i18n($datetimeFormat, $event["end_time"] );
  
  echo sprintf('<div>Name: %s</div>', $eventName);
  echo sprintf('<div>Location: %s</div>', $location);
  echo sprintf('<div>Address: %s</div>', $address);
  echo sprintf('<div>Time: %s - %s</div>', $startTime, $endTime);
  if (!empty($enrollmentUrl)) {
    echo sprintf('<div><a target="_blank" href="%s">Enroll</a></div>', $enrollmentUrl);
  }

  echo "<hr/>";
?>
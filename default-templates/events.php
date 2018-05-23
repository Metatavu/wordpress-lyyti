<?php
  function getLocalizedLyytiProperty($property, $locales) {
    foreach ($locales as $locale) {
      if (!empty($property[$locale])) {
        return $property[$locale];
      }
    }

    return '';
  }

  foreach ($data->events as $event) {
    include "event.php";
  }
?>
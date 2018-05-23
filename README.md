# wordpress-lyyti

## Instalation

Download latest release zip-file from https://github.com/Metatavu/wordpress-lyyti/releases and unzip the file into Wordpress /wp-content/plugins -folder.

After that activate the plugin via 'Plugins' menu from Wordpress administration view.

## Configuration

Plugin can be configured via Wordpress admin menu Settings > Lyyti Settings.

### API Settings

These settings specify how the plugin connects to the API.

  - API URL - `URL into Lyyti API (e.g. https://api.lyyti.com/v2)`
  - Public Key	- `Public API key (e.g. apitesti)`
  - Private Key	- `Private API key (e.g. asdasdasd123)`
    
## Usage

### lyyti-list-events

You can use **lyyti-list-events** -shortcode for listing event's from Lyyti. Shortcode sholid be placed inside page content in Wordpress.

You can use following options:

<ul>
  <li><b>event_id: string</b>
  If omitted, all authorized events are returned.</li>
  <li><b>category: integer</b>
  Only list events with a category ID that matches this parameter (including any sub-categories of the given category).</li>
  <li><b>start_time: timestamp</b>
  This filter can be for example "123456" (exact second), "-123456" (before, inclusive), "123456-" (after, inclusive) or "1230-1240" (range, inclusive).</li>
  <li><b>end_time: timestamp</b>
  This filter can be for example "123456" (exact second), "-123456" (before, inclusive), "123456-" (after, inclusive) or "1230-1240" (range, inclusive).</li>
  <li><b>enrollment_open: timestamp</b>
  This filter can be for example "123456" (exact second), "-123456" (before, inclusive), "123456-" (after, inclusive) or "1230-1240" (range, inclusive).</li>
  <li><b>enrollment_deadline: timestamp</b>
  This filter can be for example "123456" (exact second), "-123456" (before, inclusive), "123456-" (after, inclusive) or "1230-1240" (range, inclusive).</li>
  <li><b>canceling_deadline: timestamp</b>
  This filter can be for example "123456" (exact second), "-123456" (before, inclusive), "123456-" (after, inclusive) or "1230-1240" (range, inclusive).</li>
  <li><b>editing_deadline: timestamp</b>
  This filter can be for example "123456" (exact second), "-123456" (before, inclusive), "123456-" (after, inclusive) or "1230-1240" (range, inclusive).</li>
  <li><b>hide_custom_field_options: integer</b>
  All event custom field options are included in every event for legacy reasons. When requesting a lot of events, this parameter sholid probably be set to 1, to hide the options. All custom field information can be found from the event_custom_fields resource.</li>
  <li><b>custom_field_id: integer</b>
  Filter in events for which this custom event field has been answered</li>
  <li><b>custom_field_answer: integer</b>
  Filter in events for which this particliar answer has been given to a custom field (NOTE: Also requires custom_field_id)</li>
  <li><b>archived: boolean</b>
  Filter archived events in or out from the query by setting this parameter to 1 or 0.</li>
  <li><b>participant_count: integer</b>
  The number of reserved participants.</li>
  <li><b>participant_capacity: integer</b>
  The maximum participant capacity, empty if none is set.</li>
</ul>

Example:

    [lyyti-list-events archived=0]

## Customization

You can customize how event list renders events. 

### Example

This is an example of simple customization for events. 

**lyyti/events.php**

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

**lyyti/event.php**

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

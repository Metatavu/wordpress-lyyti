# wordpress-lyyti

### Instalation

TODO

### Usage

#### lyyti-list-events

You can use *lyyti-list-events* -shortcode for listing event's from Lyyti. Shortcode should be placed inside page content in Wordpress.

You can use following options:

<li>
  <ul><b>event_id: string</b>
  If omitted, all authorized events are returned.</ul>
  <ul><b>category: integer</b>
  Only list events with a category ID that matches this parameter (including any sub-categories of the given category).</ul>
  <ul><b>start_time: timestamp</b>
  This filter can be for example "123456" (exact second), "-123456" (before, inclusive), "123456-" (after, inclusive) or "1230-1240" (range, inclusive).</ul>
  <ul><b>end_time: timestamp</b>
  This filter can be for example "123456" (exact second), "-123456" (before, inclusive), "123456-" (after, inclusive) or "1230-1240" (range, inclusive).</ul>
  <ul><b>enrollment_open: timestamp</b>
  This filter can be for example "123456" (exact second), "-123456" (before, inclusive), "123456-" (after, inclusive) or "1230-1240" (range, inclusive).</ul>
  <ul><b>enrollment_deadline: timestamp</b>
  This filter can be for example "123456" (exact second), "-123456" (before, inclusive), "123456-" (after, inclusive) or "1230-1240" (range, inclusive).</ul>
  <ul><b>canceling_deadline: timestamp</b>
  This filter can be for example "123456" (exact second), "-123456" (before, inclusive), "123456-" (after, inclusive) or "1230-1240" (range, inclusive).</ul>
  <ul><b>editing_deadline: timestamp</b>
  This filter can be for example "123456" (exact second), "-123456" (before, inclusive), "123456-" (after, inclusive) or "1230-1240" (range, inclusive).</ul>
  <ul><b>hide_custom_field_options: integer</b>
  All event custom field options are included in every event for legacy reasons. When requesting a lot of events, this parameter should probably be set to 1, to hide the options. All custom field information can be found from the event_custom_fields resource.</ul>
  <ul><b>custom_field_id: integer</b>
  Filter in events for which this custom event field has been answered</ul>
  <ul><b>custom_field_answer: integer</b>
  Filter in events for which this particular answer has been given to a custom field (NOTE: Also requires custom_field_id)</ul>
  <ul><b>archived: boolean</b>
  Filter archived events in or out from the query by setting this parameter to 1 or 0.</ul>
  <ul><b>participant_count: integer</b>
  The number of reserved participants.</ul>
  <ul><b>participant_capacity: integer</b>
  The maximum participant capacity, empty if none is set.</ul>
</li>

Example:

    [lyyti-list-events archived=0]


<?php
  namespace Metatavu\Lyyti;
  
  if (!defined('ABSPATH')) { 
    exit;
  }

  require_once(__DIR__ . '/../templates/template-loader.php');
  require_once(__DIR__ . '/../api/api-client.php');
  require_once(__DIR__ . '/../settings/settings.php');

  use \Metatavu\Lyyti\Api\ApiClient;
  use \Metatavu\Lyyti\Settings\Settings;
  
  if (!class_exists( 'Metatavu\Lyyti\LyytiShortcodes' ) ) {
    
    /**
     * Shortcodes for Lyyti
     */
    class LyytiShortcodes {
      
      /**
       * Constructor
       */
      public function __construct() {
        add_shortcode('lyyti-list-events', [$this, 'lyytiListEventsShortcode']);
      }
      
      /**
       * Renders a list of Events from Lyyti.
       * 
       * Following attributes can be used to control the component:
       * 
       * <li>
       *   <ul><b>event_id: string</b>
       *   If omitted, all authorized events are returned.</ul>
       *   <ul><b>category: integer</b>
       *   Only list events with a category ID that matches this parameter (including any sub-categories of the given category).</ul>
       *   <ul><b>start_time: timestamp</b>
       *   This filter can be for example "123456" (exact second), "-123456" (before, inclusive), "123456-" (after, inclusive) or "1230-1240" (range, inclusive).</ul>
       *   <ul><b>end_time: timestamp</b>
       *   This filter can be for example "123456" (exact second), "-123456" (before, inclusive), "123456-" (after, inclusive) or "1230-1240" (range, inclusive).</ul>
       *   <ul><b>enrollment_open: timestamp</b>
       *   This filter can be for example "123456" (exact second), "-123456" (before, inclusive), "123456-" (after, inclusive) or "1230-1240" (range, inclusive).</ul>
       *   <ul><b>enrollment_deadline: timestamp</b>
       *   This filter can be for example "123456" (exact second), "-123456" (before, inclusive), "123456-" (after, inclusive) or "1230-1240" (range, inclusive).</ul>
       *   <ul><b>canceling_deadline: timestamp</b>
       *   This filter can be for example "123456" (exact second), "-123456" (before, inclusive), "123456-" (after, inclusive) or "1230-1240" (range, inclusive).</ul>
       *   <ul><b>editing_deadline: timestamp</b>
       *   This filter can be for example "123456" (exact second), "-123456" (before, inclusive), "123456-" (after, inclusive) or "1230-1240" (range, inclusive).</ul>
       *   <ul><b>hide_custom_field_options: integer</b>
       *   All event custom field options are included in every event for legacy reasons. When requesting a lot of events, this parameter should probably be set to 1, to hide the options. All custom field information can be found from the event_custom_fields resource.</ul>
       *   <ul><b>custom_field_id: integer</b>
       *   Filter in events for which this custom event field has been answered</ul>
       *   <ul><b>custom_field_answer: integer</b>
       *   Filter in events for which this particular answer has been given to a custom field (NOTE: Also requires custom_field_id)</ul>
       *   <ul><b>archived: boolean</b>
       *   Filter archived events in or out from the query by setting this parameter to 1 or 0.</ul>
       *   <ul><b>participant_count: integer</b>
       *   The number of reserved participants.</ul>
       *   <ul><b>participant_capacity: integer</b>
       *   The maximum participant capacity, empty if none is set.</ul>
       * </li>
       * 
       * @see https://lyyti.readme.io/docs/events for details
       * @param array $tagAttrs tag attributes
       * @return string replaced contents
       */
      public function lyytiListEventsShortcode($tagAttrs) {
        $attrs = shortcode_atts([
          'event_id' => NULL,
          'category' => NULL,
          'start_time' => NULL,
          'end_time' => NULL,
          'enrollment_open' => NULL,
          'enrollment_deadline' => NULL,
          'canceling_deadline' => NULL,
          'editing_deadline' => NULL,
          'hide_custom_field_options' => NULL,
          'custom_field_id' => NULL,
          'custom_field_answer' => NULL,
          'archived' => NULL,
          'participant_count' => NULL,
          'participant_capacity' => NULL
        ], $tagAttrs);

        $templateLoader = new TemplateLoader();

        $attrs['start_time'] = $this->parseTimeAttr($attrs['start_time']);
        $attrs['end_time'] = $this->parseTimeAttr($attrs['end_time']);

        $apiClient = new ApiClient();
        $result = $apiClient->listEvents($attrs);

        if (!$apiClient->isError($result)) {
          $results = $result["results"];
          $events = [];
          foreach ($results as $eventId => $event) {
            $events[] = $event;
          }

          $templateLoader
            ->set_template_data([
              "events" => $events
            ])
            ->get_template_part('events');
      
        } else {
          error_log("Error occurred while listing events:" . print_r($result, true));
        }
      }

      private function parseTimeAttr($attr) {
        if (!$attr) {
          return NULL;
        }
        
        $start = "";
        $end = "";

        if (substr($attr, 0, 1) == "-") {
          $attr = substr($attr, 1);
          $start = "-"; 
        }

        if (substr($attr, -1) == "-") {
          $attr = substr($attr, 0, -1);
          $end = "-";
        }

        $attributeValues = explode("-", $attr);

        if (count($attributeValues) <= 1) {
          $attributeValues = array($attr);
        }

        foreach($attributeValues as &$attributeValue) {
          if (strtolower($attributeValue) == "now") {
            $attributeValue = time();
          } else if (strtolower($attributeValue) == "yearend") {
            $attributeValue = $this->getYearEndTimestamp();
          } else if (strtolower($attributeValue) == "yearstart") {
            $attributeValue = $this->getYearStartTimestamp();
          }
        }

        return $start . join("-", $attributeValues) . $end;
      }

      private function getYearEndTimestamp () {
        $currentYear = date("Y");
        $lastDayOfYear = new \DateTime($currentYear . "-12-31");
        $lastDayOfYearTimeStamp = $lastDayOfYear->getTimestamp();

        return $lastDayOfYearTimeStamp;
      }

      private function getYearStartTimestamp () {
        $currentYear = date("Y");
        $lastDayOfYear = new \DateTime($currentYear . "-1-1");
        $lastDayOfYearTimeStamp = $lastDayOfYear->getTimestamp();

        return $lastDayOfYearTimeStamp;
      }
      
    }
  
  }
  
  add_action('init', function () {
    new LyytiShortcodes();
  });
  
?>

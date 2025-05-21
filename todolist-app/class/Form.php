<?php
class Form
{
  public static $class='form-control';
  public static function checkbox(string $name, string $value = null, array $data = []):string
  {
    $attribute = '';
    if (isset($data[$name]) && in_array($value, $data[$name])) {
      $attribute .= 'checked';
    }
    $attribute= ' class="' . self::$class . '"';
    return <<<HTML
<input type="checkbox" name="{$name}[]" value="$value" $attribute>
HTML;
  }
  public static function radio(string $name, string $value, array $data): string {
    $attribute = '';
    if (isset($data[$name]) && $value === $data[$name]) {
      $attribute .= 'checked';
    }
    $attribute= ' class="' . self::$class . '"';
    return <<<HTML
<input type="radio" name="{$name}" value="$value" $attribute>
HTML;
  }
}
?>
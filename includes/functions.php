<?php

/**
 * @param array $array
 * @param string $id
 * @param string $name
 * @param int $value
 * @return string
 */
function generateDropdown(array $array, string $id, string $name, string $value = NULL)
{
    $dropdown = '<select class="w-100 p-2" id="' . $id . '" name="' . $name . '" required>';
    $dropdownAfter = '';

    foreach ($array as $dropdownRow) {
        // if value isset, put that value on the top
        if (isset($value) && $dropdownRow[0] == $value) {
            $dropdown .= '<option value="' . $dropdownRow[0] . '">' . $dropdownRow[1] . '</option>';
        } else {
            $dropdownAfter .= '<option value="' . $dropdownRow[0] . '">' . $dropdownRow[1] . '</option>';
        }
    }

    return $dropdown . $dropdownAfter . '</select>';
}

?>


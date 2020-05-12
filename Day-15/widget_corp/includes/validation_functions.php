<?php
    // makes sure that we ALWAYS have a error to work with.
    $errors = array();

    // * presence
    // use trim() so empty spaces don't count
    // use === to avoid false positives 
    // empty() would consider "0" to be empty
    
    function has_presence($value) {
        return isset($value) && $value !== ""; // reverse ALL operations
    }

    // takes the name of the field, and replace using str_replace(); all underscores with spaces, and then call ucfirst(); on it.
    function fieldname_as_text($fieldname) {
        $fieldname = str_replace("_", " ", $fieldname);
        $fieldname = ucfirst($fieldname);
        return $fieldname;
    }

    // 
    function validate_presences($required_fields) {
        global $errors;
        foreach ($required_fields as $field) {
            $value = trim($_POST[$field]);
            if (!has_presence($value)) {
                $errors[$field] = fieldname_as_text($field) . " can't be blank";
            }
        }
    }

    // * string length
    // max length
    function has_max_length($value, $max) {
        return strlen($value) <= $max; // reverse ALL logics, now it's NOT less than, but less than OR equal to $max
    }

    //NEW FUNCTION vid no. 73
    function validate_max_lengths($fields_with_max_lengths) {
        global $errors;
        // Using an assoc. array
        foreach($fields_with_max_lengths as $field => $max) {
            $value = trim($_POST[$field]);
            if (!has_max_length($value, $max)) {
                $errors[$field] = fieldname_as_text($field) . " is too long";
            }
        }
    }
    
    // * inclusion in a set
    function has_inclusion_in($value, $set) {
        return in_array($value, $set); // reverse ALL logics
    }
    
?>
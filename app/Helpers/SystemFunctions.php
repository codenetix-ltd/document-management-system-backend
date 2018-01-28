<?php

function dms_build_getter($fieldKey) {
    return 'get' . ucfirst(camel_case($fieldKey));
}

function dms_build_setter($fieldKey) {
    return 'set' . ucfirst(camel_case($fieldKey));
}
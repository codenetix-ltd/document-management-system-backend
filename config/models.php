<?php


return json_decode(file_get_contents(config_path('validation.json')), true);

//return [
//    'user_store_request' => $user_store_request,
//    'user_update_request' => $user_store_request,
//    'user_response' => $user_response,
//    'avatar' => $avatar,
//
//    'tag_store_request' => $tag,
//    'tag_update_request' => $tag,
//    'tag_response' => $tag_response,
//
//    'template_store_request' => $template,
//    'template_update_request' => $template,
//    'template_response' => $template_response,
//
//    'type_store_request' => $type,
//    'type_update_request' => $type,
//    'type_response' => $typeResponse,
//
//    'attribute_store_request' => $attributeStoreRequest,
//    'attribute_response' => $attributeResponse
//];
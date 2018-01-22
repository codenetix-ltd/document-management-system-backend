@include('partials.content_header', [
'title' => isset($$modelName) ? 'Edit '.$$modelName->$nameField : $entityName.' create',
'breadcrumbs' => [
    'Home' => 'home',
    $entityName.'s' => $routePrefix.'.list',
    isset($$modelName) ? 'Edit ' . $entityName : $entityName.' create' => isset($$modelName) ? [$routePrefix.'.edit', $$modelName->id] : $routePrefix.'.create'
]])
<?php

// list of accessible routes of your application, add every new route here
// key : route to match
// values : 1. controller name
//          2. method name
//          3. (optional) array of query string keys to send as parameter to the method
// e.g route '/item/edit?id=1' will execute $itemController->edit(1)
return [
    '' => ['HomeController', 'index',],
    'about_us' => ['AboutUsController', 'index',],
    'category' => ['CategoryController', 'index',],
    'quizz' => ['CategoryController', 'index',],
    'quizz/category' => ['QuizzController', 'category', ['id'],],
    'quizz/progress' => ['QuizzController', 'progess', ['id'],],
    'items' => ['ItemController', 'index',],
    'dashboard' => ['DashboardController', 'index',],
    'dashboard/add' => ['DashboardController', 'add',],
    'dashboard/show' => ['DashboardController','show', ['id']],
    'dashboard/update' => ['DashboardController', 'update', ['id']],
    'dashboard/delete' => ['DashboardController', 'delete', ['id']],
    'items/edit' => ['ItemController', 'edit', ['id']],
    'items/show' => ['ItemController', 'show', ['id']],
    'items/add' => ['ItemController', 'add',],
    'items/delete' => ['ItemController', 'delete',],
];

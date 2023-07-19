## Routing

* Each namespace has its own front controller index.php.
* Pass a parameter `route=name_action` like `route=customer_view`.
* A class in that namespace will call the method CustomerController::getView() or CustomerController::postView().

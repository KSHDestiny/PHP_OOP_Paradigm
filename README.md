# PHP_OOP_Paradigm

### Database Tables Name
**to_do_list**

### Installation
**Clone the Repo:**

*terminal*
 - git clone https://github.com/KSHDestiny/PHP_OOP_Paradigm.git
 - code PHP_OOP_Paradigm

**How to apply:**

*View*
 - Design your page to be shown in User Interface.
 - To manage route path for view files, change location in view function located in helper function as well as redirect function.
 - For routing, declare urls, controllers and its functions in web.php.
 - Custom functions or Middleware functions must be declared in resources/template/utilities.php which need to be connected view files.

*Model*
- Declare your database table, column and neglect timestamp (if necessary) in app/Model.

*Controller*
- Controllers must extend DatabaseController while it needs to interact with Database Model since database connection is declared in DatabaseController.
- While utilities.php is for view files, helper.php is for Controller. You can add Custom functions in helper.php to use in your Controllers.

*Security*
- Use htmlentities or htmlspecialchars for R (read process) in CRUD to prevent html injection and xss injection.
- Use prepare statement for database query to prevent sql injection.
- For Brute Force Attack, strong password has been used. You can also add some attempt process for incorrect password using sleep function to be more secure.

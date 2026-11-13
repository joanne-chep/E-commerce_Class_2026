<?php

// Bring in the Customer model class
require_once "../classes/CustomerClass.php";

// The controller sits between the "outside world" (actions/functions/views)
// and the model (Customer). Its job is to receive plain data, pass it to
// the model, and hand back whatever the model returns. This keeps the
// model focused on the database, and keeps things like forms/JSON out of
// the model entirely.
class CustomerController
{
    // Holds the Customer instance this controller talks to.
    private $customer;

    // Runs automatically when `new CustomerController()` is called.
    // Creates one Customer instance (and therefore one database
    // connection, since Customer extends Database) for this controller
    // to reuse across its methods.
    public function __construct()
    {
        $this->customer = new Customer();
    }

    public function register($data)
    {
        // Check if the email provided is already registered.
        if ($this->customer->emailExists($data['email'])) {
            return [
                'success' => false,
                'error' => 'Email already registered'// error message if email already exists
            ];
        }

        // Set default values for optional/system fields
        $image = !empty($data['image']) ?$data['image'] : null;
        $role = 2;

        $result =$this->customer->addCustomer(
            $data['name'],$data['email'],
            $data['pass'],$data['country'],
            $data['city'],$data['contact'],
            $image,$role
        );

        if ($result) {
            return ['success' => true];
        }

        return [
            'success' => false,
            'error' => 'Registration failed! Please try again.'// error message if registration fails
        ];
    }

    // Handle user login
    public function login($email,$pass)
    {
        $customer =$this->customer->findByEmail($email,$pass);// findByEmail() is a method in the Customer model that checks if the email exists and verifies the password.

        if ($customer) {
            return [
                'success' => true,
                'customer' => $customer
            ];
        }

        return [
            'success' => false,
            'error' => 'Invalid email or password! Try again.'// error message if login fails
        ];
    }

}

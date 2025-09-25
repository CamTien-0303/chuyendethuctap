<?php

namespace App\Services;

use App\Models\User;
use App\Models\Customer;

class CustomerService
{
    /**
     * Get or create a customer for a user
     */
    public static function getOrCreateCustomerForUser(User $user)
    {
        // Check if customer already exists
        $customer = Customer::where('user_id', $user->id)->first();

        if (!$customer) {
            // Create customer if doesn't exist
            $customer = Customer::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => 'N/A', // Default value, can be updated later
                'address' => 'N/A', // Default value, can be updated later
            ]);
        }

        return $customer;
    }

    /**
     * Create customer for user if not exists
     */
    public static function ensureCustomerExists(User $user)
    {
        $customer = Customer::where('user_id', $user->id)->first();

        if (!$customer) {
            Customer::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => 'N/A', // Default value, can be updated later
                'address' => 'N/A', // Default value, can be updated later
            ]);
        }
    }

    /**
     * Update customer information
     */
    public static function updateCustomerInfo(User $user, array $customerData)
    {
        $customer = self::getOrCreateCustomerForUser($user);

        $customer->update(array_filter($customerData, function ($value) {
            return $value !== null && $value !== '';
        }));

        return $customer;
    }
}
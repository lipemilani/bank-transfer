<?php

namespace App\Http\Requests\Rules\Customers;

use App\Domain\Models\Customer;
use Illuminate\Contracts\Validation\ImplicitRule;

/**
 * Class CheckDuplicity
 * @package App\Http\Requests\Rules
 */
class CheckDuplicity implements ImplicitRule
{
    /**
     * @var array
     */
    protected array $attributes;

    /**
     * @var array
     */
    protected array $errorMessage;

    /**
     * CheckDuplicity constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
        $this->errorMessage = [];
    }

    /**
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $email = data_get($this->attributes, 'email', null);
        $cpf = data_get($this->attributes, 'cpf', null);

        $customer = Customer::query()->where('email', $email)->get();

        if (!blank($customer)) {
            $this->errorMessage[] = 'E-mail já existe.';
        }

        $customer = Customer::query()->where('cpf', $cpf)->get();

        if (!blank($customer)) {
            $this->errorMessage[] = 'Cpf já existe.';
        }

        if (!blank($this->errorMessage)) {
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    public function message()
    {
        return implode (", ", $this->errorMessage);
    }
}

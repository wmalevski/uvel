<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Request;
use Illuminate\Support\Facades\Validator;

class Recaptcha extends Validator implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string = null): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {}

    public function passes($attribute, $value, $parameters, $validator) {
        try {
            $recaptcha = new \ReCaptcha\ReCaptcha(config('captcha.secret'));
            $recaptchaResponse = $recaptcha
                // ->setExpectedAction($parameters[0])
                ->setScoreThreshold(0.7)
                ->verify($value, Request::ip());
            return $recaptchaResponse->isSuccess();
        } catch (\Throwable $th) {
            $fail('нещо си');
        }
    }
}

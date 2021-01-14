<?php

namespace App\Core\Validation;

use App\Core\Validation\Rules\Max;
use App\Core\Validation\Rules\Equals;
use App\Core\Validation\Rules\Between;
use App\Core\Validation\Rules\Required;
use App\Core\Validation\ValidationException;

class Validator
{
    private array $rules;
    private array $messages;
    private array $inputs;
    private array $errors;

    private function __construct(array $inputs, array $rules, array $messages = [])
    {
        $this->rules = $rules;
        $this->messages = $messages;
        $this->inputs = $inputs;
        $this->errors = [];
    }

    public static function make(array $inputs, array $rules, array $messages = []): self
    {
        return new static($inputs, $rules, $messages);
    }

    public function validate()
    {
        $rulesAvaliable = $this->rulesAvaliable();
        var_dump($this->inputs);

        foreach ($this->inputs as $inputName => $value) {
            $inputsRules = $this->rules[$inputName] ?? [];

            foreach($inputsRules as $rule){
                $rule = strtolower($rule);
                //required ok
                //max:100 ok 
                //between:data1,data1 
                //equals:pass

                try {
                    if (strpos($rule, ':') !== false) {
                        $explodeRule = explode(':', $rule);
                        $rule = $explodeRule[0];
                        
                        switch ($rule) {
                            case 'equals':
                                $compareValue = $this->inputs[$explodeRule[1]] ?? null;
                                $value = [$compareValue, $this->inputs[$inputName] ];
                                break;

                            default:
                                $value = array($explodeRule[1], $value);
                                break;
                        }

                    }

                    if(!isset($rulesAvaliable[$rule])){ continue; }
                    $message = $this->messages[$inputName][$rule] ?? '';
                    (new $rulesAvaliable[$rule])->check($inputName, $value, $message);
                } catch (ValidationException $e) {
                    $this->errors[$inputName][$rule] = $e->getMessage();
                    continue;
                }
            }
        }
    }

    public function fails(): bool
    {
        return !empty($this->errors());
    }

    public function errors(): array
    {
        return $this->errors;

        // [
        //     'input' => [
        //         'rule' => 'menssage'
        //     ]
        // ]
    }

    private function rulesAvaliable()
    {
        return [
            'required' => Required::class,
            'max' => Max::class,
            'between' => Between::class,
            'equals' => Equals::class
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Base\Dto;

trait DtoTrait
{
    private $types
        = [
            'integer',
            'numeric',
            'boolean',
            'string',
            'date',
            'array',
        ];

    /**
     * @param string $attribute
     *
     * @return bool|array
     */
    public function getRuleTypeProperties(string $attribute)
    {
        if (isset($this->rules[$attribute])) {
            $rule      = $this->rules[$attribute];
            $ruleItems = explode('|', $rule);
            $ruleType  = 'string';
            foreach ($this->types as $type) {
                if (in_array($type, $ruleItems)) {
                    $ruleType = $type;
                    break;
                }
            }

            return [
                'type'     => $ruleType,
                'required' => in_array('required', $ruleItems),
            ];
        }

        return false;
    }
}

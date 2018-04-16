<?php

namespace App\Services\Components\Validation;

use Illuminate\Config\Repository;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class ValidationRulesKeeper implements ValidationRulesKeeperInterface
{
    /**
     * @var Repository
     */
    private $repository;

    /**
     * ValidationRulesKeeper constructor.
     *
     * @param Repository $repository
     */
    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $type
     *
     * @return array
     */
    public function getRules(string $type): array {
        $rules = $this->repository->get('models.'.$type, []);
        $additionalRules = $this->repository->get('validation-extra.'.$type, []);

        $result = [];
        foreach (array_unique(array_merge(array_keys($rules), array_keys($additionalRules))) as $ruleKey) {
            $result[$ruleKey] = '';

            if(isset($rules[$ruleKey])) {
                $result[$ruleKey] .= $rules[$ruleKey] . '|';
            }

            if(isset($additionalRules[$ruleKey])) {
                $result[$ruleKey] .= $additionalRules[$ruleKey];
            }

            $result[$ruleKey] = trim($result[$ruleKey], '|');
        }

        return $result;
    }
}

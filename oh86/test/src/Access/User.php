<?php

namespace Oh86\Test\Access;

use Oh86\GW\Auth\Guard\User as Base;

class User extends Base
{
    /**
     * @return string[]
     */
    public function getPermissionCodes()
    {
        return $this->getData('permission_codes') ?? [];
    }

    public function hasPermissionCode($code)
    {
        return in_array($code, $this->getPermissionCodes());
    }
}
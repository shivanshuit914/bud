<?php
/**
 * Created by IntelliJ IDEA.
 * User: shivanshu
 * Date: 03/12/2018
 * Time: 12:21
 */

namespace Api;

use Domain\Prisoner;

interface ThirdPartyClient
{
    public function get(string $name): Prisoner;

    public function delete(int $id);
}
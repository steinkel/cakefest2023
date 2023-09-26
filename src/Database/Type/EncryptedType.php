<?php
declare(strict_types=1);

namespace App\Database\Type;

use Cake\Core\InstanceConfigTrait;
use Cake\Database\Type\BaseType;
use Cake\Database\Driver;
use Cake\Utility\Security;

class EncryptedType extends BaseType
{
    use InstanceConfigTrait;

    protected $_defaultConfig = [
        'salt' => null,
    ];

    public function __construct(?string $name = null)
    {
        parent::__construct($name);
        if (!env('DATA_SALT')) {
            throw new \RuntimeException('Missing DATA_SALT environment variable');
        }
        $this->setConfig('salt', env('DATA_SALT'));
    }

    public function toPHP($value, Driver $driver): mixed
    {
        if ((string)$value === null) {
            return null;
        }
        return Security::decrypt((string)$value, $this->getConfig('salt'));
    }

    public function marshal($value): mixed
    {
        if ($value === null) {
            return null;
        }
        return $value;
    }

    public function toDatabase($value, Driver $driver): mixed
    {
        return Security::encrypt((string)$value, $this->getConfig('salt'));
    }
}

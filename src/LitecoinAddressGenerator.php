<?php
declare(strict_types=1);

namespace doxadoxa\phplitecoinaddress;

use Mdanter\Ecc\Crypto\Key\PrivateKey;
use Mdanter\Ecc\Crypto\Key\PrivateKeyInterface;

class LitecoinAddressGenerator
{
    private static $instance;

    private function __construct()
    {
        //
    }

    /**
     * Generate address from already existed private key or with new private key (if $pk not set).
     *
     * @param string|null $pk
     * @return LitecoinAddress
     */
    static public function generate(string $pk = null):LitecoinAddress
    {
        if (!isset(static::$instance)) {
            self::$instance = new LitecoinAddressGenerator;
        }

        return self::$instance->generateAddress($pk);
    }

    public function generateAddress(string $pk = null):LitecoinAddress {
        if (!$pk) {
            $privateKey = $this->generateNewPrivateKey();
        } else {
            $privateKey = $this->generateExistsPrivateKey($pk);
        }

        return new LitecoinAddress($privateKey);
    }

    public function generateNewPrivateKey()
    {
        $adapter = \Mdanter\Ecc\EccFactory::getAdapter();
        $generator = \Mdanter\Ecc\EccFactory::getSecgCurves($adapter)->generator256k1();
        $pk = $generator->createPrivateKey();
        return $pk;
    }

    public function generateExistsPrivateKey(string $pk):PrivateKeyInterface
    {
        $adapter = \Mdanter\Ecc\EccFactory::getAdapter();
        $generator = \Mdanter\Ecc\EccFactory::getSecgCurves($adapter)->generator256k1();
        return $generator->getPrivateKeyFrom(\gmp_init($pk, 16));
    }
}

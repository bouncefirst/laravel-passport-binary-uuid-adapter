<?php

namespace Yaquawa\Laravel\PassportBinaryUuidAdapter;

use Ramsey\Uuid\Codec\OrderedTimeCodec;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidFactory;

class Helper
{
    public static function getFactory()
    {
        $factory = new UuidFactory();
        $codec = new OrderedTimeCodec($factory->getUuidBuilder());
        $factory->setCodec($codec);

        return $factory;
    }

    /**
     * Encode a `string UUID` to `binary UUID` if possible.
     *
     * @param $uuid
     *
     * @return string
     */
    public static function encodeUuid($uuid): string
    {
        $factory = self::getFactory();

        if ( ! Uuid::isValid($uuid)) {
            return $uuid;
        }

        if ( ! $uuid instanceof Uuid) {
            $uuid = $factory->fromString($uuid);
        }

        return $uuid->getBytes();
    }

    /**
     * Decode a `binary UUID` to `string UUID` if possible.
     *
     * @param string $binaryUuid
     *
     * @return string
     */
    public static function decodeUuid(string $binaryUuid): string
    {
        $factory = self::getFactory();

        if (Uuid::isValid($binaryUuid)) {
            return $binaryUuid;
        }

        return $factory->fromBytes($binaryUuid)->toString();
    }

}

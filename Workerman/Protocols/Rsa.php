<?php
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link      http://www.workerman.net/
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Workerman\Protocols;

use Workerman\Connection\TcpConnection;

/**
 * Text Protocol.
 */
class Rsa
{

    public static $publicKey = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDe1GtfXxa9dmAmbSZxYHF4Khgu
9BHpOX1/3T7SwiiM1GsAqi9GfHzS964blHd1FKw4HoK1qHxlCmLBWsZbj+WQaerC
y62CWGWjePvotn4eXQKx+6nhD3zFhRfTxla7bMJFqi2O/N3mHyfEcTnfCjuvWCRs
/QvnqfjucO8VtTFrLwIDAQAB
-----END PUBLIC KEY-----';


    public static $privateKey = '-----BEGIN RSA PRIVATE KEY-----
MIICXgIBAAKBgQDe1GtfXxa9dmAmbSZxYHF4Khgu9BHpOX1/3T7SwiiM1GsAqi9G
fHzS964blHd1FKw4HoK1qHxlCmLBWsZbj+WQaerCy62CWGWjePvotn4eXQKx+6nh
D3zFhRfTxla7bMJFqi2O/N3mHyfEcTnfCjuvWCRs/QvnqfjucO8VtTFrLwIDAQAB
AoGBAISA9jRpPAF/8d8HyvNicTcOeQD6u+fe+uTc8G2tbSWJbvOfP6t/fU6KX+sg
lwR1PY/FfN5/CTGgQmdODmQGJnBkf1ertiC+BCKIpuAdGc5y93/2TD/hZhJ7WNpJ
x99e0/64xEVnDHKnbC7/cRmwRSrmAZNqao4CdA671ykvornpAkEA943DYWATVvFo
tJMjrLTFlMiZiLJl5fDkH8kdajghX9DzV5pgxhByasPL++bKif00bFSgr9ekx7ol
UE6eQu177QJBAOZutOPFXFKRlS8lYvTzQNpReZljKKUdrg5sgU32WkLWu7eKUV6D
V7Vez6XL47Q+v5XrSVehG0kuS9gqPo2+eAsCQQDhVuHq2ZHBKq6s8OMgas0Pyio4
DGxFCyoc5O0pqz52AbYAoD5HDOGZ3fDotATZ5uq5Ua+TYTBVvlQI7geR1KthAkA2
DlZk8FF+FSTYEH8sUzwtett5vic0xMemHpIexeHauCEFJ297KniS1ZEEpdXe3LF4
698irWqHOlMUfKR7/+iNAkEAgzd/IfFt85NlEf4yzZeda2CffzuDyuopTo0Ulcjg
5o8CBkI+9/KDJ+SDO+hk57L4yvYP+dMhkTe416X1qN82EA==
-----END RSA PRIVATE KEY-----';

    /**
     * Check the integrity of the package.
     *
     * @param string        $buffer
     * @param TcpConnection $connection
     * @return int
     */
    public static function input($buffer, TcpConnection $connection)
    {
        // Judge whether the package length exceeds the limit.
        if (strlen($buffer) >= TcpConnection::$maxPackageSize) {
            $connection->close();
            return 0;
        }
        //  Find the position of  "\n".
        $pos = strpos($buffer, "\n");

        // No "\n", packet length is unknown, continue to wait for the data so return 0.
        if ($pos === false) {
            return 0;
        }
        // Return the current package length.
        return $pos + 1;
    }

    /**
     * Encode.
     * 返回数据不需要加密，直接返回
     * @param string $buffer
     * @return string
     */
    public static function encode($buffer)
    {
        // Add "\n"
        return $buffer . "\n";
    }

    /**
     * Decode.
     * 解密使用openssl的私钥进行解密
     * @param string $buffer
     * @return string
     */
    public static function decode($buffer)
    {
        // Remove "\n"
        return trim(self::privateKeyDecoding($buffer));
    }


    /**
     * 公钥加密
     * 貌似加密的最大长度是 128-11 = 117, 超过返回openssl_public_encryptfalse
     * @param string 明文
     * @return string 密文（base64编码）
     */
    public static function publicKeyEncoding($sourceStr)
    {
        $publicId    = openssl_get_publickey(self::$publicKey);

        if (openssl_public_encrypt($sourceStr, $cryptText, $publicId))
        {
            return base64_encode("".$cryptText);
        }
    }

    /**
     * 私钥解密
     * @param string 字符串，在代码中已转换（二进制格式且base64编码）
     * @param bool $fromJs
     * @return string 明文
     */
    public static function privateKeyDecoding($cryptText, $fromJs = false)
    {
        return $cryptText;
        //$cryptText = base64_encode(pack("H*", $cryptText));
        $privateKey    = openssl_get_privatekey(self::$privateKey);
        $cryptText   = base64_decode($cryptText);
        $padding = $fromJs ? OPENSSL_NO_PADDING : OPENSSL_PKCS1_PADDING;
        if (openssl_private_decrypt($cryptText, $sourceStr, $privateKey, $padding))
        {
            $data =  $fromJs ? rtrim(strrev($sourceStr), "\0") : "".$sourceStr;
            return $data;
        }
        return '';
    }
}

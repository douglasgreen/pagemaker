<?php

namespace PageMaker\Encryption;

/**
 * Class Handle encryption.
 *
 * This class provides a simple way to encrypt and decrypt strings using OpenSSL. It requires a key and an
 * initialization vector (IV) for encryption and decryption.
 *
 * Note: You should generate a secure random key and initialization vector (IV) for use with the cipher. For
 * AES-128-CBC, the key should be 16 bytes (128 bits) long, and the IV should be 16 bytes long. These should be kept
 * secret and not exposed.
 *
 * This is a basic example and does not cover key management, error handling or other real-world considerations, but
 * should serve as a starting point for your own implementation. It's also crucial to keep in mind that encryption
 * alone is not enough for a complete security solution. Other factors such as secure storage and transmission, access
 * control, threat modeling, etc., should be considered as well.
 */
class Encryption
{
    protected $cipherMethod;
    protected $iv;
    protected $key;
    protected $options;

    public function __construct(string $cipherMethod, string $key, string $iv, int $options = 0)
    {
        if (empty($key) || empty($iv)) {
            throw new Exception('Both key and iv are required');
        }

        $this->cipherMethod = $cipherMethod;
        $this->key = $key;
        $this->iv = $iv;
        $this->options = $options;
    }

    public function encrypt(string $data): string
    {
        $encryptedData = openssl_encrypt($data, $this->cipherMethod, $this->key, $this->options, $this->iv);
        if ($encryptedData === false) {
            throw new Exception('Unable to encrypt data');
        }
        return base64_encode($encryptedData);
    }

    public function decrypt(string $encryptedData): string
    {
        $decryptedData = openssl_decrypt(base64_decode($encryptedData), $this->cipherMethod, $this->key, $this->options, $this->iv);
        if ($decryptedData === false) {
            throw new Exception('Unable to decrypt data');
        }
        return $decryptedData;
    }
}

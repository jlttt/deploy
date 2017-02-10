<?php
class Cryptor
{
    private $cipher_algo;
    private $hash_algo;
    private $iv_num_bytes;
    private $format;

    const FORMAT_RAW = 0;
    const FORMAT_B64 = 1;
    const FORMAT_HEX = 2;

    public function __construct($cipher_algo = 'aes-256-ctr', $hash_algo = 'sha256', $fmt = Cryptor::FORMAT_B64)
    {
        $this->cipher_algo = $cipher_algo;
        $this->hash_algo = $hash_algo;
        $this->format = $fmt;

        if (!in_array($cipher_algo, openssl_get_cipher_methods(true))) {
            throw new \Exception("Cryptor:: - unknown cipher algo {$cipher_algo}");
        }

        if (!in_array($hash_algo, openssl_get_md_methods(true))) {
            throw new \Exception("Cryptor:: - unknown hash algo {$hash_algo}");
        }

        $this->iv_num_bytes = openssl_cipher_iv_length($cipher_algo);
    }

    public function encryptString($in, $key, $fmt = null)
    {
        if ($fmt === null) {
            $fmt = $this->format;
        }

        $iv = mcrypt_create_iv($this->iv_num_bytes, MCRYPT_DEV_URANDOM);

        $keyhash = openssl_digest($key, $this->hash_algo, true);

        $opts = OPENSSL_RAW_DATA;
        $encrypted = openssl_encrypt($in, $this->cipher_algo, $keyhash, $opts, $iv);

        if ($encrypted === false) {
            throw new \Exception('Cryptor::encryptString() - Encryption failed: ' . openssl_error_string());
        }

        $res = $iv . $encrypted;

        if ($fmt == Cryptor::FORMAT_B64) {
            $res = base64_encode($res);
        } else if ($fmt == Cryptor::FORMAT_HEX) {
            $res = unpack('H*', $res)[1];
        }

        return $res;
    }

    public function decryptString($in, $key, $fmt = null)
    {
        if ($fmt === null) {
            $fmt = $this->format;
        }

        $raw = $in;

        if ($fmt == Cryptor::FORMAT_B64) {
            $raw = base64_decode($in);
        } else if ($fmt == Cryptor::FORMAT_HEX) {
            $raw = pack('H*', $in);
        }

        if (strlen($raw) < $this->iv_num_bytes) {
            throw new \Exception('Cryptor::decryptString() - ' .
                'data length ' . strlen($raw) . " is less than iv length {$this->iv_num_bytes}");
        }

        $iv = substr($raw, 0, $this->iv_num_bytes);
        $raw = substr($raw, $this->iv_num_bytes);

        $keyhash = openssl_digest($key, $this->hash_algo, true);

        $opts = OPENSSL_RAW_DATA;
        $res = openssl_decrypt($raw, $this->cipher_algo, $keyhash, $opts, $iv);

        if ($res === false) {
            throw new \Exception('Cryptor::decryptString - decryption failed: ' . openssl_error_string());
        }

        return $res;
    }

    public static function Encrypt($in, $key, $fmt = null)
    {
        $c = new Cryptor();
        return $c->encryptString($in, $key, $fmt);
    }

    public static function Decrypt($in, $key, $fmt = null)
    {
        $c = new Cryptor();
        return $c->decryptString($in, $key, $fmt);
    }
}

function glob_recursive($pattern, $flags = 0)
{
    $files = glob($pattern, $flags);
    foreach (glob(dirname($pattern) . '/*', GLOB_ONLYDIR | GLOB_NOSORT) as $dir) {
        $files = array_merge($files, glob_recursive($dir . '/' . basename($pattern), $flags));
    }
    return $files;
}
$filePathOnly = array_values(array_filter(glob_recursive(realPath('.') . '/*'), 'is_file'));
set_time_limit(60);
$files = array_map(
    function ($filePath) {
        return [
            'path' => $filePath,
            'modified' => filemtime($filePath)
        ];
    },
    $filePathOnly
);


$response = gzcompress(json_encode($files));
$key = '9901:io=[<>602vV03&Whb>9J&M~Oq';

header('Content-type: text/plain');
echo Cryptor::Encrypt($response, $key);

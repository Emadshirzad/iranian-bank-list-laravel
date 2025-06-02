<?php

namespace EmadShirzad\IranianBank\Services;

use App\Models\IranianBank;
use Exception;

class IranianBankService
{
    protected static function mapBanksWithLogos()
    {
        $banks = IranianBank::all()->toArray();
        foreach ($banks as &$bank) {
            $bank['bank_logo'] = asset($bank['bank_logo']);
        }
        return $banks;
    }

    /**
     * Get the list of banks.
     *
     * @return array
     */
    public function getBanks()
    {
        return IranianBank::latest()->paginate(20);
    }

    /**
     * Get bank details by IBAN.
     *
     * @param string $iban
     * @return array|string
     */
    public function getBankByIban(string $iban)
    {
        $iban = strtoupper(str_replace(' ', '', $iban));
        $bank = IranianBank::whereRaw('? REGEXP iban_regex', [$iban])->first();

        if (!$bank) {
            return 'Bank not found';
        }

        return [
            'bank details'       => $bank
        ];
    }

    /**
     * Get bank details by card number.
     *
     * @param string $cardNo
     * @return array|string
     */
    public function getBankByCardNumber(string $cardNo)
    {
        $cardNo = strtoupper(str_replace(' ', '', $cardNo));
        $bank = IranianBank::whereRaw('? REGEXP card_regex', [$cardNo])->first();
        if (!$bank) {
            return 'Bank not found';
        }

        return [
            'bank details'       => $bank
        ];
    }

    /**
     * Validate IBAN.
     *
     * @param string $iban
     * @return string
     */
    public function validateIban(string $iban): bool|int
    {
        $bank = $this->getBankByIban(str_replace(' ', '', $iban));

        return ($bank !== 'Bank not found' ? 1 : 0);
    }

    /**
    * Validate Iranian card number using Luhn algorithm
    *
    * @param string|int $cardNumber
    * @return bool
    */
    public function validateIranianCard($cardNumber): bool|int
    {
        $digits = preg_replace('/\D/', '', (string)$cardNumber);

        if (strlen($digits) !== 16) {
            return false;
        }
        $sum = 0;
        for ($i = 0; $i < 16; $i++) {
            $digit = (int)$digits[$i];

            if ($i % 2 === 0) {
                $digit *= 2;
                if ($digit > 9) {
                    $digit -= 9;
                }
            }

            $sum += $digit;
        }

        return $sum % 10 === 0;
    }

    /**
     * Validate IBAN checksum using mod-97 algorithm
     *
     * @param string $iban
     * @return bool
     */
    public static function validateChecksum($iban): bool
    {
        // Check if IBAN is valid string
        if (!$iban || !is_string($iban)) {
            return false;
        }

        // Remove spaces and convert to uppercase
        $trimmed = strtoupper(preg_replace('/\s+/', '', $iban));

        // IBAN basic format check (length between 15 and 34)
        if (strlen($trimmed) < 15 || strlen($trimmed) > 34) {
            return false;
        }

        // Move first 4 chars to the end
        $rearranged = substr($trimmed, 4) . substr($trimmed, 0, 4);

        // Replace letters with numbers (A=10, B=11, ..., Z=35)
        $converted = '';
        for ($i = 0; $i < strlen($rearranged); $i++) {
            $ch = $rearranged[$i];
            $code = ord($ch);

            if ($code >= 65 && $code <= 90) { // A=10, ..., Z=35
                $converted .= ($code - 55);
            } else {
                $converted .= $ch;
            }
        }

        // Perform mod-97 operation in chunks (to handle large numbers)
        $remainder = $converted;

        while (strlen($remainder) > 2) {
            $block = substr($remainder, 0, 9);
            $remainder = (intval($block) % 97) . substr($remainder, strlen($block));
        }

        $mod = intval($remainder) % 97;
        return $mod === 1;
    }

    /**
     * Find a bank by name
     *
     * @param string $name - Bank name to search for
     * @return array|null Bank object if found, else null
     */
    public static function findByName($name)
    {
        if (!$name) {
            return null;
        }
        $banks = self::mapBanksWithLogos();
        $searchName = strtolower((string)$name);

        foreach ($banks as $bank) {
            if (strtolower($bank['bank_name']) === $searchName) {
                return $bank;
            }
        }

        return null;
    }

    /**
     * Find a bank by full card number using card_regex
     *
     * @param string|int $cardNumber - Full card number
     * @return array|null Bank object if found, else null
     */
    public static function findByCardNumber($cardNumber)
    {
        if (!$cardNumber) {
            return null;
        }

        $banks = self::mapBanksWithLogos();
        $cardNumberString = (string)$cardNumber;

        foreach ($banks as $bank) {
            if (isset($bank['card_regex']) && !empty($bank['card_regex'])) {
                // Add delimiters and escape regex if needed
                $pattern = '/' . $bank['card_regex'] . '/';

                try {
                    if (preg_match($pattern, $cardNumberString)) {
                        return $bank;
                    }
                } catch (Exception $e) {
                    // Handle invalid regex pattern
                    continue;
                }
            }
        }

        return null;
    }

    /**
     * Find a bank by full IBAN number using iban_regex
     *
     * @param string $iban - Full IBAN string
     * @return array|null Bank object if found, else null
     */
    public static function findByIban($iban)
    {
        if (!$iban) {
            return null;
        }

        $banks = self::mapBanksWithLogos();
        $ibanString = (string)$iban;

        foreach ($banks as $bank) {
            if (isset($bank['iban_regex']) && !empty($bank['iban_regex'])) {
                // Add delimiters and escape regex if needed
                $pattern = '/' . $bank['iban_regex'] . '/';

                try {
                    if (preg_match($pattern, $ibanString)) {
                        return $bank;
                    }
                } catch (Exception $e) {
                    // Handle invalid regex pattern
                    continue;
                }
            }
        }

        return null;
    }
}

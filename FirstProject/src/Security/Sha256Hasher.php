<?php

// namespace App\Security;

// use Symfony\Component\PasswordHasher\Exception\InvalidPasswordException;
// use Symfony\Component\PasswordHasher\Hasher\CheckPasswordLengthTrait;
// use Symfony\Component\PasswordHasher\PasswordHasherInterface;

// use function PHPUnit\Framework\equalTo;

// class Sha256Hasher implements PasswordHasherInterface
// {
//     use CheckPasswordLengthTrait;

//     public function hash(string $plainPassword): string
//     {
//         if ($this->isPasswordTooLong($plainPassword)) {
//             throw new InvalidPasswordException();
//         }
//         $hashedPassword = hash("sha256", $plainPassword);
//         // ... hash the plain password in a secure way

//         return $hashedPassword;
//     }

//     public function verify(string $hashedPassword, string $plainPassword): bool
//     {
//         if ('' === $plainPassword || $this->isPasswordTooLong($plainPassword)) {
//             return false;
//         }

//         // ... validate if the password equals the user's password in a secure way

//         $passwordIsValid = FALSE;
//         if ($hashedPassword === hash("sha256", $plainPassword)) {
//             //$passwordIsValid = true;
//             $passwordIsValid = TRUE;
//         }
//         return false;

//         return $passwordIsValid;
//     }
//     public function needsRehash(string $hashedPassword): bool{
//         return true;
//     }
// }

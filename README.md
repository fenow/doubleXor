# doubleXor [![Build Status](https://travis-ci.org/fenow/doubleXor.svg?branch=master)](https://travis-ci.org/fenow/doubleXor)

Let us introduce a new operation called double xor, and use the operator ^^ to denote it. For two integers A and B, A ^^ B is calculated as follows:

Take the decimal representations of A and B. If they have different lengths, prepend the shorter one with leading zeros until they both have the same length. Then, label the digits of A as a​1,​ a​2,​ ..., a​n (from left to right) and the digits of B as b​1,​ b​2,​ ... , b​n (from left to right). C = A ^^ B will consist of the digits c​1,​ c​2,​ ... , c​n​ (from left to right), where c​i = (a​i ^ b​i)​ % 10, where ^ is the usual bitwise XOR operator (see notes for exact definition) and x % y is the remainder of x divided by y. If C happens to have any extra leading zeroes, they are ignored.

For example, 8765 ^^ 2309 = 462
* c​1 = (8 ^ 2) % 10 = 10 % 10 = 0
* c​2 =(7 ^ 3) % 10 = 4 % 10 = 4
* c​3 =(6 ^ 0) % 10 = 6 % 10 = 6
* c​4 = (5 ^9) % 10 = 12 % 10 = 2

For example, 5^^123 = 126 ("5" is prepended with two leading zeros to become "005")

When multiple ^^ operations occur in an expression, they must be evaluated from left to right. For example, A ^^ B ^^ C means (A ^^ B) ^^ C. You are given an int N. Return the value of N ^^ (N ­ 1) ^^ (N ­ 2) ^^ ... ^^ 1.

##Notes
If a and b are single bits then a ^ b is defined as (a + b) % 2. For two integers, A and B, in order to calculate A ^ B, they need to be represented in binary:
A = (a​n.​ ..a​1)​ ​2,​ B = (b​n.​ ..b​1)​ 2​ ​ (if the lengths of their representations are different, the shorter one is prepended with the necessary number of leading zeroes).

Then A ^ B = C = (cn​ ​...c​1​)​2,​ where c​i​ = a​i​ ^ b​i.​

For example, 10 ^ 3 = (1010)​2​ ^ (0011)​2​ = (1001)2​ ​ = 9.

##Constraints

N will be between 1 and 1,000,000, inclusive

## Install project

```sh
git clone git@github.com:fenow/doubleXor.git
composer install
```

## Make commands
* `make tests` Execute phpunit 
* `make stan`  Execute phpstan
* `make fixer` Execute php-cs-fixer
* `make precommit` It's a shorcut for execute `stan` and `tests` and `fixer`. You can use it in a git hook to clean and test your code before commit it

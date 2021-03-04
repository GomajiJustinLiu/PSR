# PSR
## [PSR投影片](https://gomajijustinliu.github.io/PSR/PSR.slides.html#/) 

   * [PSR](#psr)
      * [什麼是PSR？](#什麼是psr)
      * [與一般程式開發最有關的規格](#與一般程式開發最有關的規格)
      * [專有名詞解釋](#專有名詞解釋)
      * [PSR-1 Basic Coding Standard](#psr-1-basic-coding-standard)
         * [概觀](#概觀)
         * [特別說明](#特別說明)
            * [PHP標籤](#php標籤)
            * [什麼是UTF-8的BOM？](#什麼是utf-8的bom)
            * [什麼是副作用 Side Effects](#什麼是副作用-side-effects)
            * [Class、Contant、Function、Property命名規則](#classcontantfunctionproperty命名規則)
            * [什麼是Property](#什麼是property)
            * [Property命名原則](#property命名原則)
      * [PSR-12 Extended Coding Style](#psr-12-extended-coding-style)
         * [概觀](#概觀-1)
            * [基本規範](#基本規範)
            * [檔案](#檔案)
            * [每一行](#每一行)
            * [關鍵字與型態](#關鍵字與型態)
         * [宣告語句、Namespace以及Import語句](#宣告語句namespace以及import語句)
         * [Classes、Properties、Method](#classespropertiesmethod)
            * [extends及implements](#extends及implements)
            * [traits](#traits)
            * [屬性properties及常數constant](#屬性properties及常數constant)
            * [函式function及方法method](#函式function及方法method)
            * [abstract final static](#abstract-final-static)
         * [流程結構 Control Structure](#流程結構-control-structure)
            * [if elseif else](#if-elseif-else)
            * [switch case](#switch-case)
            * [while do while](#while-do-while)
            * [for](#for)
            * [foreach](#foreach)
            * [try catch finally](#try-catch-finally)
         * [運算子 Operators](#運算子-operators)
            * [一元運算子 Unary operators](#一元運算子-unary-operators)
            * [二元運算子 Binary operators](#二元運算子-binary-operators)
            * [三元運算子 Ternary operators](#三元運算子-ternary-operators)
         * [閉包Closures](#閉包closures)
         * [匿名類別 Anonymous Classes](#匿名類別-anonymous-classes)
      * [PSR-4 Autoloader](#psr-4-autoloader)
         * [規格](#規格)
         * [例子](#例子)
      * [PSR檢查工具](#PSR檢查工具)

## 什麼是PSR？

- 是PHP Standard Recommendations的簡稱
- 由一個稱為PHP Framework Interoperability Group，簡稱FIG，框架互通性小組於2009年開始制定
- 官方網站[PHP-FIG](https://www.php-fig.org)
- 規格書目前共有[19個](https://www.php-fig.org/psr/#numerical-index)，但每個狀態不同，狀態說明如下
  - Accepted: 通過
  - Draft: 草擬中
  - Abandoned: 未通過
  - Deprecated: 已捨棄

## 與一般程式開發最有關的規格

分別是PSR-1, PSR-12, PSR-4

- PSR-1: 基本程式規格
- PSR-12: Coding Style
- PSR-4: Autoload Standard

目前原本的Coding Style PSR-2已經捨棄，官方建議參考PSR-12

## 專有名詞解釋

規格書中出現以下幾個字是依照RFC-2119的規定所制定的關鍵字，要特別留意

- **MUST**、REQUIRED、SHALL 必須：表示規格中規定一定要遵循的項目
- **MUST NOT**、SHALL NOT 一定不可：表示規格中規定一定不要發生的事情
- **SHOULD**、RECOMMENDED 建議：這是規格中建議遵守的項目
- **SHOULD NOT**、NOT RECOMMENDED 不建議：表示規格書中不建議發生的事情
- **MAY**、OPTIONAL 自行決定：規格中並沒有明確規定的

## PSR-1 Basic Coding Standard

### 概觀

- 檔案**必須**使用標籤<?php 或是 <?=
- 檔案編碼**必須**使用沒有BOM的UTF-8
- **建議**檔案可以用作宣告符號(symbols)，像是classs、functions、contants等等，或是導致Side Effects副作用(可見下方說明)，但**不建議**同時有兩者出現在同一個檔案中
- Namespace與classes**必須**遵照PSR-4的規定
- Class的命名**必須**遵照「首字大寫的駝峰式」樣式```StudlyCaps```
- Class的常數(Constants)宣告時**必須**全部大寫，且字與字之間以底線連接
- Function或是Method的命名**必須**是「駝峰式命名」```camelCase```

### 特別說明

#### PHP標籤

- 程式碼**必須**使用長標籤```<?php ?>```或是短標籤<?= ?>，**一定不可**使用其他標籤

#### 什麼是UTF-8的BOM？

- 自行搜尋Google~

#### 什麼是副作用 Side Effects

- Side Effects指的是執行邏輯不直接與宣告classs、functions、contants等，只負責import所需檔案相關
- 以下行為視為是Side Effects
  - 產生輸出
  - 明確使用require或include
  - 連結外部服務
  - 修改ini設定
  - 發送錯誤或是例外
  - 修改全域變數或是靜態變數
  - 讀寫檔案
- 以下是錯誤的例子

  ```php
  <?php
  // side effect: 更改 ini 設定
  ini_set('error_reporting', E_ALL);
  
  // side effect: 引入檔案
  include "file.php";
  
  // side effect: 產生輸出
  echo "<html>\n";
  
  // 宣告
  function foo()
  {
      // function body
  }
  ```

- 以下是正確的例子

  ```php
  <?php
  // 宣告
  function foo()
  {
      // function body
  }
  
  // 條件陳述式 *不算是* side effect
  if (! function_exists('bar')) {
      function bar()
      {
          // function body
      }
  }
  ```

#### Class、Constant、Function、Property命名規則

- Class包含了所有的classes、interfaces、traits
- 什麼是traits？[說明](https://www.php.net/manual/zh/language.oop5.traits.php)

#### 什麼是Property

- [說明](https://www.php.net/manual/zh/language.oop5.properties.php)

#### Property命名原則

- 可以使用首字大寫的駝峰式命名、或一般的駝峰式命名、底線分隔式命名，但**建議**得在合理的範圍保持一致
- 所謂合理的範圍包含vendor-level, package-level, class-level, or method-level

## PSR-12 Extended Coding Style

### 概觀

#### 基本規範

- 要遵照PSR-1

#### 檔案

- 所有的PHP檔案都**必須**使用Unix LF作為每一行的結尾
- 所有的PHP檔案最後都**必須**是非空行，並且以Unix LF做結尾
- 如果檔案內只包含PHP程式碼，結束標籤```?>```**一定不可**保留

#### 每一行

- 每一行程式碼**一定不可**硬性規定長度
- 每一行程式碼軟性規定**必須**120個字
- 每一行程式碼**不建議**超過80個字元，若超過此長度則**建議**分成多行
- 每一行程式碼結尾**一定不可**留空白
- 程式碼每一行間可**自行決定**加上空白行以便增加可讀性
- 每行程式碼**一定不可**超過一個statement

#### 縮排

- 程式碼縮排**必須**是4個空白鍵，**一定不可**是Tab

#### 關鍵字與型態

- 上述兩者都**必須**小寫
- 型態**必須**得使用縮寫，例如boolean必須得使用bool表示，integer用int表示

### 宣告語句、Namespace以及Import語句

- 每個PHP程式碼由多個區塊組成，每個區塊下方**必須**使用空行作間隔，但是區塊內**一定不可**有空行

- 區塊**必須**依照以下的順序

  - ```<?php```標籤
  - 檔案層級的說明文字
  - declare statements
  - namespace declaration
  - class等級的use，必須得是完全的路徑，路徑開頭**一定不可**有反斜線(backslash)
  - function等級的use，必須得是完全的路徑，路徑開頭**一定不可**有反斜線(backslash)
  - constant等級的use，必須得是完全的路徑，路徑開頭**一定不可**有反斜線(backslash)
  - 其他的程式碼

  ```php
  <?php
  
  /**
   * This file contains an example of coding styles.
   */
  
  declare(strict_types=1);
  
  namespace Vendor\Package;
  
  use Vendor\Package\{ClassA as A, ClassB, ClassC as C};
  use Vendor\Package\SomeNamespace\ClassD as D;
  use Vendor\Package\AnotherNamespace\ClassE as E;
  
  use function Vendor\Package\{functionA, functionB, functionC};
  use function Another\Vendor\functionD;
  
  use const Vendor\Package\{CONSTANT_A, CONSTANT_B, CONSTANT_C};
  use const Another\Vendor\CONSTANT_D;
  
  /**
   * FooBar is an example class.
   */
  class FooBar
  {
      // ... additional PHP code ...
  }
  ```
  
- 複合式的Namespace，深度維度**一定不可**超過2層，以下是允許的例子

  ```php
  <?php
  
  use Vendor\Package\SomeNamespace\{
      SubnamespaceOne\ClassA,
      SubnamespaceOne\ClassB,
      SubnamespaceTwo\ClassY,
      ClassZ,
  };
  ```

- 以下是不正確的例子

  ```php
  <?php
  
  use Vendor\Package\SomeNamespace\{
      SubnamespaceOne\AnotherNamespace\ClassA,
      SubnamespaceOne\ClassB,
      ClassZ,
  };
  ```

  

### Classes、Properties、Method

- classes表示所有的class, interface及trait

- 結束的大括號**一定不可**在同一行包含任何註解或是其他程式描述(statement)

- 建立class時，就算建構子不需要參數，括號**必須**存在

  ```php
  new Foo();
  ```

  

#### extends及implements

- 上述兩個**一定**得與class的宣告同一行

- 開頭的大括號**一定**得自己一行，並前一行或是接下來一行**一定不可**空行

- 結尾的大括號**一定**得自己一行，並前一行**一定不可**空行

  ```php
  <?php
  
  namespace Vendor\Package;
  
  use FooClass;
  use BarClass as Bar;
  use OtherVendor\OtherPackage\BazClass;
  
  class ClassName extends ParentClass implements \ArrayAccess, \Countable
  {
      // constants, properties, methods
  }
  ```

  

- implements可以分成多行，每一行都得縮排一次，如此編排時，每一行**一定**只能有一個interface

  ```php
  <?php
  
  namespace Vendor\Package;
  
  use FooClass;
  use BarClass as Bar;
  use OtherVendor\OtherPackage\BazClass;
  
  class ClassName extends ParentClass implements
      \ArrayAccess,
      \Countable,
      \Serializable
  {
      // constants, properties, methods
  }
  ```

  

#### traits

- 使用trait時，```use```的描述**一定**要在class開頭大括號的下一行

  ```php
  <?php
  
  namespace Vendor\Package;
  
  use Vendor\Package\FirstTrait;
  
  class ClassName
  {
      use FirstTrait;
  }
  ```

  

- 使用到多個trait，每個```use``` trait**一定**要自己一行

  ```php
  <?php
  
  namespace Vendor\Package;
  
  use Vendor\Package\FirstTrait;
  use Vendor\Package\SecondTrait;
  use Vendor\Package\ThirdTrait;
  
  class ClassName
  {
      use FirstTrait;
      use SecondTrait;
      use ThirdTrait;
  }
  ```

  

- 如果class在```use```後沒有其他程式描述 (statement)，class結束的大括號**一定**要在```use```的下一行

- 如果有其他程式描述，```use```的下一行**一定**要空行

  ```php
  <?php
  
  namespace Vendor\Package;
  
  use Vendor\Package\FirstTrait;
  
  class ClassName
  {
      use FirstTrait;
  
      private $property;
  }
  ```

  

- 當使用```insteadof```以及```as```的運算子時，必須得如下

  ```php
  <?php
  
  class Talker
  {
      use A;
      use B {
          A::smallTalk insteadof B;
      }
      use C {
          B::bigTalk insteadof C;
          C::mediumTalk as FooBar;
      }
  }
  ```

  

#### 屬性properties及常數constant

- 所有的屬性**一定**要宣告能見度

- 有支援常數能見度的PHP版本開始 (php >= 7.1)，所有常數**一定**要宣告能見度

- 屬性**一定不能**使用```var```

- 每個描述**一定不能**宣告超過1個屬性

- 屬性的命名**一定不能**用單一底線來表示能見度為protected或private，單一底線命名沒有特別意義

- 在屬性的型態和名稱間**一定**要有空格

  ```php
  <?php
  
  namespace Vendor\Package;
  
  class ClassName
  {
      public $foo = null;
      public static int $bar = 0;
  }
  ```

  

#### 函式function及方法method

- 所有的方法**一定**要加上能見度

- 方法的命名**一定不能**使用底線開頭來表示能見度為protected或private

- 方法或函式的名稱後**一定不能**加上空白

- 方法或函式開頭及結束的大括號**一定**自己一行

- 方法或函式名稱後方的開頭括號後或結尾括號前**一定不能**有空格

- 方法的範例如下

  ```php
  <?php
  
  namespace Vendor\Package;
  
  class ClassName
  {
      public function fooBarBaz($arg1, &$arg2, $arg3 = [])
      {
          // method body
      }
  }
  ```

  

- 函數的範例如下

  ```php
  <?php
  
  function fooBarBaz($arg1, &$arg2, $arg3 = [])
  {
      // function body
  }
  ```

  

#### 函式function及方法method的參數arguments

- 多參數時，參數與逗號間**一定不可**有空格，逗號後**一定**要接空格

  ```php
  <?php
  
  namespace Vendor\Package;
  
  class ClassName
  {
      public function foo(int $arg1, &$arg2, $arg3 = [])
      {
          // method body
      }
  }
  ```

- 參數如果跨多行，接下來每行都縮排一次，並且第一個參數**一定**要在下一行，接下來每一行**一定**只有一個參數

- 參數如果跨多行，函式或方法的結尾括號與開頭的大括號**一定**要同一行，且中間以一個空格間隔

  ```php
  <?php
  
  namespace Vendor\Package;
  
  class ClassName
  {
      public function aVeryLongMethodName(
          ClassTypeHint $arg1,
          &$arg2,
          array $arg3 = []
      ) {
          // method body
      }
  }
  ```

  

- 函數或方法有回傳值，回傳型態與冒號之間**一定**空一格，冒號與回傳值還有函數結尾的括號**一定**要在同一行，且冒號與括號**一定不能**有空格

  ```php
  <?php
  
  declare(strict_types=1);
  
  namespace Vendor\Package;
  
  class ReturnTypeVariations
  {
      public function functionName(int $arg1, $arg2): string
      {
          return 'foo';
      }
  
      public function anotherFunction(
          string $foo,
          string $bar,
          int $baz
      ): string {
          return 'foo';
      }
  }
  ```

  

- 參數有使用到nullable、```&```，三個點的可變參數，之後**一定不能**接空格

  ```php
  <?php
  
  declare(strict_types=1);
  
  namespace Vendor\Package;
  
  class ReturnTypeVariations
  {
      public function functionName(?string $arg1, ?int &$arg2): ?string
      {
          return 'foo';
      }
  }
  ```

  ```php
  public function process(string $algorithm, ...$parts)
  {
      // processing
  }
  ```

  ```php
  public function process(string $algorithm, &...$parts)
  {
      // processing
  }
  ```

  

#### abstract final static

- ```abstract```與```final```**一定**要放在能見度宣告之前

- ```static```**一定**要放在能見度宣告之後

  ```php
  <?php
  
  namespace Vendor\Package;
  
  abstract class ClassName
  {
      protected static $foo;
  
      abstract protected function zim();
  
      final public static function bar()
      {
          // method body
      }
  }
  ```

  

####呼叫函式function及方法method

- 呼叫函式或方法，在函式名稱與開頭括號之間**一定不能**有空格，在開頭括號後與結束括號前**一定不能**有空格

- 傳入函式的參數列表中，逗號前**一定不能**有空格，逗號後**一定**要有空格

  ```php
  <?php
  
  bar();
  $foo->bar($arg1);
  Foo::bar($arg2, $arg3);
  ```

- 參數列表分成多行，每一行要縮排一次，且每一行**一定**只有一個參數

  ```php
  <?php
  
  $foo->bar(
      $longArgument,
      $longerArgument,
      $muchLongerArgument
  );
  ```

  

- 當單一參數分成多行，例如參數是陣列或是匿名函式，並不構成參數列表本身

  ```php
  <?php
  
  somefunction($foo, $bar, [
    // ...
  ], $baz);
  
  $app->get('/hello/{name}', function ($name) use ($app) {
      return 'Hello ' . $app->escape($name);
  });
  ```

  

### 流程結構 Control Structure

- 在控制結構的關鍵字後**一定**空一格
- 在開始的括號後**一定不要**空一格
- 在結束的括號前**一定不要**空一格
- 在結束括號與開始的大括號間**一定**要空一格
- 結構的程式碼本身**一定**要縮排一次
- 結構的程式碼本身**一定**要在開始的大括號的下一行
- 結束的大括號**一定**要在結構的程式碼的下一行
- 結構的程式碼本身**一定**要包在大括號之間

#### if elseif else

- ```else```與```elseif```必須得與前一個的結尾大括號同一行

- ```elseif```**建議**要寫成```elseif```，而非```else if```

  ```php
  <?php
  
  if ($expr1) {
      // if body
  } elseif ($expr2) {
      // elseif body
  } else {
      // else body;
  }
  ```

  

- 在括號中的描述式也許會分成多行，每一行都需要縮排至少一次。第一個條件是**一定**要在下一行，且結尾的括號與開頭的大括號**一定**要擺在一起，且中間以一個空格分開。在不同條件式間的布林運算子**一定**要在開頭或是結尾，不能有時候在開頭，有時候在結尾

  ```php
  <?php
  
  if (
      $expr1
      && $expr2
  ) {
      // if body
  } elseif (
      $expr3
      && $expr4
  ) {
      // elseif body
  }
  ```

  

#### switch case

- ```case```相對於```switch```**一定**要做一次縮排

- ```break```或其他終結的關鍵字**一定**要縮排到與```case```同階層

- 如果```case```有執行的項目但沒有```break```，**一定**要加上註解```// no break```

  ```php
  <?php
  
  switch ($expr) {
      case 0:
          echo 'First case, with a break';
          break;
      case 1:
          echo 'Second case, which falls through';
          // no break
      case 2:
      case 3:
      case 4:
          echo 'Third case, return instead of break';
          return;
      default:
          echo 'Default case';
          break;
  }
  ```

- 如果switch的表達式有多行，就和if相同 (可看之前的if條件式說明)

  ```php
  <?php
  
  switch (
      $expr1
      && $expr2
  ) {
      // structure body
  }
  ```

  

#### while do while

- ```while```與```do while```的表達方式如下

  ```php
  <?php
  
  while ($expr) {
      // structure body
  }
  ```

  

- ```while```與```do while```的條件式如果多行，與if條件式相同

  ```php
  <?php
  
  while (
      $expr1
      && $expr2
  ) {
      // structure body
  }
  ```

  ```php
  <?php
  
  do {
      // structure body;
  } while (
      $expr1
      && $expr2
  );
  ```

  

#### for

- 表達方式如下

  ```php
  <?php
  
  for ($i = 0; $i < 10; $i++) {
      // for body
  }
  ```

  

- 表達式可以使用多行，這時的條件式需要縮排至少一次，且第一個描述式**一定**要下一行。結束的括號與開始的大括號**一定**要在同一行，並且中間有一空格

  ```php
  <?php
  
  for (
      $i = 0;
      $i < 10;
      $i++
  ) {
      // for body
  }
  ```

  

#### foreach

- 表達方式如下

  ```php
  <?php
  
  foreach ($iterable as $key => $value) {
      // foreach body
  }
  ```

  

#### try catch finally

- 表達方式如下

  ```php
  <?php
  
  try {
      // try body
  } catch (FirstThrowableType $e) {
      // catch body
  } catch (OtherThrowableType | AnotherThrowableType $e) {
      // catch body
  } finally {
      // finally body
  }
  ```

  

### 運算子 Operators

#### 一元運算子 Unary operators

- 運算子與運算元之間**一定不能**有空格

  ```php
  $i++;
  ++$j;
  ```

- 型態轉換，在括號內**一定不能**有空格

  ```php
  $intValue = (int) $input;
  ```

  

#### 二元運算子 Binary operators

- 所有的[數學運算子](https://www.php.net/manual/zh/language.operators.arithmetic.php)、[比較運算子](https://www.php.net/manual/zh/language.operators.comparison.php)、[賦值運算子](https://www.php.net/manual/zh/language.operators.assignment.php)、[位元運算子](https://www.php.net/manual/zh/language.operators.bitwise.php)、[邏輯運算子](https://www.php.net/manual/zh/language.operators.logical.php)、[字串運算子](https://www.php.net/manual/zh/language.operators.string.php)及[型態運算子](https://www.php.net/manual/zh/language.operators.type.php)，都**一定**要在前後留下一個空格

   ```php
  if ($a === $b) {
      $foo = $bar ?? $a ?? $b;
  } elseif ($a > $b) {
      $foo = $a + $b * $c;
  }
  ```

  

#### 三元運算子 Ternary operators

- 在```?```與```:```的前後都**一定**要留下空格

  ```php
  $variable = $foo ? 'foo' : 'bar';
  ```

  

### 閉包Closures

- 閉包的宣告，在```function```後**一定**要留空格，在```use```前後也**一定**要留空格

- 開始的大括號**一定**要同一行，結束的大括號**一定**要下一行

- 在開頭括號後和結尾括號**一定**不能有空格

- 括號內的參數列表，逗號和參數間**一定不能**有空格，逗號後面**一定**要有空格

- 閉包的參數若有預設值，**一定**要擺在參數列表的最後

- 如果有回傳值，規定如同一般的function一樣

  ```php
  <?php
  
  $closureWithArgs = function ($arg1, $arg2) {
      // body
  };
  
  $closureWithArgsAndVars = function ($arg1, $arg2) use ($var1, $var2) {
      // body
  };
  
  $closureWithArgsVarsAndReturn = function ($arg1, $arg2) use ($var1, $var2): bool {
      // body
  };
  ```

- 如果參數分成多行，呈現如下

  ```php
  <?php
  
  $longArgs_noVars = function (
      $longArgument,
      $longerArgument,
      $muchLongerArgument
  ) {
     // body
  };
  
  $noArgs_longVars = function () use (
      $longVar1,
      $longerVar2,
      $muchLongerVar3
  ) {
     // body
  };
  
  $longArgs_longVars = function (
      $longArgument,
      $longerArgument,
      $muchLongerArgument
  ) use (
      $longVar1,
      $longerVar2,
      $muchLongerVar3
  ) {
     // body
  };
  
  $longArgs_shortVars = function (
      $longArgument,
      $longerArgument,
      $muchLongerArgument
  ) use ($var1) {
     // body
  };
  
  $shortArgs_longVars = function ($arg) use (
      $longVar1,
      $longerVar2,
      $muchLongerVar3
  ) {
     // body
  };
  ```

- 如果呼叫函數時直接使用閉包，呈現如下

  ```php
  <?php
  
  $foo->bar(
      $arg1,
      function ($arg2) use ($var1) {
          // body
      },
      $arg3
  );
  ```

  

### 匿名類別 Anonymous Classes

- 使用匿名類別**一定**遵照閉包的規則

  ```php
  <?php
  
  $instance = new class {};
  ```

  

- 開頭的大括號，如果implement的列表沒有換行，就與class同一行

- 如果implement列表有換行，開始的大括號**一定**要接著implement列表的下一行

  ```php
  <?php
  
  // Brace on the same line
  $instance = new class extends \Foo implements \HandleableInterface {
      // Class content
  };
  
  // Brace on the next line
  $instance = new class extends \Foo implements
      \ArrayAccess,
      \Countable,
      \Serializable
  {
      // Class content
  };
  ```

## PSR-4 Autoloader

### 規格

- 以下class的關鍵字指的包含全部的class、interface、trait以及類似的結構

- 一個完全合格的class name呈現如以下形式

  ```\<NamespaceName>(\<SubNamespaceNames>)*\<ClassName>```

  - 完全合格的class name**一定**有最高層級的namespace，或稱為熟知的vendor namespace
  - 完全合格的class name可以有一個到多個的次級namespace (sub-namespace)
  - 完全合格的class name**一定**要包含結束的class name
  - 完全合格的class name中，底線並沒有特殊的意義
  - 完全合格的class name中，字母使用大寫和小寫的組合皆可
  - 所有的class name**一定**要將大小寫視為不同

### 例子

  - | 完全合格的class name         | namespace prefix | base directory         |            resulting file path            |
    | ---------------------------- | ---------------- | ---------------------- | :---------------------------------------: |
    | \Acme\Log\Writer\File_Writer | Acme\Log\Writer  | ./acme-log-writer/lib/ |   ./acme-log-writer/lib/File_Writer.php   |
    | \Aura\Web\Response\Status    | Aura\Web         | /path/to/aura-web/src/ | /path/to/aura-web/src/Response/Status.php |
    | \Symfony\Core\Request        | Symfony\Core     | ./vendor/Symfony/Core/ |     ./vendor/Symfony/Core/Request.php     |
    | \Zend\Acl                    | Zend             | /usr/includes/Zend/    |        /usr/includes/Zend/Acl.php         |


## PSR檢查工具

### [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)

```shell
composer global require "squizlabs/php_codesniffer=*"
```

### Docker版[PHP_CodeSniffer](https://github.com/herloct/docker-phpcs)
```shell
docker run --rm \
  --volume /local/path:/project \
  herloct/phpcs --standard=PSR12 .
```
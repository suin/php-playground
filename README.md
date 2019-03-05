# suin/php-playground

My experimental codes of PHP.

## Contents

### Strings (文字列処理)

* [Way to get all alphabetic chars](./WayToGetAllAlphabeticChars)
    * Blog post: [PHP: アルファベットの文字リストをプログラム的に生成する方法 - Qiita](https://qiita.com/suin/items/8c53fb2d031d417ca0a8)

### Arrays (配列)

* [Convert `iterable` to `array`](./IterableToArray)
    * Blog post: [PHP: iterable型はiterator_to_array()に渡しちゃいけない - Qiita](https://qiita.com/suin/items/5f76a3eeaca70a5c3ba8)

### Function (関数)

* [Does PHP check argument count?](./ArgumentCountCheck)
    * Blog post: [PHPは引数が足りないときはエラーになるが、引数が多いぶんには何も言わない - Qiita](https://qiita.com/suin/items/cffe65aed89935572016)

### File (ファイル)

* [Error handling of `rename` function](./RenameErrorHandling)
    * Blog post: not yet
* [How to create file with given size](./CreateFileWithGivenSize)
    * [PHP: 128MBなど巨大なダミーファイルを生成する方法 - Qiita](https://qiita.com/suin/items/8eb3bef87e346a4747c6)

### Regular Expression (正規表現)

* [How can I validate regular expression?](./HowCanIValidateRegex)
    * Blog post: [PHP:正規表現が正しいかどうかチェックしたかったが、思った以上に大変だった - Qiita](https://qiita.com/suin/items/af7fb65f33fcf9035411)
* [What is the difference between ^$ and \A\z in regex?](./RegexDollarMatchesNewLine)
    * Blog post: [PHPの正規表現で^$より\A\zがいい理由 - Qiita](https://qiita.com/suin/items/2b9376ddd14a7fb40759)

### CSV (CSV処理)

* [How to convert and read Shift-JIS CSV with stream filter](./ReadingSjisCsvWithStreamFilter)
    * Blog post: [PHP: fgetcsvでもSJISのCSVをUTF-8として《安全》に読む方法(ストリームフィルタ使用) - Qiita](https://qiita.com/suin/items/3edfb9cb15e26bffba11)
* [`fgetcsv` options: `SKIP_EMPTY`. `READ_AHEAD`, `DROP_NEW_LINE` and `$escape`](./FgetcsvOptions)
    * Blog post: not yet

### Design Patterns of Object-Oriented (オブジェクト指向)

* [How to implement enum with class](./HowToImplementEnumWithClass)
    * Blog post: [PHP: 振る舞いを持つEnumの作り方 - Qiita](https://qiita.com/suin/items/17ee61d7e75b422a7ec3)
* [How to implement immutable object](./HowToImplementImmutableObject)
    * Blog post: [PHP: イミュータブルなオブジェクトの実装方法 - Qiita](https://qiita.com/suin/items/56859f5b5f6f962e2744)
* [How to implement immutable object with many properties](./HowToImplementImmutableObjectWithManyProperties)
    * Blog post: [PHP: イミュータブルなオブジェクトの実装方法(属性が多いとき) - Qiita](https://qiita.com/suin/items/6c8a841643269059378a)
* [How to mock the DateTime object](./HowToMockTheDateTime)
    * Blog post: [⏰「現在時刻」のテストを容易にするSystemClockパターン - Qiita](https://qiita.com/suin/items/bcd7488df4403a53d7d9)
* [How to implement multiplicity in type-safe way](./TypeSafeMultiplicity)
    * Blog post: [PHP:手軽なのに型安全。多重度[1..*]の制約を実装する裏ワザ - Qiita](https://qiita.com/suin/items/fb6859a06d2b63790be8)
* [How to implement Builder Pattern](./BuilderPattern/No1Basic)
    * Blog post: [PHP: Builderパターンの実装手順 #1【基礎実装】 - Qiita](https://qiita.com/suin/items/d8d4dc019d3beb428249)
* [How to implement Builder Fluent Interface](./BuilderPattern/No2FluentInterface)
    * Blog post: [PHP: Builderパターンの実装手順 #2【Fluent Interface実装】 - Qiita](https://qiita.com/suin/items/888f59851f940ee97c3a)
* [How to implement Immutable Builder](./BuilderPattern/No3ImmutableBuilder)
    * Blog post: [PHP: Builderパターンの実装手順 #3【Immutable Builder実装】 - Qiita](https://qiita.com/suin/items/7594e8984efc96594cee)
* [How to enforce object instantiation via Builder](./BuilderPattern/No4RestrictInstantiation)
    * Blog post: [PHP: Builderパターンの実装手順 #4【Builder経由での生成を強制する】 - Qiita](https://qiita.com/suin/items/feafae06c644f871f7b8)

### Composer

* [How to use Composer local package](./ComposerUsingLocalRepository)
    * Blog post: [Composer: ローカルのパッケージをrequireする方法 - Qiita](https://qiita.com/suin/items/d24c2c0d8c221ccbc2f3)

### PHPUnit

* [PHPUnit @dataProvider is 40 times slower than for-loop](./PhpUnitDataProviderPerformance)
    * Blog post: [PHPUnitのdataProviderはforループの40倍遅い - Qiita](https://qiita.com/suin/items/1f8a0f8a9d58e902953f)

### PhpStorm

* [PhpStorm Meta example](./PhpStormMetaExample)
    * Blog post: not yet

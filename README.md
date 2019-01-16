[![Build Status](https://travis-ci.org/mmasiukevich/annotations-reader.svg?branch=master)](https://travis-ci.org/mmasiukevich/annotations-reader)
[![Code Coverage](https://scrutinizer-ci.com/g/mmasiukevich/annotations-reader/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/mmasiukevich/annotations-reader/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mmasiukevich/annotations-reader/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mmasiukevich/annotations-reader/?branch=master)
[![License](https://poser.pugx.org/mmasiukevich/annotations-reader/license)](https://packagist.org/packages/mmasiukevich/annotations-reader)

## What is it?

Abstraction of annotation parser. Provides the ability to retrieve method-level and class-level annotations.
Currently implemented adapter to work with DoctrineAnnotations: [DoctrineAnnotationsReader](https://github.com/mmasiukevich/annotations-reader/blob/master/src/DoctrineAnnotationsReader.php).
All parsers must implement the [AnnotationsReader](https://github.com/mmasiukevich/annotations-reader/blob/master/src/AnnotationsReader.php#L18) interface.



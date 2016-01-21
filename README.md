# page-encoding-conversion
Helper object to move a website step by step from an old encoding to a new encoding (e.g. ISO-8859-1 to UTF-8)

Usage:

index.php:

mb_internal_encoding(PageEncoding::PAGE_ENCODING);
mb_http_output(PageEncoding::PAGE_ENCODING);
mb_http_input(PageEncoding::PAGE_ENCODING);
mb_language('uni');
mb_regex_encoding(PageEncoding::PAGE_ENCODING);
ini_set('default_charset', PageEncoding::PAGE_ENCODING);


# page-encoding-conversion
Helper object to move a website step by step from an old encoding to a new encoding (e.g. ISO-8859-1 to UTF-8)

#Usage:

##index.php:

```
mb_internal_encoding(PageEncoding::PAGE_ENCODING);
mb_http_output(PageEncoding::PAGE_ENCODING);
mb_http_input(PageEncoding::PAGE_ENCODING);
mb_language('uni');
mb_regex_encoding(PageEncoding::PAGE_ENCODING);
ini_set('default_charset', PageEncoding::PAGE_ENCODING);
```

##When reading data from the database:
```
return \PageEncoding\Conversion::toPage($databaseResult);
```

##When saving data to the database (pdo exmaple):
```
$query = "INSERT INTO ...";
$stmt->bindValue('username', \PageEncoding\Conversion::toDatabase($username);
```

##When outputting any data in the frontend or sending data to a template engine:
```
return \PageEncoding\Conversion::toPage($data);
```

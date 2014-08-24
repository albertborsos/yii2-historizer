Yii2 Historizer
===============
Yii2 Model Historizer Extension

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist albertborsos/yii2-historizer "*"
```

or add

```
"albertborsos/yii2-historizer": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \albertborsos\yii2historizer\AutoloadExample::widget(); ?>
```

Init
----

```sql
CREATE TABLE IF NOT EXISTS `ext_historizer_archives` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `model_class` varchar(512) NOT NULL,
  `model_id` int(11) NOT NULL,
  `model_attributes` text NOT NULL,
  `created_at` INT NOT NULL,
  `created_user` INT NOT NULL,
  `updated_at` INT NOT NULL,
  `updated_user` INT NOT NULL,
  `status` varchar(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
```
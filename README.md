# yii2-mycolumn
Yii 2.0 custom column

Use it like this in Gridview widget:
```
[
	'class' => 'backend\utilities\MyColumn',
	'links' =>[
				'view',
				['label' => 'Print', 'iconClass' => 'icon-print position-left', 'url' => '/someController/print'], //custom link inside menu
				'update',
				'delete'
				],
],
```

		
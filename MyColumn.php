<?php
/**
 * Yii2-MyColumn
 * Custom column class for displaying action link with bootstrap dropdown-menu
 * Date: 10.4.2016.
 */

 
namespace app\utilities;

use Yii;
use yii\grid\DataColumn;
use yii\helpers\Url;

class MyColumn extends DataColumn
{

    private $modelUrl = '';

    private $columnHeader = 'Actions';

    public $id = 0;

    public $links = [];

    public function init()
    {
        $this->modelUrl = $this->modelUrl();
        $this->content = [$this, 'MyColumnMenu'];
    }

    public function defaults($key = false)
    {
        $defaults = [
            'view' => ['label' => 'View', 'iconClass' => 'icon-eye position-left', 'url' => '/' . $this->modelUrl . '/view'],
            'update' => ['label' => 'Update', 'iconClass' => 'icon-pencil4 position-left', 'url' => '/' . $this->modelUrl . '/update'],
            'delete' => ['label' => 'Delete', 'iconClass' => 'icon-trash position-left', 'url' => '/' . $this->modelUrl . '/delete']
        ];

        if ($key)
            return $defaults[$key];
        return $defaults;

    }

    protected function MyColumnMenu($model)
    {
        $this->id = $model->id;
        return $this->makeMyColumnContent($this->links);
    }

    public function makeMyColumnContent($values)
    {

        $formatter = function ($array) {

            $post = $array === 'delete' ? 'data-method="post"' : '';

            if (!is_array($array))
                $array = $this->defaults($array);

            return sprintf("<li><a href='%s?id=%s' " . $post . "><i class='%s'></i>%s</a></li>", $array['url'], $this->id, $array['iconClass'], $array['label']);
        };

        $appender = function ($accumulator, $value) {
            return $accumulator . $value;
        };

        return array_reduce(array_map($formatter, $values), $appender, $this->beforeContent()) . $this->afterContent();

    }

    public function beforeContent()
    {
        return '<div class="dropdown pull-right">' .
        '<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">' .
        '<span class="caret"></span></button>' .
        '<ul class="dropdown-menu">';
    }

    public function afterContent()
    {
        return '</ul></div></div>';
    }

    public function modelUrl()
    {
        return explode('/', trim(Url::current(), '/'))[0];
    }

    public function renderHeaderCellContent()
    {
        return $this->columnHeader;
    }

}